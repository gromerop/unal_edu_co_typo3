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
 * CuentaController
 */
class CuentaController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * cuentaRepository
     *
     * @var \UNAL\UnalSocialMedia\Domain\Repository\CuentaRepository
     */
    protected $cuentaRepository = null;

    /**
     * @param \UNAL\UnalSocialMedia\Domain\Repository\CuentaRepository $cuentaRepository
     */
    public function injectCuentaRepository(\UNAL\UnalSocialMedia\Domain\Repository\CuentaRepository $cuentaRepository)
    {
        $this->cuentaRepository = $cuentaRepository;
    }

    /**
     * action list
     *
     * @return string|object|null|void
     */
    public function listAction()
    {
        $cuentas = $this->cuentaRepository->findAll();
        $this->view->assign('cuentas', $cuentas);
    }
}
