<?php
namespace UNAL\UnalBase\Utility;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Martha Janeth Angarita Reyes <mjangaritar@unal.edu.co>, Universidad Nacional de Colombia
 *           Giovanni Romero Pérez <gromerop@unal.edu.co>, Universidad Nacional de Colombia
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
 * ************************************************************* */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use UNAL\UnalBase\Domain\Repository\DependenciaRepository;

/**
 * Utilidad para los mensajes de correo electrónico
 */

class IdsSubDependencias {
	
	private static $dependenciaRepository = null;
	
	private static function getTree(&$tree, $uidStart) {
		$dependencias = static::getDependenciaRepository()->findByIdSuperior($uidStart);
		foreach ($dependencias as $dependencia) {
			$tree[] = $dependencia->getUid();
			static::getTree($tree, $dependencia->getUid());
		}
	}
	
	static function get ($uid) {
		$ids = array();
		$ids[] = $uid;
		static::getTree($ids, $uid);
		return $ids;
	}
	
	private static function getDependenciaRepository() {
		if (NULL === static::$dependenciaRepository) {
			$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
			static::$dependenciaRepository = $objectManager->get(DependenciaRepository::class);
		}
		return static::$dependenciaRepository;
	}
	
}
