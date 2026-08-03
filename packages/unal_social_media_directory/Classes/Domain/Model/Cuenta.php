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
class Cuenta extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * nombreCuenta
	 *
	 * @var \string
	 * @TYPO3\CMS\Extbase\Annotation\Validate NotEmpty
	 */
	protected $nombreCuenta;

	/**
	 * tipo
	 *
	 * @var \string
	 * @TYPO3\CMS\Extbase\Annotation\Validate NotEmpty
	 */
	protected $tipo;

	/**
	 * url
	 *
	 * @var \string
	 * @TYPO3\CMS\Extbase\Annotation\Validate NotEmpty
	 */
	protected $url;

	/**
	 * medios
	 *
	 * @var \UNAL\UnalSocialMediaDirectory\Domain\Model\Medio
	 * @lazy
	 */
	protected $medios;

	/**
	 * responsable
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalSocialMediaDirectory\Domain\Model\Responsable>
	 * @lazy
	 */
	protected $responsable;

	/**
	 * __construct
	 *
	 * @return Cuenta
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
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
		$this->responsable = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the nombreCuenta
	 *
	 * @return \string $nombreCuenta
	 */
	public function getNombreCuenta() {
		return $this->nombreCuenta;
	}

	/**
	 * Sets the nombreCuenta
	 *
	 * @param \string $nombreCuenta
	 * @return void
	 */
	public function setNombreCuenta($nombreCuenta) {
		$this->nombreCuenta = $nombreCuenta;
	}

	/**
	 * Returns the tipo
	 *
	 * @return \string $tipo
	 */
	public function getTipo() {
		return $this->tipo;
	}

	/**
	 * Sets the tipo
	 *
	 * @param \string $tipo
	 * @return void
	 */
	public function setTipo($tipo) {
		$this->tipo = $tipo;
	}

	/**
	 * Returns the url
	 *
	 * @return \string $url
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Sets the url
	 *
	 * @param \string $url
	 * @return void
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * Returns the medios
	 *
	 * @return \UNAL\UnalSocialMediaDirectory\Domain\Model\Medio $medios
	 */
	public function getMedios() {
		return $this->medios;
	}

	/**
	 * Sets the medios
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Medio $medios
	 * @return void
	 */
	public function setMedios(\UNAL\UnalSocialMediaDirectory\Domain\Model\Medio $medios) {
		$this->medios = $medios;
	}

	/**
	 * Adds a Responsable
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Responsable $responsable
	 * @return void
	 */
	public function addResponsable(\UNAL\UnalSocialMediaDirectory\Domain\Model\Responsable $responsable) {
		$this->responsable->attach($responsable);
	}

	/**
	 * Removes a Responsable
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Responsable $responsableToRemove The Responsable to be removed
	 * @return void
	 */
	public function removeResponsable(\UNAL\UnalSocialMediaDirectory\Domain\Model\Responsable $responsableToRemove) {
		$this->responsable->detach($responsableToRemove);
	}

	/**
	 * Returns the responsable
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalSocialMediaDirectory\Domain\Model\Responsable> $responsable
	 */
	public function getResponsable() {
		return $this->responsable;
	}

	/**
	 * Sets the responsable
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalSocialMediaDirectory\Domain\Model\Responsable> $responsable
	 * @return void
	 */
	public function setResponsable(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $responsable) {
		$this->responsable = $responsable;
	}

}
?>