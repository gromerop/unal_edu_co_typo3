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
class Responsable extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * nombre
	 *
	 * @var \string
	 * @TYPO3\CMS\Extbase\Annotation\Validate NotEmpty
	 */
	protected $nombre;

	/**
	 * apellidos
	 *
	 * @var \string
	 * @TYPO3\CMS\Extbase\Annotation\Validate NotEmpty
	 */
	protected $apellidos;

	/**
	 * telefono
	 *
	 * @var \string
	 */
	protected $telefono;

	/**
	 * extension
	 *
	 * @var \string
	 */
	protected $extension;

	/**
	 * email
	 *
	 * @var \string
	 * @TYPO3\CMS\Extbase\Annotation\Validate NotEmpty
	 */
	protected $email;

	/**
	 * cargo
	 *
	 * @var \string
	 * @TYPO3\CMS\Extbase\Annotation\Validate NotEmpty
	 */
	protected $cargo;

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
	 * Returns the apellidos
	 *
	 * @return \string $apellidos
	 */
	public function getApellidos() {
		return $this->apellidos;
	}

	/**
	 * Sets the apellidos
	 *
	 * @param \string $apellidos
	 * @return void
	 */
	public function setApellidos($apellidos) {
		$this->apellidos = $apellidos;
	}

	/**
	 * Returns the telefono
	 *
	 * @return \string $telefono
	 */
	public function getTelefono() {
		return $this->telefono;
	}

	/**
	 * Sets the telefono
	 *
	 * @param \string $telefono
	 * @return void
	 */
	public function setTelefono($telefono) {
		$this->telefono = $telefono;
	}

	/**
	 * Returns the extension
	 *
	 * @return \string $extension
	 */
	public function getExtension() {
		return $this->extension;
	}

	/**
	 * Sets the extension
	 *
	 * @param \string $extension
	 * @return void
	 */
	public function setExtension($extension) {
		$this->extension = $extension;
	}

	/**
	 * Returns the email
	 *
	 * @return \string $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets the email
	 *
	 * @param \string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns the cargo
	 *
	 * @return \string $cargo
	 */
	public function getCargo() {
		return $this->cargo;
	}

	/**
	 * Sets the cargo
	 *
	 * @param \string $cargo
	 * @return void
	 */
	public function setCargo($cargo) {
		$this->cargo = $cargo;
	}

}
?>