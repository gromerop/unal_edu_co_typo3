<?php

namespace UNAL\UnalConvergenceModule\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

use UNAL\UnalConvergenceModule\Domain\Model\Template;
use UNAL\UnalConvergenceModule\Domain\Repository\TemplateRepository;

//Persistence
use \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

use \TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use UNAL\UnalConvergenceModule\Service\ElasticsearchService;

use UNAL\UnalConvergenceModule\Backend\ItemsProcFuncs\ItemsProcFunc;

class ContentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    public function templateAction(){

        $layout = array();
        if(isset($this->settings['layout']) && $this->settings['layout'] > 0){
            $objectManager      = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $templateRepository = $objectManager->get(TemplateRepository::class);
            $template           = $templateRepository->findByUid($this->settings['layout']);
            if(is_object($template))
            {
                $layout = json_decode($template->getLayout(), true);
            }
        }

        $assignedValues = [
            'layout'    => $layout,
            'settings' => $this->settings
        ];
        $this->view->assignMultiple($assignedValues);

    }

    public function sliderAction(){
        //Inicializamos los resultados
        $results = null;

        if(isset($this->settings['contenido']) && $this->settings['contenido'] != ""){
            $results = $this->getMultipleContent($this->settings['contenido']);
        }

        $assignedValues = [
            'results'  => $results,
            'settings' => $this->settings
        ];
        $this->view->assignMultiple($assignedValues);
    }

    public function verticalAction(){
        //Inicializamos los resultados
        $results = null;
        
        if(isset($this->settings['contenido']) && $this->settings['contenido'] != ""){
            $results = $this->getMultipleContent($this->settings['contenido']);
        }

        $assignedValues = [
            'results'  => $results,
            'settings' => $this->settings
        ];
        $this->view->assignMultiple($assignedValues);
    }

    private function getMultipleContent($settingsContent=false){

        $results = array();
        if($settingsContent)
        {
            $filterContent = [];
            $settingsContenidoArr = explode(",", $settingsContent);
            foreach ($settingsContenidoArr as $contenido) {
               $contenidoArr = explode(';', $contenido);
               $filterContent[] = [
                "_index"=> $contenidoArr[0],
                "_id"=> $contenidoArr[1]
               ];
            }


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
            $params = [
                'body'  => [
                    "docs" => $filterContent
                ]
            ];
            $content = $client->mget($params);
            if(is_array($content['docs'])){
                foreach ($content['docs'] as $result) {
                    $results[] = $result['_source'];
                }

            }
        }
        return $results;
    }

    public function templateBuilderAction(){
        $objectManager      = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $templateRepository = $objectManager->get(TemplateRepository::class);
        // Traemos solo las plantillas activas que no son content
        $templates          = $templateRepository->findAllActive();
        
        $assignedValues = [
            'templates' => $templates,
            'settings'  => $this->settings
        ];
        $this->view->assignMultiple($assignedValues);
    }
    
    public function createTemplateAction(){
        $objectManager  = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $itemsProcFunc  = $objectManager->get(ItemsProcFunc::class);
        $templatesArr   = array();
        $itemsProcFunc->customContentTemplatesList($templatesArr);
        $contentsArr    = array();
        $itemsProcFunc->contentList($contentsArr, true);
        $assignedValues = [
            'contents'         => $contentsArr,
            'contentTemplates' => $templatesArr,
            'settings'         => $this->settings
        ];
        $this->view->assignMultiple($assignedValues);
    }
    
    public function templateContentBuilderAction(){
        $objectManager      = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $templateRepository = $objectManager->get(TemplateRepository::class);
        // Traemos solo las plantillas activas que son content
        $templates          = $templateRepository->findAllActive(true);
        
        $assignedValues = [
            'templates' => $templates,
            'settings'  => $this->settings
        ];
        $this->view->assignMultiple($assignedValues);
    }

    public function createContentTemplateAction(){

    }
    

    /**
     * action initializeSaveTemplate
     * Change the default view (html template) for Json view
     * @return void
     */
    public function initializeSaveTemplateAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    public function saveTemplateAction(){
        $response = array(
            "status" => false,
            "message" => "Ocurrió un error",
        );

        if ($this->request->hasArgument('data')) {
            $data      = $this->request->getArgument('data');
            $data      = json_decode($data);
            $isContent = $data->isContent;
            $name      = $data->tplName;
            $layout    = json_encode($data->tpl);


            $objectManager      = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $templateRepository = $objectManager->get(TemplateRepository::class);
            $template           = $objectManager->get(Template::class);
            $template->setPid(1);
            $template->setIscontent($isContent);
            $template->setName($name);
            $template->setLayout($layout);
            
            $templateRepository->add($template);
            $objectManager->get(PersistenceManager::class)->persistAll();

            $response['status']  = true;
            $response['message'] = 'Los datos se guardaton exitosamente';
        }

        $this->view->setVariablesToRender(['response']);
        $this->view->assign('response', $response);
        
    }

    /**
     * action initializeUpdateTemplate
     * Change the default view (html template) for Json view
     * @return void
     */
    public function initializeUpdateTemplateAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    public function updateTemplateAction(){
        $response = array(
            "status" => false,
            "message" => "Ocurrió un error",
        );

        if ($this->request->hasArgument('data')) {
            $data      = $this->request->getArgument('data');
            $data      = json_decode($data);
            $uid       = $data->uid;
            $name      = $data->tplName;
            $layout    = json_encode($data->tpl);

            $objectManager      = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $templateRepository = $objectManager->get(TemplateRepository::class);
            $template           = $templateRepository->findByUid($uid);
            if(is_object($template))
            {
                $template->setName($name);
                $template->setLayout($layout);
                $templateRepository->update($template);
                $objectManager->get(PersistenceManager::class)->persistAll();

                $response['status']  = true;
                $response['message'] = 'Los datos se guardaton exitosamente';
            }
        }

        $this->view->setVariablesToRender(['response']);
        $this->view->assign('response', $response);
        
    }

    public function editTemplateAction(){
        $template      = null;
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        if ($this->request->hasArgument('template')) {
            $tplId              = $this->request->getArgument('template');
            $templateRepository = $objectManager->get(TemplateRepository::class);
            $template           = $templateRepository->findByUid($tplId);
        }
        $this->view->assign('template', $template);

        $itemsProcFunc  = $objectManager->get(ItemsProcFunc::class);
        $templatesArr   = array();
        $itemsProcFunc->customContentTemplatesList($templatesArr);
        $contentsArr    = array();
        $itemsProcFunc->contentList($contentsArr, true);
        $assignedValues = [
            'template'         => $template,
            'contents'         => $contentsArr,
            'contentTemplates' => $templatesArr,
            'settings'         => $this->settings
        ];

        $this->view->assignMultiple($assignedValues);
    }
    
    public function editContentTemplateAction(){
        $template   = null;

        if ($this->request->hasArgument('template')) {
            $tplId              = $this->request->getArgument('template');
            $objectManager      = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $templateRepository = $objectManager->get(TemplateRepository::class);
            $template           = $templateRepository->findByUid($tplId);
        }
        $this->view->assign('template', $template);
    }

    public function deleteTemplateAction(){
        if ($this->request->hasArgument('template')) {
            $tplId              = $this->request->getArgument('template');
            $objectManager      = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $templateRepository = $objectManager->get(TemplateRepository::class);
            $template           = $templateRepository->findByUid($tplId);
            $templateRepository->remove($template);
        }

        if ($this->request->hasArgument('templateContent')) {
            $this->redirect('templateContentBuilder');
        }else{
            $this->redirect('templateBuilder'); 
        }
    }
    
    public function duplicateTemplateAction(){
        if ($this->request->hasArgument('template')) {
            $tplId              = $this->request->getArgument('template');
            $objectManager      = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

            $templateRepository = $objectManager->get(TemplateRepository::class);
            $templateOrig       = $templateRepository->findByUid($tplId);

            $templateRepository = $objectManager->get(TemplateRepository::class);
            $templateNew        = $objectManager->get(Template::class);
            $templateNew->setPid($templateOrig->getPid());
            $templateNew->setIscontent($templateOrig->getIsContent());
            
            $newName   = $templateOrig->getName();
            $countName = $templateRepository->countByTemplateName($newName);
            $newName   = $newName.' (Copy '.$countName.')';

            $templateNew->setName($newName);
            $templateNew->setLayout($templateOrig->getLayout());
            
            $templateRepository->add($templateNew);
            $objectManager->get(PersistenceManager::class)->persistAll();
            
        }

        if ($this->request->hasArgument('templateContent')) {
            $this->redirect('templateContentBuilder');
        }else{
            $this->redirect('templateBuilder'); 
        }
    }
    

}