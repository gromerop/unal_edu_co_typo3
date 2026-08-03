<?php
namespace UNAL\UnalSocialMediaDirectory\Domain\Model;

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
class Facultad extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject {

	/**
	 * nombre
	 *
	 * @var \string
	 * @TYPO3\CMS\Extbase\Annotation\Validate NotEmpty
	 */
	protected $nombre;

	/**
	 * sede
	 *
	 * @var \UNAL\UnalSocialMediaDirectory\Domain\Model\Sede
	 * @lazy
	 */
	protected $sede;

	/**
	 * Returns the nombre
	 *
	 * @return \string $nombre
	 */
	public function getNombre() {
		return $this->nombre;
	}

	/**
	 * Sets the nombre
	 *
	 * @param \string $nombre
	 * @return void
	 */
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}

	/**
	 * Returns the sede
	 *
	 * @return \UNAL\UnalSocialMediaDirectory\Domain\Model\Sede $sede
	 */
	public function getSede() {
		return $this->sede;
	}

	/**
	 * Sets the sede
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Sede $sede
	 * @return void
	 */
	public function setSede(\UNAL\UnalSocialMediaDirectory\Domain\Model\Sede $sede) {
		$this->sede = $sede;
	}

}
?>ve the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->cuentas = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		
		$this->otrasCuentas = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the nombre
	 *
	 * @return \string $nombre
	 */
	public function getNombre() {
		return $this->nombre;
	}

	/**
	 * Sets the nombre
	 *
	 * @param \string $nombre
	 * @return void
	 */
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	
	/**
	 * Returns the descripcion
	 *
	 * @return \string $descripcion
	 */
	public function getDescripcion() {
		return $this->descripcion;
	}

	/**
	 * Sets the descripcion
	 *
	 * @param \string $descripcion
	 * @return void
	 */
	public function setDescripcion($descripcion) {
		$this->descripcion = $descripcion;
	}

	/**
	 * Returns the facultad
	 *
	 * @return \UNAL\UnalSocialMediaDirectory\Domain\Model\Facultad $facultad
	 */
	public function getFacultad() {
		return $this->facultad;
	}

	/**
	 * Sets the facultad
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Facultad $facultad
	 * @return void
	 */
	public function setFacultad(\UNAL\UnalSocialMediaDirectory\Domain\Model\Facultad $facultad) {
		$this->facultad = $facultad;
	}

	/**
	 * Adds a Cuenta
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta $cuenta
	 * @return void
	 */
	public function addCuenta(\UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta $cuenta) {
		$this->cuentas->attach($cuenta);
	}

	/**
	 * Removes a Cuenta
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta $cuentaToRemove The Cuenta to be removed
	 * @return void
	 */
	public function removeCuenta(\UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta $cuentaToRemove) {
		$this->cuentas->detach($cuentaToRemove);
	}

	/**
	 * Returns the cuentas
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta> $cuentas
	 */
	public function getCuentas() {
		return $this->cuentas;
	}

	/**
	 * Sets the cuentas
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta> $cuentas
	 * @return void
	 */
	public function setCuentas(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $cuentas) {
		$this->cuentas = $cuentas;
	}

	/**
	 * Returns the sede
	 *
	 * @return \UNAL\UnalSocialMediaDirectory\Domain\Model\Sede $sede
	 */
	public function getSede() {
		return $this->sede;
	}

	/**
	 * Sets the sede
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Sede $sede
	 * @return void
	 */
	public function setSede(\UNAL\UnalSocialMediaDirectory\Domain\Model\Sede $sede) {
		$this->sede = $sede;
	}

	/**
	 * Adds a Cuenta
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta $otrasCuenta
	 * @return void
	 */
	public function addOtrasCuenta(\UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta $otrasCuenta) {
		$this->otrasCuentas->attach($otrasCuenta);
	}

	/**
	 * Removes a Cuenta
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta $otrasCuentaToRemove The Cuenta to be removed
	 * @return void
	 */
	public function removeOtrasCuenta(\UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta $otrasCuentaToRemove) {
		$this->otrasCuentas->detach($otrasCuentaToRemove);
	}

	/**
	 * Returns the otrasCuentas
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta> $otrasCuentas
	 */
	public function getOtrasCuentas() {
		return $this->otrasCuentas;
	}

	/**
	 * Sets the otrasCuentas
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalSocialMediaDirectory\Domain\Model\Cuenta> $otrasCuentas
	 * @return void
	 */
	public function setOtrasCuentas(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $otrasCuentas) {
		$this->otrasCuentas = $otrasCuentas;
	}

}
?>
