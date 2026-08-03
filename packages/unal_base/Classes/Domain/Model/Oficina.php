<?php
namespace UNAL\UnalBase\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Oficina de Medios Digitales - Unimedios <mediosdigitales@unal.edu.co>, Universidad Nacional de Colombia
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
 ***************************************************************/

/***
 *
 * This file is part of the "Extensión base - Universidad Nacional de Colombia" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Oficina de Medios Digitales - Unimedios <mediosdigitales@unal.edu.co>, Universidad Nacional de Colombia
 *           Giovanni Romero Pérez <gromerop@unal.edu.co>, Universidad Nacional de Colombia
 *
 ***/

/**
 * Oficina
 */
class Oficina extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * nombre
     *
     * @var string
     * @validate NotEmpty
     */
    protected $nombre = '';

    /**
     * extension
     *
     * @var string
     */
    protected $extension = '';

    /**
     * email
     *
     * @var string
     */
    protected $email = '';

    /**
     * dependencia
     *
     * @var \UNAL\UnalBase\Domain\Model\Dependencia
     */
    protected $dependencia = null;

    /**
     * Returns the nombre
     *
     * @return string $nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Sets the nombre
     *
     * @param string $nombre
     * @return void
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Returns the extension
     *
     * @return string $extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Sets the extension
     *
     * @param string $extension
     * @return void
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * Returns the email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the dependencia
     *
     * @return \UNAL\UnalBase\Domain\Model\Dependencia $dependencia
     */
    public function getDependencia()
    {
        return $this->dependencia;
    }

    /**
     * Sets the dependencia
     *
     * @param \UNAL\UnalBase\Domain\Model\Dependencia $dependencia
     * @return void
     */
    public function setDependencia(\UNAL\UnalBase\Domain\Model\Dependencia $dependencia)
    {
        $this->dependencia = $dependencia;
    }
}
