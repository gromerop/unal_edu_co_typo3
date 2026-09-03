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
 * The repository for Cuentas
 */
class CuentaRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
    public function createQuery() {
        $query = parent::createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        return $query;
    }
}
