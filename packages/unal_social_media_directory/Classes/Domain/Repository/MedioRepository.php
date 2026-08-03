<?php
namespace UNAL\UnalSocialMediaDirectory\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Pedro Daniel Valero Rueda <pvaleror@gmail.com>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package unal_social_media_directory
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class MedioRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * @param integer $defaultAccount
	 */
  public function findAvaible($defaultAccount){
		$ms = $this->getAvaible($defaultAccount);
		$query = $this->createQuery();
		/*return $query->matching(
					$query->in('uid',$ms)
				)
				->execute();*/
				
				return $query
				->execute();
	}
	
	/**
	 * @param integer $defaultAccount
	 */
	private function getAvaible($defaultAccount){
		$query = $this->createQuery();
		
		
		//$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		$sql = 'SELECT distinct(medios) as m from tx_unalsocialmediadirectory_domain_model_cuenta WHERE dependencia !='.$defaultAccount;
		$query->statement($sql);
		$mds=$query->execute();
		
		
		
		$arr = Array();
		foreach($mds as $m){
		  var_dump($m->getUid());
			$arr[]=$m->m;
		}
		return $arr;
	}	
}
?>
