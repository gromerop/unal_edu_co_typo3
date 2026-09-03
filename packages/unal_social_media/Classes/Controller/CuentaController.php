<?php

declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Controller;

use Psr\Http\Message\ResponseInterface;
use UNAL\UnalSocialMedia\Domain\Repository\CuentaRepository;

/**
 * This file is part of the "UNAL Social Media" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2021 
 */

/**
 * CuentaController
 */
class CuentaController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * Repositorio de cuentas
     *
     */
    protected CuentaRepository $cuentaRepository;
    
    public function __construct(CuentaRepository $cuentaRepository) {
        $this->cuentaRepository = $cuentaRepository;
    }

    /**
     * Listado de cuentas
     *
     */
    public function listAction(): ResponseInterface
    {
        $cuentas = $this->cuentaRepository->findAll();
        $this->view->assign('cuentas', $cuentas);
        return $this->htmlResponse();
    }
}
