<?php
namespace UNAL\UnalSkinBuscadorUnimedios\Utility;

use Psr\Log\LoggerInterface;
use Throwable;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use \UNAL\UnalNews\Domain\Model\UnalNews;
use \UNAL\UnalSkinBuscadorUnimedios\Domain\Model\ElasticSearch;
use \TYPO3\CMS\Core\Configuration\ExtensionConfiguration;



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

    private readonly bool $elasticSearchDisabled;


    public function __construct(
        ExtensionConfiguration $extensionConfiguration,
        private readonly DataMapper $dataMapper,
        private readonly RequestFactory $requestFactory,
        private readonly LoggerInterface $logger,
    ) {
        $this->elasticSearchDisabled =
            getenv('UNAL_DISABLE_ELASTICSEARCH') === '1';
        $elasticDomain = $extensionConfiguration->get(
            'unal_skin_buscador_unimedios',
            'elasticDomain'
        );
        $elasticPort = $extensionConfiguration->get(
            'unal_skin_buscador_unimedios',
            'elasticPort'
        );
        $elasticUser = $extensionConfiguration->get(
            'unal_skin_buscador_unimedios',
            'elasticUser'
        );
        $elasticPassword = $extensionConfiguration->get(
            'unal_skin_buscador_unimedios',
            'elasticPassword'
        );
        $newIndex = $extensionConfiguration->get(
            'unal_skin_buscador_unimedios',
            'newIndex'
        );
        $imageIndex = $extensionConfiguration->get(
            'unal_skin_buscador_unimedios',
            'imageIndex'
        );
        $videoIndex = $extensionConfiguration->get(
            'unal_skin_buscador_unimedios',
            'videoIndex'
        );
        $audioIndex = $extensionConfiguration->get(
            'unal_skin_buscador_unimedios',
            'audioIndex'
        );

        $this->elasticSearch = new ElasticSearch();
        $this->elasticSearch->setDomain((string)$elasticDomain);
        $this->elasticSearch->setPort((string)$elasticPort);
        $this->elasticSearch->setUser((string)$elasticUser);
        $this->elasticSearch->setPassword((string)$elasticPassword);
        $this->elasticSearch->setNewIndex((string)$newIndex);
        $this->elasticSearch->setImageIndex((string)$imageIndex);
        $this->elasticSearch->setVideoIndex((string)$videoIndex);
        $this->elasticSearch->setAudioIndex((string)$audioIndex);
    }

    private function sendJsonRequest(
        string $url,
        array $payload,
        string $operation,
    ): void {
        try {
            $response = $this->requestFactory->request(
                $url,
                'POST',
                [
                    'auth' => [
                        $this->elasticSearch->getUser(),
                        $this->elasticSearch->getPassword(),
                    ],
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $payload,
                    'connect_timeout' => 5,
                    'timeout' => 15,
                    'http_errors' => false,
                ]
            );

            if ($response->getStatusCode() >= 400) {
                $this->logger->warning(
                    'Elasticsearch operation returned an error response.',
                    [
                        'operation' => $operation,
                        'status' => $response->getStatusCode(),
                    ]
                );
            }
        } catch (Throwable $exception) {
            $this->logger->warning(
                'Elasticsearch operation could not be completed.',
                [
                    'operation' => $operation,
                    'exception' => $exception,
                ]
            );
        }
    }


    public function deleteElasticElements($newsRecord){
        if ($this->elasticSearchDisabled) {
            return;
        }

        if($newsRecord)
        {
            $anyModels = $this->dataMapper->map(
                UnalNews::class,
                [$newsRecord]
            );

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

            $elasticUrl = $baseUrl . $elasticIndex . '/_delete_by_query';

            $this->sendJsonRequest(
                $elasticUrl,
                [
                    'query' => [
                        'match' => [
                            'id' => $uid,
                        ],
                    ],
                ],
                'delete',
            );
        }

    }


    public function insertElasticElements($newsRecord){
        if ($this->elasticSearchDisabled) {
            return;
        }

        if($newsRecord)
        {
            $anyModels = $this->dataMapper->map(
                UnalNews::class,
                [$newsRecord]
            );

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

                        $this->saveElasticsearch(
                            $newsItemNew['id'],
                            $newsItemNew,
                            $index
                        );

                    }else{
                        $newsItems = $newsItem->parsedArrayElastic(false, $contenType);
                        $tamArr    = count($newsItems);
                        if($tamArr>0){
                            foreach ($newsItems as $item) {
                                $this->saveElasticsearch(
                                    $item['id'],
                                    $item,
                                    $index
                                );
                            }
                        }
                    }
                }
            }
        }

    }

    private function saveElasticsearch(
        $uid,
        $record,
        $elasticIndex
    ): void
    {

        $baseUrl = $this->elasticSearch->getBaseUrl();
        $auth    = $this->elasticSearch->getAuth();

        if($uid && $record && $elasticIndex && $baseUrl && $auth)
        {
            $record['date']       = $record['date']->format('c');
            $record['recordDate'] = $record['recordDate']->format('c');

            $elasticUrl = $baseUrl . $elasticIndex . '/_doc/' . $uid . '?refresh';

            $this->sendJsonRequest(
                $elasticUrl,
                $record,
                'index',
            );
        }

    }
}