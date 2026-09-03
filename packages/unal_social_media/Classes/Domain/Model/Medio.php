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
 * Medio
 */
class Medio extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * nombre
     *
     * @var string
     */
    protected $nombre = '';

    /**
     * icono
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $icono = null;

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
     * Returns the icono
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $icono
     */
    public function getIcono()
    {
        return $this->icono;
    }

    /**
     * Sets the icono
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $icono
     * @return void
     */
    public function setIcono(\TYPO3\CMS\Extbase\Domain\Model\FileReference $icono)
    {
        $this->icono = $icono;
    }
}
