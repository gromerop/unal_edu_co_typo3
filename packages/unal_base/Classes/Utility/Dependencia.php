<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UNAL\UnalBase\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use UNAL\UnalBase\Domain\Repository\DependenciaRepository;

/**
 * Description of Dependencia
 *
 * @author desarrollo
 */
class Dependencia
{
	private static $dependenciaRepository = null;
	
	private static function getDependenciaRepository() {
		if (NULL === static::$dependenciaRepository) {
			$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
			static::$dependenciaRepository = $objectManager->get(DependenciaRepository::class);
		}
		return static::$dependenciaRepository;
	}
	
	/**
	 * Obtiene el ID de la sede a la cual pertenece la dependencia con el ID dado
	 * 
	 * @param int $idDependencia
	 * @return int
	 */
	static function getIdSede($idDependencia) {
		$idSede = -1;
		do {
			$dependencia = static::getDependenciaRepository()->findByUid($idDependencia);
			if ($dependencia->getIdSuperior() == 0) {
				 $idSede = $dependencia->getUid();
			} else {
				 $idDependencia = $dependencia->getIdSuperior();
			}
		} while ($idSede == -1);
		return $idSede;
	}
}
