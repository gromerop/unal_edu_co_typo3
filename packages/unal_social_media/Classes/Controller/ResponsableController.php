<?php

declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Controller;

use Psr\Http\Message\ResponseInterface;


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
     */
    public function listAction(): ResponseInterface
    {
        $responsables = $this->responsableRepository->findAll();
        $this->view->assign('responsables', $responsables);
        return $this->htmlResponse();
    }
}
