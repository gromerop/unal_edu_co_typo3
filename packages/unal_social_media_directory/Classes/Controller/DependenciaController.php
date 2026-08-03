<?php
namespace UNAL\UnalSocialMediaDirectory\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Pedro Daniel Valero Rueda <pvaleror@gmail.com>
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
 *
 *
 * @package unal_social_media_directory
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class DependenciaController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * dependenciaRepository
	 *
	 * @var \UNAL\UnalSocialMediaDirectory\Domain\Repository\DependenciaRepository
	 * @inject
	 */
	protected $dependenciaRepository;

	/**
	 * sedeRepository
	 *
	 * @var \UNAL\UnalSocialMediaDirectory\Domain\Repository\SedeRepository
	 * @inject
	 */
	protected $sedeRepository;
	
	/**
	 * medioRepository
	 *
	 * @var \UNAL\UnalSocialMediaDirectory\Domain\Repository\MedioRepository
	 * @inject
	 */
	protected $medioRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		if($this->settings['defaultAccount']>0){
			$dependencias = $this->dependenciaRepository->findNoDefaultAccount($this->settings['defaultAccount']);
			//$default = $this->dependenciaRepository->findByUid($this->settings['defaultAccount']);
			//$this->view->assign('defaultAccount', $default);	
		}else{

			$dependencias = $this->dependenciaRepository->findAll();
		}
		$this->view->assign('dependencias', $dependencias);
	}

	/**
	 * action new
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Dependencia $newDependencia
	 * @dontvalidate $newDependencia
	 * @return void
	 */
	public function newAction(\UNAL\UnalSocialMediaDirectory\Domain\Model\Dependencia $newDependencia = NULL) {
		$this->view->assign('newDependencia', $newDependencia);

		$medios = $this->medioRepository->findAll();
		$this->view->assign('medios', $medios);
		$sede = $this->sedeRepository->findAll();
		$this->view->assign('sedes', $sede);
	}

	/**
	 * action create
	 *
	 * @param \UNAL\UnalSocialMediaDirectory\Domain\Model\Dependencia $newDependencia
	 * @return void
	 */
	public function createAction(\UNAL\UnalSocialMediaDirectory\Domain\Model\Dependencia $newDependencia) {
		$this->dependenciaRepository->add($newDependencia);
		$this->flashMessageContainer->add('Your new Dependencia was created.');
		$this->redirect('list');
	}

	
	/**
	 * action confirm
	 *
	 * @return void
	 */
	public function confirmAction() {
		
	}

	/**
	 * action default
	 *
	 * @return void
	 */
	public function defaultAction() {
		$default = $this->dependenciaRepository->findByUid($this->settings['defaultAccount']);
		$this->view->assign('defaultAccount', $default);	
	}
}
?>
