<?php

namespace UNAL\UnalConvergenceModule\ViewHelpers\Widget\Controller;

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

use \TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use UNAL\UnalConvergenceModule\Service\ElasticsearchService;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use UNAL\UnalConvergenceModule\Domain\Repository\TemplateRepository;

class ContentController extends AbstractWidgetController
{
    /**
    * @var string
    */
    protected $contentId;
    
	/**
    * @var string
    */
    protected $templateId;


    public function initializeAction()
    {
        $this->contentId  = $this->widgetConfiguration['contentId'];
        $this->templateId = $this->widgetConfiguration['templateId'];
    }


    public function indexAction(): void
    {

		$layout = array();
		$objectManager      = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$templateRepository = $objectManager->get(TemplateRepository::class);
		$template           = $templateRepository->findByUid($this->templateId);
		if(is_object($template))
		{
			$layout = json_decode($template->getLayout(), true);
		}
		
		$content = $this->getContent($this->contentId);
		
        $assignedValues = [
            'template' => $layout,
            'content'  => $content,
        ];

        $this->view->assignMultiple($assignedValues);
    }

	private function getContent($contentId=false){

        $result = array();
        if($contentId)
        {
			$contenidoArr = explode(';', $contentId);

			$params = [
				'index' => $contenidoArr[0],
				'id' => $contenidoArr[1],
			];


            //Data Storage from "Admin Tools -> Settings -> Extension Configuration" 
            $extConfiguration   = GeneralUtility::makeInstance(ExtensionConfiguration::class);
            $domain             = $extConfiguration->get('unal_convergence_module', 'elasticDomain');
            $port               = $extConfiguration->get('unal_convergence_module', 'elasticPort');
            $user               = $extConfiguration->get('unal_convergence_module', 'elasticUser');
            $password           = $extConfiguration->get('unal_convergence_module', 'elasticPassword');
            $listIndexes        = $extConfiguration->get('unal_convergence_module', 'includeIndex');
            $listExcludeIndexes = $extConfiguration->get('unal_convergence_module', 'excludeIndex');
            $listExcludeIndexes = str_replace(' ', '', $listExcludeIndexes);
            $listExcludeIndexes = str_replace(",", ",-", $listExcludeIndexes);

            if(!empty($listExcludeIndexes)){
                $listIndexes = $listIndexes.',-'.$listExcludeIndexes;
            }

            $elasticsearchClient = new ElasticsearchService();
            $client              = $elasticsearchClient
                                    ->setDomain($domain)
                                    ->setPort($port)
                                    ->setUser($user)
                                    ->setPassword($password)
                                    ->build();

                                    
            $exists = $client->exists($params);
            if($exists)
            {
                $content = $client->get($params);

                if(is_array($content)){
                    if(is_array($content['_source']['date']))
                    {
                        $content['_source']['date'] = $content['_source']['date']['current'];
                    }
                    $result = $content['_source'];
                }
            }
        }
        return $result;
    }


}    