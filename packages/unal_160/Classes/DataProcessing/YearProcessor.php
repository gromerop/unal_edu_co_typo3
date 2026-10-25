<?php
namespace Unal\Unal160\DataProcessing;

use Unal\Unal160\Service\CircularEvents;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
use GeorgRinger\News\Domain\Repository\NewsRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

final class YearProcessor implements DataProcessorInterface
{
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData): array
    {
        $definitions = [
            [70, "Octubre", 2026, "Ciencia, Tecnología e Innovación", "Images/Months/astronauta.svg"],
            [71, "Noviembre", 2026, "Arte y cultura", "Images/Months/caballete.svg"],
            [72, "Diciembre", 2026, "Patrimonio y memoria", "Images/Months/pesca.svg"],
            [73, "Enero", 2027, "Universidad de puertas abiertas", "Images/Months/tumaco.svg"],
            [74, "Febrero", 2027, "Somos UNAL", "Images/Months/sonyjimenezdetejada.svg"],
            [75, "Marzo", 2027, "Mujeres", "Images/Months/martatraba.svg"],
            [76, "Abril", 2027, "Espacios vivos", "Images/Months/sededelapaz.svg"],
            [77, "Mayo", 2027, "UNAL en el mundo", "Images/Months/mapamundi.svg"],
            [78, "Junio", 2027, "Desafíos de nuestros tiempos", "Images/Months/petri.svg"],
            [79, "Julio", 2027, "Nuestros personajes cotidianos", "Images/Months/atleta.svg"],
            [80, "Agosto", 2027, "UNAL en el futuro", "Images/Months/marsresearchenutah.svg"],
            [81, "Septiembre", 2027, "Cierre 160", "Images/Months/biblioteca-ggm-bogota.svg"]
        ];
        $types = [
            [66, 'Prensa', 'Para leer'],
            [67, 'Videos', 'Para ver'],
            [68, 'Radio', 'Para escuchar'],
            [69, 'Agencia', 'Agencia']
        ];
        $pool = GeneralUtility::makeInstance(ConnectionPool::class);
        // Recorre las subcarpetas visibles sin imponer una profundidad fija.
        $pids = [531];
        $frontier = [531];
        while ($frontier) {
            $q = $pool->getQueryBuilderForTable('pages');
            $q->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
            $rows = $q->select('uid')->from('pages')->where($q->expr()->in('pid', $frontier))->executeQuery()->fetchAllAssociative();
            $frontier = [];
            foreach ($rows as $row) {
                $uid = (int)$row['uid'];
                if (!in_array($uid, $pids, true)) { $pids[] = $uid; $frontier[] = $uid; }
            }
        }
        $q = $pool->getQueryBuilderForTable('tx_news_domain_model_news');
        $q->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
        $rows = $q->select('n.uid', 'n.title', 'n.datetime', 'n.externalurl', 'n.type', 'n.bodytext')
            ->from('tx_news_domain_model_news', 'n')
            ->innerJoin('n', 'sys_category_record_mm', 'mm', 'mm.uid_foreign = n.uid')
            ->where($q->expr()->in('n.pid', $pids),
                $q->expr()->in('n.sys_language_uid', [-1, 0]),
                $q->expr()->eq('mm.uid_local', 63),
                $q->expr()->eq('mm.tablenames', $q->createNamedParameter('tx_news_domain_model_news')),
                $q->expr()->eq('mm.fieldname', $q->createNamedParameter('categories')))
            ->orderBy('n.datetime', 'DESC')->addOrderBy('n.uid', 'DESC')
            ->executeQuery()->fetchAllAssociative();
        $categories = [];
        if ($rows) {
            $q = $pool->getQueryBuilderForTable('sys_category_record_mm');
            $relations = $q->select('uid_foreign', 'uid_local')->from('sys_category_record_mm')
                ->where($q->expr()->in('uid_foreign', array_column($rows, 'uid')),
                    $q->expr()->eq('tablenames', $q->createNamedParameter('tx_news_domain_model_news')),
                    $q->expr()->eq('fieldname', $q->createNamedParameter('categories')))
                ->executeQuery()->fetchAllAssociative();
            foreach ($relations as $relation) {
                $categories[(int)$relation['uid_foreign']][] = (int)$relation['uid_local'];
            }
        }
        $cards = [];
        foreach ($rows as $row) {
            $uid = (int)$row['uid'];
            $url = trim((string)$row['externalurl']);
            // Aceptar únicamente destinos web externos.
            $row['url'] = filter_var($url, FILTER_VALIDATE_URL) && in_array(strtolower((string)parse_url($url, PHP_URL_SCHEME)), ['http', 'https'], true) ? $url : '';
            $row['opensTextModal'] = (int)$row['type'] === 0;
            if ($row['opensTextModal']) { $row['url'] = ''; }
            $row['image'] = null;
            $cards[$uid] = $row;
        }
        $circular = GeneralUtility::makeInstance(CircularEvents::class);
        $months = [];
        $hasSelected = false;
        $modalNews = [];
        foreach ($definitions as [$category, $name, $year, $theme, $illustration]) {
            $tabs = [];
            $calendarMonth = sprintf('%04d-%02d', $year, (($category - 70 + 9) % 12) + 1);
            $events = $circular->forMonth($calendarMonth);
            if ($events) {
                $tabs[] = ['id'=>'agenda', 'label'=>'Para que te agendes', 'description'=>'Para que te agendes', 'items'=>$events, 'active'=>true, 'isAgenda'=>true];
            }
            foreach ($types as [$type, $label, $description]) {
                $items = [];
                foreach ($cards as $uid => $card) {
                    $assigned = $categories[$uid] ?? [];
                    if (in_array($category, $assigned, true) && in_array($type, $assigned, true)) {
                        $items[] = $card;
                        if ($card['opensTextModal']) { $modalNews[$uid] = $card; }
                    }
                }
                if ($items) { $tabs[] = ['id'=>$type, 'label'=>$label, 'description'=>$description, 'items'=>$items, 'active'=>!$tabs]; }
            }
            $active = !$hasSelected && (bool)$tabs;
            if ($active) { $hasSelected = true; }
            $months[] = ['id'=>$category, 'name'=>$name, 'year'=>$year, 'theme'=>$theme, 'illustration'=>$illustration, 'tabs'=>$tabs, 'enabled'=>(bool)$tabs, 'active'=>$active];
        }
        // Respeta los límites editoriales y la fecha de actualización de Circular.
        $cacheCollector = $cObj->getRequest()->getAttribute('frontend.cache.collector');
        if ($cacheCollector !== null) {
            $lifetime = max(1, min(300, $circular->refreshIn()));
            $cacheCollector->addCacheTags(
                new \TYPO3\CMS\Core\Cache\CacheTag('tx_news_domain_model_news', $lifetime),
                new \TYPO3\CMS\Core\Cache\CacheTag('sys_category', $lifetime),
                new \TYPO3\CMS\Core\Cache\CacheTag('pages', $lifetime),
            );
        }
        // Recupera los objetos de EXT:news para usar sus relaciones y visibilidad.
        $details = [];
        if ($modalNews) {
            $repository = GeneralUtility::makeInstance(NewsRepository::class);
            $query = $repository->createQuery();
            $settings = clone $query->getQuerySettings();
            $settings->setRespectStoragePage(false);
            $query->setQuerySettings($settings);
            $query->matching($query->in('uid', array_keys($modalNews)));
            foreach ($query->execute() as $news) {
                $details[] = ['uid'=>$news->getUid(), 'title'=>$news->getTitle(), 'record'=>$news];
            }
        }
        $processedData['modalNews'] = $details;
        $processedData['months'] = $months;
        $processedData['hasContent'] = $hasSelected;
        return $processedData;
    }
}
