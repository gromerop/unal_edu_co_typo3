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
 * ViewHelper que brinda los datos de un usuario
 */
class UsernameViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
	public function initializeArguments()
	{
		parent::initializeArguments();
		$this->registerArgument('uid', 'integer', '', true);
	}

	/**
     * usuarioRepository
     *
     * @var \Causal\IgLdapSsoAuth\Domain\Repository\Typo3UserRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $usuarioRepository = NULL;
	 
	/**
	 * 
	 * @return string
	 */
	public function render() {
		$uid = $this->arguments['uid'];
		return $this->usuarioRepository->fetch('fe_users', $uid)[0]['username'];
	}
}
