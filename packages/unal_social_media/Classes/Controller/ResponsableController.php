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
 * ResponsableController
 */
class ResponsableController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * action list
     *
     * @return string|object|null|void
     */
    public function listAction()
    {
        $responsables = $this->responsableRepository->findAll();
        $this->view->assign('responsables', $responsables);
    }
}
