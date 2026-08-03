<?php
namespace UNAL\UnalNews\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;


/***
 *
 * This file is part of the "UNAL News extension" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Oficina de Medios DIgitales - Unimedios <mediosdigitales@unal.edu.co>, Universidad Nacional de Colombia
 *           Martha Lucía Chaves Muñoz <mlchavezm@unal.edu.co>, Universidad Nacional de Colombia
 *           César Hansy Dueñas Barragán <chduenasba@unal.edu.co>, Universidad Nacional de Colombia
 *
 ***/
/**
 * The repository for UnalNews
 */
class UnalNewsRepository extends \GeorgRinger\News\Domain\Repository\NewsRepository
{

    /**
     * @var array
     */
    protected $defaultOrderings = ['sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING];
    public function createQuery()
    {
        $query = parent::createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        return $query;
    }
    public function total()
    {
        return $this->findAll()->count();
    }

    /**
     * @param $page
     * @param $size
     */
    public function paginated($page = 1, $size = 9)
    {
        $query = $this->createQuery();
        $begin = ($page - 1) * $size;
        $query->setOffset($begin);
        $query->setLimit($size);
        return $query->execute();
    }

    /**
     * @param $size
     */
    public function getRelated($size = 3)
    {
        $query = $this->createQuery();
        $query->setLimit($size);
        return $query->execute();
    }

     /**
     * @param $search
     */
    public function getData($search)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_news_domain_model_news');
        $statement = $queryBuilder
        ->select('tx_news_domain_model_news.title')
        ->from('tx_news_domain_model_news')
        ->where($queryBuilder
            ->expr()
            ->like('tx_news_domain_model_news.title','"%'.$search.'%"'))
            ->setMaxResults( 10 )
        ->execute();
        return $statement->fetchAll();
    }

    /**
     * @param $spaceTime
     */
    public function getMostViewed($spaceTime)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_unalnews_domain_model_visitcounter');
        $statement = $queryBuilder->select('tx_unalnews_domain_model_visitcounter.unalnews')->addSelectLiteral($queryBuilder->expr()->sum('tx_unalnews_domain_model_visitcounter.quantity', 'viewers'))->from('tx_unalnews_domain_model_visitcounter')->where($queryBuilder->expr()->gte('tx_unalnews_domain_model_visitcounter.fecha_registro', (int) $spaceTime))->groupBy('tx_unalnews_domain_model_visitcounter.unalnews')->orderBy('viewers', 'desc')->setMaxResults(12)->execute();

        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($queryBuilder->getSQL());
        return $statement->fetchAll();
    }

    // ----------  Functions for Buscador de convergencia --------------------
    /**
     * @param $timestamp
     */
    public function getDeleted($timestamp)
    {
        $query = $this->createQuery();
        $result = $query->statement('SELECT * FROM tx_news_domain_model_news WHERE tstamp>=' . $timestamp . ' AND (deleted=1 OR hidden=1 )');
        return $query->execute();
    }

    /**
     * @param $timestamp
     */
    public function getEdited($timestamp)
    {
        $query = $this->createQuery();
        $result = $query->statement('SELECT * FROM tx_news_domain_model_news WHERE tstamp>=' . $timestamp . ' AND (deleted=0 AND hidden=0 )');
        return $query->execute();
    }
}
