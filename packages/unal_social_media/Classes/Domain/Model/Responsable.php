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
 * Responsable
 */
class Responsable extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * nombre
     *
     * @var string
     */
    protected $nombre = '';

    /**
     * apellidos
     *
     * @var string
     */
    protected $apellidos = '';

    /**
     * telefono
     *
     * @var string
     */
    protected $telefono = '';

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
     * cargo
     *
     * @var string
     */
    protected $cargo = '';

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
     * Returns the apellidos
     *
     * @return string $apellidos
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Sets the apellidos
     *
     * @param string $apellidos
     * @return void
     */
    public function setApellidos(string $apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * Returns the telefono
     *
     * @return string $telefono
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Sets the telefono
     *
     * @param string $telefono
     * @return void
     */
    public function setTelefono(string $telefono)
    {
        $this->telefono = $telefono;
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
    public function setExtension(string $extension)
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
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Returns the cargo
     *
     * @return string $cargo
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Sets the cargo
     *
     * @param string $cargo
     * @return void
     */
    public function setCargo(string $cargo)
    {
        $this->cargo = $cargo;
    }
}
