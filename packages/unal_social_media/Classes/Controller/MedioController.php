<?php

declare(strict_types=1);

namespace Unal\UnalSocialMedia\Controller;


/**
 * This file is part of the "UNAL Social Media" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2021 
 */

/**
 * MedioController
 */
class MedioController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * medioRepository
     *
     * @var \Unal\UnalSocialMedia\Domain\Repository\MedioRepository
     */
    protected $medioRepository = null;

    /**
     * @param \Unal\UnalSocialMedia\Domain\Repository\MedioRepository $medioRepository
     */
    public function injectMedioRepository(\Unal\UnalSocialMedia\Domain\Repository\MedioRepository $medioRepository)
    {
        $this->medioRepository = $medioRepository;
    }

    /**
     * sedeRepository
     *
     * @var \Unal\UnalSocialMedia\Domain\Repository\SedeRepository
     */
    protected $sedeRepository = null;

    /**
     * @param \Unal\UnalSocialMedia\Domain\Repository\SedeRepository $sedeRepository
     */
    public function injectSedeRepository(\Unal\UnalSocialMedia\Domain\Repository\SedeRepository $sedeRepository)
    {
        $this->sedeRepository = $sedeRepository;
    }

    /**
     * dependenciaRepository
     *
     * @var \Unal\UnalSocialMedia\Domain\Repository\DependenciaRepository
     */
    protected $dependenciaRepository = null;

    /**
     * @param \Unal\UnalSocialMedia\Domain\Repository\DependenciaRepository $dependenciaRepository
     */
    public function injectDependenciaRepository(\Unal\UnalSocialMedia\Domain\Repository\DependenciaRepository $dependenciaRepository)
    {
        $this->dependenciaRepository = $dependenciaRepository;
    }
    /**
     * action list
     *
     * @return string|object|null|void
     */
    public function listAction()
    {
        $medios = $this->medioRepository->findAll();
        $this->view->assign('medios', $medios);
    }

    /**
     * action search
     *
     * @return string|object|null|void
     */
    public function searchAction()
    {
		$medios = $this->medioRepository->findAvaible();
		$this->view->assign('medio', $medios);
		$sede = $this->sedeRepository->findAll();
		$this->view->assign('sede', $sede);

		$dependencia = $this->dependenciaRepository->findAvailable();
		$this->view->assign('dependencia', $dependencia);
		
//		$this->view->assign('createPid', $this->settings['createPid']);
    }
}
