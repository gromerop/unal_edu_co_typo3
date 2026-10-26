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
 * Dependencia
 */
class Dependencia extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * nombre
     *
     * @var string
     */
    protected $nombre = '';

    /**
     * facultad
     *
     * @var \UNAL\UnalSocialMedia\Domain\Model\Facultad
     */
    protected $facultad = null;

    /**
     * cuentas
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalSocialMedia\Domain\Model\Cuenta>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $cuentas = null;

    /**
     * sede
     *
     * @var \UNAL\UnalSocialMedia\Domain\Model\Sede
     */
    protected $sede = null;

    /**
     * __construct
     */
    public function __construct()
    {

        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->cuentas = $this->cuentas ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

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
    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Returns the facultad
     *
     * @return \UNAL\UnalSocialMedia\Domain\Model\Facultad facultad
     */
    public function getFacultad()
    {
        return $this->facultad;
    }

    /**
     * Sets the facultad
     *
     * @param \UNAL\UnalSocialMedia\Domain\Model\Facultad $facultad
     * @return void
     */
    public function setFacultad(\UNAL\UnalSocialMedia\Domain\Model\Facultad $facultad)
    {
        $this->facultad = $facultad;
    }

    /**
     * Adds a Cuenta
     *
     * @param \UNAL\UnalSocialMedia\Domain\Model\Cuenta $cuenta
     * @return void
     */
    public function addCuenta(\UNAL\UnalSocialMedia\Domain\Model\Cuenta $cuenta)
    {
        $this->cuentas->attach($cuenta);
    }

    /**
     * Removes a Cuenta
     *
     * @param \UNAL\UnalSocialMedia\Domain\Model\Cuenta $cuentaToRemove The Cuenta to be removed
     * @return void
     */
    public function removeCuenta(\UNAL\UnalSocialMedia\Domain\Model\Cuenta $cuentaToRemove)
    {
        $this->cuentas->detach($cuentaToRemove);
    }

    /**
     * Returns the cuentas
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalSocialMedia\Domain\Model\Cuenta> cuentas
     */
    public function getCuentas()
    {
        return $this->cuentas;
    }

    /**
     * Sets the cuentas
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalSocialMedia\Domain\Model\Cuenta> $cuentas
     * @return void
     */
    public function setCuentas(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $cuentas)
    {
        $this->cuentas = $cuentas;
    }

    /**
     * Returns the sede
     *
     * @return \UNAL\UnalSocialMedia\Domain\Model\Sede sede
     */
    public function getSede()
    {
        return $this->sede;
    }

    /**
     * Sets the sede
     *
     * @param \UNAL\UnalSocialMedia\Domain\Model\Sede $sede
     * @return void
     */
    public function setSede(\UNAL\UnalSocialMedia\Domain\Model\Sede $sede)
    {
        $this->sede = $sede;
    }
}
