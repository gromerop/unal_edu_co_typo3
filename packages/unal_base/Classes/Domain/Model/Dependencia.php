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
 * Dependencia
 */
class Dependencia extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Nombre de la dependencia
     *
     * @var string
     */
    protected $nombre = '';

    /**
     * UID de la dependencia de nivel superior. 0 indica que la dependencia es de
     * primer nivel.
     *
     * @var int
     */
    protected $idSuperior = 0;

    /**
     * email
     *
     * @var string
     */
    protected $email = '';

    /**
     * Si su valor es 1, el nombre deberá ocultarse en la papelería institucional.
     *
     * @var bool
     */
    protected $ocultarEnPapeleria = false;

    /**
     * direccion
     *
     * @var string
     */
    protected $direccion = '';

    /**
     * edificioPiso
     *
     * @var string
     */
    protected $edificioPiso = '';

    /**
     * ciudad
     *
     * @var string
     */
    protected $ciudad = '';

    /**
     * telefono
     *
     * @var string
     */
    protected $telefono = false;

    /**
     * Código asignado por la Oficina Nacional de Gestión y Patrimonio Documental,
     * mediante la Resolución 621 de 2016 de Rectoría.
     *
     * @var string
     */
    protected $codigo = '';

    /**
     * Acto administrativo por el cual se creó la dependencia.
     *
     * @var string
     */
    protected $actoAdmin = '';

    /**
     * Indica si un registro corresponde o no a una excepción (proyecto, programa,
     * campaña u otro registro que no corresponde a una dependencia como tal).
     *
     * @var bool
     */
    protected $excepcion = false;

    /**
     * Indica si el nombre de la dependencia debe ponerse en el encabezado. Esto aplica
     * sólo si el nivel es mayor que 3.
     *
     * @var bool
     */
    protected $ponerNombreEnEncabezado = false;

    /**
     * txtJerarquia
     *
     * @var string
     */
    protected $txtJerarquia = '';

    /**
     * Ocultar de los selectores sin afectar la disponibilidad de la dependencia en
     * reportes.
     *
     * @var bool
     */
    protected $ocultar = false;

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
     * Returns the idSuperior
     *
     * @return int $idSuperior
     */
    public function getIdSuperior()
    {
        return $this->idSuperior;
    }

    /**
     * Sets the idSuperior
     *
     * @param int $idSuperior
     * @return void
     */
    public function setIdSuperior($idSuperior)
    {
        $this->idSuperior = $idSuperior;
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
     * Returns the ocultarEnPapeleria
     *
     * @return bool $ocultarEnPapeleria
     */
    public function getOcultarEnPapeleria()
    {
        return $this->ocultarEnPapeleria;
    }

    /**
     * Sets the ocultarEnPapeleria
     *
     * @param bool $ocultarEnPapeleria
     * @return void
     */
    public function setOcultarEnPapeleria($ocultarEnPapeleria)
    {
        $this->ocultarEnPapeleria = $ocultarEnPapeleria;
    }

    /**
     * Returns the boolean state of ocultarEnPapeleria
     *
     * @return bool
     */
    public function isOcultarEnPapeleria()
    {
        return $this->ocultarEnPapeleria;
    }

    /**
     * Returns the direccion
     *
     * @return string $direccion
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Sets the direccion
     *
     * @param string $direccion
     * @return void
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * Returns the edificioPiso
     *
     * @return string $edificioPiso
     */
    public function getEdificioPiso()
    {
        return $this->edificioPiso;
    }

    /**
     * Sets the edificioPiso
     *
     * @param string $edificioPiso
     * @return void
     */
    public function setEdificioPiso($edificioPiso)
    {
        $this->edificioPiso = $edificioPiso;
    }

    /**
     * Returns the ciudad
     *
     * @return string $ciudad
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Sets the ciudad
     *
     * @param string $ciudad
     * @return void
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }

    /**
     * Returns the boolean state of telefono
     *
     * @return bool
     */
    public function isTelefono()
    {
        return $this->telefono;
    }

    /**
     * Returns the telefono
     *
     * @return string telefono
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Sets the telefono
     *
     * @param bool $telefono
     * @return void
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * Returns the codigo
     *
     * @return string $codigo
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Sets the codigo
     *
     * @param string $codigo
     * @return void
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Returns the actoAdmin
     *
     * @return string $actoAdmin
     */
    public function getActoAdmin()
    {
        return $this->actoAdmin;
    }

    /**
     * Sets the actoAdmin
     *
     * @param string $actoAdmin
     * @return void
     */
    public function setActoAdmin($actoAdmin)
    {
        $this->actoAdmin = $actoAdmin;
    }

    /**
     * Returns the excepcion
     *
     * @return bool $excepcion
     */
    public function getExcepcion()
    {
        return $this->excepcion;
    }

    /**
     * Sets the excepcion
     *
     * @param bool $excepcion
     * @return void
     */
    public function setExcepcion($excepcion)
    {
        $this->excepcion = $excepcion;
    }

    /**
     * Returns the boolean state of excepcion
     *
     * @return bool
     */
    public function isExcepcion()
    {
        return $this->excepcion;
    }

    /**
     * Returns the ponerNombreEnEncabezado
     *
     * @return bool $ponerNombreEnEncabezado
     */
    public function getPonerNombreEnEncabezado()
    {
        return $this->ponerNombreEnEncabezado;
    }

    /**
     * Sets the ponerNombreEnEncabezado
     *
     * @param bool $ponerNombreEnEncabezado
     * @return void
     */
    public function setPonerNombreEnEncabezado($ponerNombreEnEncabezado)
    {
        $this->ponerNombreEnEncabezado = $ponerNombreEnEncabezado;
    }

    /**
     * Returns the boolean state of ponerNombreEnEncabezado
     *
     * @return bool
     */
    public function isPonerNombreEnEncabezado()
    {
        return $this->ponerNombreEnEncabezado;
    }

    /**
     * Returns the txtJerarquia
     *
     * @return string $txtJerarquia
     */
    public function getTxtJerarquia()
    {
        return $this->txtJerarquia;
    }

    /**
     * Sets the txtJerarquia
     *
     * @param string $txtJerarquia
     * @return void
     */
    public function setTxtJerarquia($txtJerarquia)
    {
        $this->txtJerarquia = $txtJerarquia;
    }

    /**
     * Returns the ocultar
     *
     * @return bool $ocultar
     */
    public function getOcultar()
    {
        return $this->ocultar;
    }

    /**
     * Sets the ocultar
     *
     * @param bool $ocultar
     * @return void
     */
    public function setOcultar($ocultar)
    {
        $this->ocultar = $ocultar;
    }

    /**
     * Returns the boolean state of ocultar
     *
     * @return bool
     */
    public function isOcultar()
    {
        return $this->ocultar;
    }
}
