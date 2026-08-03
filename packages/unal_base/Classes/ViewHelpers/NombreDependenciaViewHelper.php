<?php
namespace UNAL\UnalBase\ViewHelpers;

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

/**
 * ViewHelper que da el nombre de una dependencia, dado su id
 */
class NombreDependenciaViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
	/**
     * dependenciaRepository
     *
     * @var \UNAL\UnalBase\Domain\Repository\DependenciaRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $dependenciaRepository = NULL;
	 
	/**
	 * 
	 * @param int $uid
	 * @return string
	 */
	public function render($uid) {
		$resultado = '';
		$dependencia = $this->dependenciaRepository->findByUid($uid);
		if ($dependencia != NULL) {
			$resultado = $dependencia->getNombre();
		}
		return $resultado;
	}
}