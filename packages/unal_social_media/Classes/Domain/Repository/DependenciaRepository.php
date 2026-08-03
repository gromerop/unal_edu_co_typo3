<?php

declare(strict_types=1);

namespace Unal\UnalSocialMedia\Domain\Repository;


/**
 * This file is part of the "UNAL Social Media" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2021 
 */

/**
 * The repository for Dependencias
 */
class DependenciaRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function findAvailable(){
		$query = $this->createQuery();
		
		
		$sql = 'SELECT * from tx_unalsocialmedia_domain_model_dependencia WHERE deleted = 0 and nombre != " "';
		$query->statement($sql);
		$dependencia=$query->execute();
		
		return $dependencia;
	}	
}
