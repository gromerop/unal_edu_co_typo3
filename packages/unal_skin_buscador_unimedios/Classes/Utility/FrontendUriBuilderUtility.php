<?php
namespace UNAL\UnalSkinBuscadorUnimedios\Utility;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\TimeTracker\TimeTracker;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class FrontendUriBuilder for creating a frontend link in the backend
 * @package PDVSysteme\Pdvsupportbase\Util
 * @see https://stackoverflow.com/questions/33751570/typo3-with-extbase-uribuilder-or-something-similar-in-backend-hook
 * @license Public Domain
 */
class FrontendUriBuilderUtility
{
    private $pageId = 1;
    private $extensionName = null;
    private $pluginName = null;
    private $actionName = null;
    private $controllerName = null;
    private $arguments = null;
    private $host = null;

    /**
     * FrontendUriBuilder constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param int $pageId the target pageId
     * @return $this FrontendUriBuilder
     */
    public function setTargetPageUid($pageId = 1){
        $this->pageId = $pageId;

        return $this;
    }

    /**
     * @param string $extensionName
     * @return $this FrontendUriBuilder
     */
    public function setExtensionName($extensionName){
        $this->extensionName = strtolower($extensionName);

        return $this;
    }

    /**
     * @param string $pluginName
     * @return $this FrontendUriBuilder
     */
    public function setPlugin($pluginName){
        $this->pluginName = strtolower($pluginName);

        return $this;
    }

    /**
     * @param string $actionName
     * @return $this FrontendUriBuilder
     */
    public function setAction($actionName){
        $this->actionName = $actionName;

        return $this;
    }

    /**
     * @param string $controllerName
     * @return $this FrontendUriBuilder
     */
    public function setController($controllerName){
        $this->controllerName = $controllerName;

        return $this;
    }

    /**
     * @param array $arguments like array('nameOfTheClass' => $instance)
     * @return $this FrontendUriBuilder
     */
    public function setArguments($arguments){
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @param string $host
     * @return $this FrontendUriBuilder
     */
    public function setHost($host){
        $this->host = $host;

        return $this;
    }

    /**
     * Build the URL
     * @return string the url
     * @throws \Exception
     */
    public function build(){
        if ($this->pageId > 0) {
            # code...
        

        //set base
        //$url = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');

        // initialize time tracker
        if (!is_object($GLOBALS['TT'])) {
            $GLOBALS['TT'] = new TimeTracker();
            $GLOBALS['TT']->start();
        }

        // initialize TSFE
        if (!is_object($GLOBALS['TSFE'])) {
            // $GLOBALS['TSFE'] = GeneralUtility::makeInstance(TypoScriptFrontendController::class, $GLOBALS['TYPO3_CONF_VARS'], $this->pageId, 0);
            // $GLOBALS['TSFE']->connectToDB();
            // $GLOBALS['TSFE']->initFEuser();
            // $GLOBALS['TSFE']->determineId();
            // $GLOBALS['TSFE']->initTemplate();
            // $GLOBALS['TSFE']->getConfigArray();

             $tsfeBackup = $GLOBALS['TSFE'] ?? null;
             $GLOBALS['TSFE'] = GeneralUtility::makeInstance(TypoScriptFrontendController::class, null, 58, 0);
             $GLOBALS['TSFE']->fe_user = GeneralUtility::makeInstance(FrontendUserAuthentication::class);
             $GLOBALS['TSFE']->cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
             $GLOBALS['TSFE']->sys_page = GeneralUtility::makeInstance(PageRepository::class, GeneralUtility::makeInstance(Context::class));
             $GLOBALS['TSFE']->cObjectDepthCounter = 100;

             $GLOBALS['TSFE']->getPageAndRootlineWithDomain(1);
             $GLOBALS['TSFE']->forceTemplateParsing = 1;
             $GLOBALS['TSFE']->getConfigArray();

        }

        // make it work with realurl too
        if (ExtensionManagementUtility::isLoaded('realurl')) {
            $rootLine = BackendUtility::BEgetRootLine($this->pageId);
            $host = BackendUtility::firstDomainRecord($rootLine);
            $_SERVER['HTTP_HOST'] = $host;
        }

        // Arguments
        $args = [];

        //set action
        if(!is_null($this->actionName)){
            $this->checkExtensionName();
            $this->checkPluginName();
            $args['tx_' . $this->extensionName . '_' . $this->pluginName . '[action]'] = $this->actionName;
        }

        //set controller
        if(!is_null($this->controllerName)){
            $this->checkExtensionName();
            $this->checkPluginName();
            $args['tx_' . $this->extensionName . '_' . $this->pluginName . '[controller]'] = ucfirst($this->controllerName);
        }

        //set user arguments
        if(!is_null($this->arguments)) {
            $this->checkExtensionName();
            $this->checkPluginName();

            /**
             * @var $argument AbstractEntity
             */
            foreach ($this->arguments as $key => $argument) {
                $value  = $argument;
                if (is_object($value)){
                    $value = $value->getUid();
                }
                $args['tx_' . $this->extensionName . '_' . $this->pluginName . '[' . $key . ']'] = $value;
            }
        }

        // create uri by typolink helper
        $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $url = $cObj->typolink_URL([
            'parameter' => $this->pageId,
            'linkAccessRestrictedPages' => 1,
            'additionalParams' => GeneralUtility::implodeArrayForUrl(NULL, $args),
        ]);

        if(substr($url, 0, 1) === '/'){
            $url = substr($url, 1);
            $url = GeneralUtility::getIndpEnv('TYPO3_SITE_URL').$url;
        }

        return $url;
        }
        return null;
    }

    private function checkExtensionName(){
        if(is_null($this->extensionName)){
            throw new \Exception("Extension name for FrontendUriBuilder not set!");
        }
    }

    private function checkPluginName(){
        if(is_null($this->pluginName)){
            throw new \Exception("Plugin name for FrontendUriBuilder not set!");
        }
    }
}