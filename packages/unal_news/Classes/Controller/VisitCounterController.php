<?php

declare(strict_types=1);

namespace UNAL\UnalNews\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class VisitCounterController extends ActionController
{
    public function __construct(
        private readonly ModuleTemplateFactory $moduleTemplateFactory,
    ) {
    }

    public function selectorReportAction(): ResponseInterface
    {
        return $this->moduleTemplateFactory
            ->create($this->request)
            ->setTitle('Reporte UN News')
            ->renderResponse('VisitCounter/SelectorReport');
    }

    public function generateReportAction(): ResponseInterface
    {
        return $this->redirect('selectorReport');
    }
}