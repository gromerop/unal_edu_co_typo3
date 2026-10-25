<?php
namespace Unal\Unal160\DataProcessing;

use GeorgRinger\News\Domain\Repository\NewsRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

final class StoriesProcessor implements DataProcessorInterface
{
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData): array
    {
        $config = GeneralUtility::xml2array($processedData['data']['pi_flexform'] ?? '');
        $fields = is_array($config) ? ($config['data']['sDEF']['lDEF'] ?? []) : [];
        $category = (int)($fields['category']['vDEF'] ?? 82) ?: 82;
        $root = (int)($fields['storagePid']['vDEF'] ?? 531) ?: 531;
        $pool = GeneralUtility::makeInstance(ConnectionPool::class);
        // Incluye la carpeta raíz únicamente si está visible para este visitante.
        $q = $pool->getQueryBuilderForTable('pages');
        $q->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
        $pids = array_map('intval', $q->select('uid')->from('pages')->where($q->expr()->eq('uid', $root))->executeQuery()->fetchFirstColumn());
        $frontier = $pids;
        while ($frontier) {
            $q = $pool->getQueryBuilderForTable('pages');
            $q->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
            $children = $q->select('uid')->from('pages')->where($q->expr()->in('pid', $frontier))->executeQuery()->fetchFirstColumn();
            $frontier = array_values(array_diff(array_map('intval', $children), $pids));
            $pids = array_merge($pids, $frontier);
        }
        $processedData['featuredStory'] = null;
        $processedData['previousStories'] = [];
        if (!$pids) { return $processedData; }
        $q = $pool->getQueryBuilderForTable('tx_news_domain_model_news');
        $q->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
        $rows = $q->selectLiteral('DISTINCT n.uid', 'n.datetime')->from('tx_news_domain_model_news', 'n')
            ->innerJoin('n', 'sys_category_record_mm', 'mm', 'mm.uid_foreign = n.uid')
            ->where($q->expr()->in('n.pid', $pids), $q->expr()->in('n.sys_language_uid', [-1, 0]),
                $q->expr()->eq('mm.uid_local', $category),
                $q->expr()->eq('mm.tablenames', $q->createNamedParameter('tx_news_domain_model_news')),
                $q->expr()->eq('mm.fieldname', $q->createNamedParameter('categories')),
                $q->expr()->lte('n.datetime', (int)($GLOBALS['EXEC_TIME'] ?? time())))
            ->orderBy('n.datetime', 'DESC')->addOrderBy('n.uid', 'DESC')->executeQuery()->fetchAllAssociative();
        $records = [];
        if ($rows) {
            $query = GeneralUtility::makeInstance(NewsRepository::class)->createQuery();
            $settings = clone $query->getQuerySettings();
            $settings->setRespectStoragePage(false);
            $query->setQuerySettings($settings);
            $query->matching($query->in('uid', array_column($rows, 'uid')));
            foreach ($query->execute() as $news) { $records[$news->getUid()] = $news; }
        }
        $stories = [];
        foreach ($rows as $row) {
            $news = $records[(int)$row['uid']] ?? null;
            if (!$news) { continue; }
            $image = null;
            // La miniatura corresponde al primer medio en el orden editorial.
            // No buscar otra imagen ni priorizar la marca de vista previa.
            foreach ($news->getFalMedia() as $media) {
                $resource = $media->getOriginalResource();
                if ((int)$resource->getOriginalFile()->getType() === 2) { $image = $resource; }
                break;
            }
            $url = trim((string)$news->getExternalurl());
            if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array(strtolower((string)parse_url($url, PHP_URL_SCHEME)), ['http', 'https'], true)) { $url = ''; }
            $stories[] = ['uid'=>$news->getUid(), 'title'=>$news->getTitle(), 'image'=>$image, 'url'=>$url];
        }
        $processedData['featuredStory'] = array_shift($stories);
        $processedData['previousStories'] = $stories;
        // Consultas personalizadas: limitar también cachés vacías y cambios programados.
        $cacheCollector = $cObj->getRequest()->getAttribute('frontend.cache.collector');
        if ($cacheCollector !== null) {
            $lifetime = 300;
            $cacheCollector->addCacheTags(
                new \TYPO3\CMS\Core\Cache\CacheTag('tx_news_domain_model_news', $lifetime),
                new \TYPO3\CMS\Core\Cache\CacheTag('sys_category', $lifetime),
                new \TYPO3\CMS\Core\Cache\CacheTag('pages', $lifetime),
            );
        }
        return $processedData;
    }
}
