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
 * DependenciaController
 */
class DependenciaController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

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
	$dependencias = $this->dependenciaRepository->findAll();
        $this->view->assign('dependencias', $dependencias);
    }
}
