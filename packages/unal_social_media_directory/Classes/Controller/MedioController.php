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
class MedioController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * medioRepository
	 *
	 * @var \UNAL\UnalSocialMediaDirectory\Domain\Repository\MedioRepository
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $medioRepository;

	/**
	 * sedeRepository
	 *
	 * @var \UNAL\UnalSocialMediaDirectory\Domain\Repository\SedeRepository
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $sedeRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$medios = $this->medioRepository->findAll();
		$this->view->assign('medios', $medios);
	}

	/**
	 * action search
	 *
	 * @return void
	 */
	public function searchAction() {
		if(!$this->settings['defaultAccount'])
			$this->settings['defaultAccount'] = 0;

		$medios = $this->medioRepository->findAvaible($this->settings['defaultAccount']);
		$this->view->assign('medio', $medios);
		$sede = $this->sedeRepository->findAll();
		$this->view->assign('sede', $sede);
		
		$this->view->assign('createPid', $this->settings['createPid']);
	}

}
?>
