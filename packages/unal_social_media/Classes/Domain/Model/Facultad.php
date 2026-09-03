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
 * Facultad
 */
class Facultad extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * nombre
     *
     * @var string
     */
    protected $nombre = '';

    /**
     * sede
     *
     * @var \UNAL\UnalSocialMedia\Domain\Model\Sede
     */
    protected $sede = null;

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
