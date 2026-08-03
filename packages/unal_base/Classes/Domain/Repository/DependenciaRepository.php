<?php
namespace UNAL\UnalBase\Domain\Repository;

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
 * The repository for Dependencias
 */
class DependenciaRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'nombre' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    public function createQuery()
    {
        $query = parent::createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        return $query;
    }

    /**
     * Busca las dependencias cuyo nombre coincida con el parámetro de búsqueda.
     * Se excluyen las que tengan ocultarEnPapeleria = TRUE.
     *
     * @param $q
     * @param $incluirExcepciones
     */
    public function buscar($q, $incluirExcepciones)
    {
        // Se modifica la variable $q, reemplazando los espacios por '%'
        $value = \str_replace(' ', '%', $q);
        $query = $this->createQuery();
        // Se establecen las restricciones (constraints)
        $constraints = array(
            $query->like('txtJerarquia', '%' . $value . '%', FALSE),
            $query->equals('ocultarEnPapeleria', FALSE),
				$query->equals('ocultar', 0),
            $query->greaterThan('idSuperior', 0)
        );
        // Si NO se deben incluir las excepciones, agregar un constraint más
        if ($incluirExcepciones == FALSE) {
            $constraints[] = $query->equals('excepcion', FALSE);
        }
        // Se ejecuta la consulta.
        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }
	 
	 public function findAvailableByIdSuperior($idSuperior)
    {
       $query = $this->createQuery();
		 $constraints =[
			  $query->equals('idSuperior', $idSuperior),
			  $query->logicalNot($query->equals('codigo', '')),
			  $query->equals('ocultar', 0)
		 ];
		 $query->matching($query->logicalAnd($constraints));
       return $query->execute();
    }
}
