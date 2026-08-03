<?php
namespace UNAL\UnalSkinBuscadorUnimedios\Utility;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use \UNAL\UnalNews\Domain\Model\UnalNews;
use \UNAL\UnalSkinBuscadorUnimedios\Domain\Model\ElasticSearch;
use \TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

use UNAL\UnalSkinBuscadorUnimedios\Utility\FrontendUriBuilderUtility;



class ConvergenciaUtility
{

    /**
     * elasticSearch
     * 
     * @var ElasticSearch
     */
    private $elasticSearch = null;

    /*
     * types of content with the first letter capitalized
     * @var array
    */
    private $types = ['New','Image','Video', 'Audio'];

    /**
     * Detail News Page Uid
     * @var string
     */
    private $detailNewsPageUid = null;


    /**
     * ConvergenciaUtility constructor.
     */
    public function __construct()
    {

        //Data Storage from "Admin Tools -> Settings -> Extension Configuration" 
        $extConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $elasticDomain    = $extConfiguration->get('unal_skin_buscador_unimedios', 'elasticDomain');
        $elasticPort      = $extConfiguration->get('unal_skin_buscador_unimedios', 'elasticPort');
        $elasticUser      = $extConfiguration->get('unal_skin_buscador_unimedios', 'elasticUser');
        $elasticPassword  = $extConfiguration->get('unal_skin_buscador_unimedios', 'elasticPassword');
        $newIndex         = $extConfiguration->get('unal_skin_buscador_unimedios', 'newIndex');
        $imageIndex       = $extConfiguration->get('unal_skin_buscador_unimedios', 'imageIndex');
        $videoIndex       = $extConfiguration->get('unal_skin_buscador_unimedios', 'videoIndex');
        $audioIndex       = $extConfiguration->get('unal_skin_buscador_unimedios', 'audioIndex');

        //Detail News Page Uid
        $this->detailNewsPageUid = $extConfiguration->get('unal_skin_buscador_unimedios', 'detailNewsPageUid');

        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->elasticSearch = $objectManager->get(ElasticSearch::class);

        $this->elasticSearch->setDomain($elasticDomain);
        $this->elasticSearch->setPort($elasticPort);
        $this->elasticSearch->setUser($elasticUser);
        $this->elasticSearch->setPassword($elasticPassword);
        $this->elasticSearch->setNewIndex($newIndex);
        $this->elasticSearch->setImageIndex($imageIndex);
        $this->elasticSearch->setVideoIndex($videoIndex);
        $this->elasticSearch->setAudioIndex($audioIndex);
        
    }


    public function deleteElasticElements($newsRecord){

        if($newsRecord)
        {
            $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $dataMapper    = $objectManager->get(DataMapper::class);
            $anyModels     = $dataMapper->map(UnalNews::class, [$newsRecord]);

            // NewsItem Model
            $newsItem = $anyModels[0];

            // We loop through the array ($this->types) to get the content types
            foreach ($this->types as $type) {

                // We dynamically obtain the content index: New, Image, Video, Audio
                $getIndex = "get{$type}Index";
                $index = $this->elasticSearch->{$getIndex}();
                if($index)
                {
                    $contenType = mb_strtolower($type, 'UTF-8');
                    if($contenType == 'new') {
                        $newsItemNew = $newsItem->parsedArrayElastic(false, $contenType);
                        $this->deleteElasticElement($newsItemNew['id'], $index);
                    }else{
                        $newsItems = $newsItem->parsedArrayElastic(false, $contenType);
                        $tamArr    = count($newsItems);
                        if($tamArr>0){
                            foreach ($newsItems as $item) {
                                $this->deleteElasticElement($item['id'], $index);
                            }
                        }
                    }
                }            
            }
        }

    }

    private function deleteElasticElement($uid, $elasticIndex){

        $baseUrl = $this->elasticSearch->getBaseUrl();
        $auth    = $this->elasticSearch->getAuth();
        if($uid && $elasticIndex && $baseUrl && $auth)
        {
            $array = array();
            $array["query"]=["match"=>["id"=>$uid]];

            $request = \json_encode($array);

            // Create a new cURL resource
            $ch = curl_init();

            $elasticUrl= $baseUrl.$elasticIndex."/_delete_by_query";

            // Set URL and other options
            curl_setopt($ch, CURLOPT_URL, $elasticUrl);
            curl_setopt($ch, CURLOPT_USERPWD, $auth);//Set username and password
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST,           1 );
            curl_setopt($ch, CURLOPT_POSTFIELDS,     $request );
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

            // Response
            $result = curl_exec($ch);

            // Close the cURL resource and free up system resources
            curl_close($ch);
        }

    }


    public function insertElasticElements($newsRecord){

        if($newsRecord)
        {
            $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $dataMapper    = $objectManager->get(DataMapper::class);
            $anyModels     = $dataMapper->map(UnalNews::class, [$newsRecord]);

            // NewsItem Model
            $newsItem    = $anyModels[0];

            // We loop through the array ($this->types) to get the content types
            foreach ($this->types as $type) {

                // We dynamically obtain the content index: New, Image, Video, Audio
                $getIndex = "get{$type}Index";
                $index = $this->elasticSearch->{$getIndex}();
                if($index)
                {
                    $contenType = mb_strtolower($type, 'UTF-8');
                    if($contenType == 'new') {
                        $newsItemNew = $newsItem->parsedArrayElastic(false, $contenType);
                        $this->deleteElasticElement($newsItemNew['id'], $index);

                        $this->saveElasticsearh($newsItemNew['id'], $newsItemNew, $index);

                    }else{
                        $newsItems = $newsItem->parsedArrayElastic(false, $contenType);
                        $tamArr    = count($newsItems);
                        if($tamArr>0){
                            foreach ($newsItems as $item) {
                                $this->saveElasticsearh($item['id'], $item, $index, true);
                            }
                        }
                    }
                }
            }
        }

    }

    private function saveElasticsearh($uid, $record, $elasticIndex, $isMedia=false){

        $baseUrl = $this->elasticSearch->getBaseUrl();
        $auth    = $this->elasticSearch->getAuth();

        if($uid && $record && $elasticIndex && $baseUrl && $auth)
        {
            //Fix Frontend URL
             $uriBuilder = new FrontendUriBuilderUtility();
             $idNews     = ($isMedia)?$record['id_new']:$record['id'];
             $arguments  = ['news' => $idNews];
            
             $uri = $uriBuilder->setTargetPageUid($this->detailNewsPageUid)
                         ->setExtensionName('News')
                         ->setPlugin('pi1')
                         ->setAction('detail')
                         ->setController('news')
                         ->setArguments($arguments)
                         ->build();

            $record['url']        = $record['url'];
            $record['date']       = $record['date']->format('c');
            $record['recordDate'] = $record['recordDate']->format('c');

            $request = json_encode($record);

            // Create a new cURL resource
            $ch = curl_init();

            $elasticUrl= $baseUrl.$elasticIndex."/_doc/".$uid."?refresh";

            // Set URL and other options
            curl_setopt($ch, CURLOPT_URL, $elasticUrl);
            curl_setopt($ch, CURLOPT_USERPWD, $auth);//Set username and password
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST,           1 );
            curl_setopt($ch, CURLOPT_POSTFIELDS,     $request );
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

            // Response
            $result = curl_exec($ch);

            // Close the cURL resource and free up system resources
            curl_close($ch);
        }

    }




}