<?php

declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Controller;

use Psr\Http\Message\ResponseInterface;
use UNAL\UnalSocialMedia\Domain\Repository\DependenciaRepository;

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
     * Repositorio de dependencias
     *
     */
    protected DependenciaRepository $dependenciaRepository;
    
    public function __construct(DependenciaRepository $dependenciaRepository) {
        $this->dependenciaRepository = $dependenciaRepository;
    }

    /**
     * Listado de dependencias
     *
     */
    public function listAction(): ResponseInterface
    {
	$dependencias = $this->dependenciaRepository->findAll();
        $this->view->assign('dependencias', $dependencias);
        return $this->htmlResponse();
    }
}
