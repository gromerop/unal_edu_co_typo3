<?php
namespace UNAL\UnalNews\Domain\Model;


/***
 *
 * This file is part of the "UNAL News extension" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Oficina de Medios DIgitales - Unimedios <mediosdigitales@unal.edu.co>, Universidad Nacional de Colombia
 *           Martha Lucía Chaves Muñoz <mlchavezm@unal.edu.co>, Universidad Nacional de Colombia
 *           César Hansy Dueñas Barragán <chduenasba@unal.edu.co>, Universidad Nacional de Colombia
 *
 ***/
/**
 * VisitCounter
 */
class VisitCounter extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Cantidad de visitas realizadas a la nota
     * 
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $quantity = 0;

    /**
     * Es el día con el total de visitas a una noticia
     * 
     * @var \DateTime
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $fechaRegistro = null;

    /**
     * @param \DateTime $today
     */
    public function __construct(\DateTime $today)
    {
        $this->setFechaRegistro($today);
        $this->setQuantity(1);
    }

    /**
     * Returns the quantity
     * 
     * @return int $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Sets the quantity
     * 
     * @param int $quantity
     * @return void
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function addVisitation()
    {
        $amount = $this->getQuantity();
        $this->setQuantity($amount + 1);
    }

    /**
     * Returns the fechaRegistro
     * 
     * @return \DateTime $fechaRegistro
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Sets the fechaRegistro
     * 
     * @param \DateTime $fechaRegistro
     * @return void
     */
    public function setFechaRegistro(\DateTime $fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;
    }

    /**
     * @param \DateTime $today
     */
    public function sameDay(\DateTime $today)
    {
        $equals = false;
        $firstDate = $today->format('Y-m-d');
        $secondDate = $this->getFechaRegistro()->format('Y-m-d');
        if ($firstDate == $secondDate) {
            $equals = true;
        }
        return $equals;
    }
}
