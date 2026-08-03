<?php

namespace UNAL\UnalConvergenceModule\ViewHelpers\Widget;

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;
use UNAL\UnalConvergenceModule\ViewHelpers\Widget\Controller\ContentController;

class ContentViewHelper extends AbstractWidgetViewHelper
{
    /**
    * @var ContentController
    */
    protected $controller;
    /**
    * @param ContentController $controller
    */
    public function injectContentController(ContentController $controller)
    {
        $this->controller = $controller;
    }

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('contentId', 'string', 'Content Id', true);
        $this->registerArgument('templateId', 'string', 'Template id', true);
    }

    /**
    * @return string
    */
    public function render(): string
    {
        return $this->initiateSubRequest();
    }
}