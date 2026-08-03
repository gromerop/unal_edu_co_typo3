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
 * SolicitudDependencia
 */
class SolicitudDependencia extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * UID del usuario que hace la solicitud
     *
     * @var int
     * @validate NotEmpty
     */
    protected $solicitante = 0;

    /**
     * Nombre de la dependencia solicitada
     *
     * @var string
     * @validate NotEmpty
     */
    protected $nombreDependencia = '';

    /**
     * idSuperior
     *
     * @var int
     * @validate NotEmpty
     */
    protected $idSuperior = 0;

    /**
     * justificacion
     *
     * @var string
     * @validate NotEmpty
     */
    protected $justificacion = '';

    /**
     * archivo
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $archivo = null;

    /**
     * fechaRespuesta
     *
     * @var \DateTime
     */
    protected $fechaRespuesta = null;

    /**
     * idDependenciaCreada
     *
     * @var int
     */
    protected $idDependenciaCreada = 0;

    /**
     * Returns the solicitante
     *
     * @return int $solicitante
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * Sets the solicitante
     *
     * @param int $solicitante
     * @return void
     */
    public function setSolicitante($solicitante)
    {
        $this->solicitante = $solicitante;
    }

    /**
     * Returns the nombreDependencia
     *
     * @return string $nombreDependencia
     */
    public function getNombreDependencia()
    {
        return $this->nombreDependencia;
    }

    /**
     * Sets the nombreDependencia
     *
     * @param string $nombreDependencia
     * @return void
     */
    public function setNombreDependencia($nombreDependencia)
    {
        $this->nombreDependencia = $nombreDependencia;
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
     * Returns the justificacion
     *
     * @return string $justificacion
     */
    public function getJustificacion()
    {
        return $this->justificacion;
    }

    /**
     * Sets the justificacion
     *
     * @param string $justificacion
     * @return void
     */
    public function setJustificacion($justificacion)
    {
        $this->justificacion = $justificacion;
    }

    /**
     * Returns the archivo
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $archivo
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Sets the archivo
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $archivo
     * @return void
     */
    public function setArchivo(\TYPO3\CMS\Extbase\Domain\Model\FileReference $archivo)
    {
        $this->archivo = $archivo;
    }

    /**
     * Returns the fechaRespuesta
     *
     * @return \DateTime $fechaRespuesta
     */
    public function getFechaRespuesta()
    {
        return $this->fechaRespuesta;
    }

    /**
     * Sets the fechaRespuesta
     *
     * @param \DateTime $fechaRespuesta
     * @return void
     */
    public function setFechaRespuesta(\DateTime $fechaRespuesta)
    {
        $this->fechaRespuesta = $fechaRespuesta;
    }

    /**
     * Returns the idDependenciaCreada
     *
     * @return int $idDependenciaCreada
     */
    public function getIdDependenciaCreada()
    {
        return $this->idDependenciaCreada;
    }

    /**
     * Sets the idDependenciaCreada
     *
     * @param int $idDependenciaCreada
     * @return void
     */
    public function setIdDependenciaCreada($idDependenciaCreada)
    {
        $this->idDependenciaCreada = $idDependenciaCreada;
    }
}
