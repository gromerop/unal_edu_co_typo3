<?php

declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Domain\Repository;

/**
 * This file is part of the "UNAL Social Media" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2021 
 */

/**
 * The repository for Medios
 */
class MedioRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
    
    public function createQuery() {
        $query = parent::createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        return $query;
    }

    /**
     * 
     */
    public function findAvaible() {
//		$ms = $this->getAvaible($defaultAccount);
        $query = $this->createQuery();
        /* return $query->matching(
          $query->in('uid',$ms)
          )
          ->execute(); */

        return $query
                        ->execute();
    }

    /**
     * @param integer $defaultAccount
     */
    private function getAvaible($defaultAccount) {
        $query = $this->createQuery();

        //$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $sql = 'SELECT distinct(medios) as m from tx_unalsocialmedia_domain_model_cuenta WHERE dependencia !=' . $defaultAccount;
        $query->statement($sql);
        $mds = $query->execute();

        $arr = Array();
        foreach ($mds as $m) {
            $arr[] = $m->m;
        }
        return $arr;
    }
}
