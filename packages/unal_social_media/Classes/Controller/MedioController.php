<?php

declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Controller;

use Psr\Http\Message\ResponseInterface;
use UNAL\UnalSocialMedia\Domain\Repository\DependenciaRepository;
use UNAL\UnalSocialMedia\Domain\Repository\MedioRepository;
use UNAL\UnalSocialMedia\Domain\Repository\SedeRepository;


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
     * Repositorio de medios
     *
     */
    protected MedioRepository $medioRepository;
    
    /**
     * Repositorio de Sedes
     *
     */
    protected SedeRepository $sedeRepository;
    
    /**
     * Repositorio de dependencias
     *
     */
    protected DependenciaRepository $dependenciaRepository;
    
    public function __construct(MedioRepository $medioRepository, SedeRepository $sedeRepository, DependenciaRepository $dependenciaRepository) {
        $this->medioRepository = $medioRepository;
        $this->sedeRepository = $sedeRepository;
        $this->dependenciaRepository = $dependenciaRepository;
    }
    
    /**
     * Listado de medios
     *
     */
    public function listAction(): ResponseInterface
    {
        $medios = $this->medioRepository->findAll();
        $this->view->assign('medios', $medios);
        return $this->htmlResponse();
    }

    /**
     * action search
     *
     */
    public function searchAction(): ResponseInterface
    {
        $medios = $this->medioRepository->findAvaible();
        $this->view->assign('medio', $medios);
        $sede = $this->sedeRepository->findAll();
        $this->view->assign('sede', $sede);

        $dependencia = $this->dependenciaRepository->findAvailable();
        $this->view->assign('dependencia', $dependencia);
        return $this->htmlResponse();
    }
}
