<?php

declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Domain\Model;


/**
 * This file is part of the "UNAL Social Media" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2021 
 */

/**
 * Cuenta
 */
class Cuenta extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * nombreCuenta
     *
     * @var string
     */
    protected $nombreCuenta = '';

    /**
     * tipo
     *
     * @var string
     */
    protected $tipo = '';

    /**
     * url
     *
     * @var string
     */
    protected $url = '';

    /**
     * medios
     *
     * @var \UNAL\UnalSocialMedia\Domain\Model\Medio
     */
    protected $medios = null;

    /**
     * responsable
     *
     * @var \UNAL\UnalSocialMedia\Domain\Model\Responsable
     */
    protected $responsable = null;

    /**
     * Returns the nombreCuenta
     *
     * @return string $nombreCuenta
     */
    public function getNombreCuenta()
    {
        return $this->nombreCuenta;
    }

    /**
     * Sets the nombreCuenta
     *
     * @param string $nombreCuenta
     * @return void
     */
    public function setNombreCuenta(string $nombreCuenta)
    {
        $this->nombreCuenta = $nombreCuenta;
    }

    /**
     * Returns the tipo
     *
     * @return string $tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Sets the tipo
     *
     * @param string $tipo
     * @return void
     */
    public function setTipo(string $tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Returns the url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url
     *
     * @param string $url
     * @return void
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * Returns the medios
     *
     * @return \UNAL\UnalSocialMedia\Domain\Model\Medio medios
     */
    public function getMedios()
    {
        return $this->medios;
    }

    /**
     * Sets the medios
     *
     * @param \UNAL\UnalSocialMedia\Domain\Model\Medio $medios
     * @return void
     */
    public function setMedios(\UNAL\UnalSocialMedia\Domain\Model\Medio $medios)
    {
        $this->medios = $medios;
    }

    /**
     * Returns the responsable
     *
     * @return \UNAL\UnalSocialMedia\Domain\Model\Responsable responsable
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Sets the responsable
     *
     * @param \UNAL\UnalSocialMedia\Domain\Model\Responsable $responsable
     * @return void
     */
    public function setResponsable(\UNAL\UnalSocialMedia\Domain\Model\Responsable $responsable)
    {
        $this->responsable = $responsable;
    }
}
