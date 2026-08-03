<?php

namespace UNAL\UnalConvergenceModule\Backend\ItemsProcFuncs;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

use \TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use UNAL\UnalConvergenceModule\Service\ElasticsearchService;

use UNAL\UnalConvergenceModule\Domain\Repository\TemplateRepository;

class ItemsProcFunc
{

    /**
     * Modifies the select box of template
     *
     * @param array &$config configuration array
     */
    public function customTemplatesList(array &$config)
    {

        $result = array();

        $objectManager      = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $templateRepository = $objectManager->get(TemplateRepository::class);
        $templates          = $templateRepository->findAllActive();

        if(is_object($templates) && $templates->count() > 0){
            foreach ($templates as $template) {
                $result[] = [$template->getName(), $template->getUid()];
            }
        }

        $config['items'] = $result;

    }

    /**
     * Modifies the select box of template
     *
     * @param array &$config configuration array
     */
    public function customContentTemplatesList(array &$config)
    {

        $result = array();

        $objectManager      = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $templateRepository = $objectManager->get(TemplateRepository::class);
        $templates          = $templateRepository->findAllActive(true);

        if(is_object($templates) && $templates->count() > 0){
            foreach ($templates as $template) {
                $result[] = [$template->getName(), $template->getUid()];
            }
        }

        $config['items'] = $result;

    }
    
    /**
     * Modifies the select box of content (news).
     *
     * @param array &$config configuration array
     */
    public function contentList(array &$config, $isfortemplate=false)
    {

        //Data Storage from "Admin Tools -> Settings -> Extension Configuration" 
        $extConfiguration   = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $domain             = $extConfiguration->get('unal_convergence_module', 'elasticDomain');
        $port               = $extConfiguration->get('unal_convergence_module', 'elasticPort');
        $user               = $extConfiguration->get('unal_convergence_module', 'elasticUser');
        $password           = $extConfiguration->get('unal_convergence_module', 'elasticPassword');
        $searchCategory     = $extConfiguration->get('unal_convergence_module', 'searchCategory');
        $listIndexes        = $extConfiguration->get('unal_convergence_module', 'includeIndex');
        $listExcludeIndexes = $extConfiguration->get('unal_convergence_module', 'excludeIndex');
        $sizeNews           = $extConfiguration->get('unal_convergence_module', 'sizeNews');
        $listExcludeIndexes = str_replace(' ', '', $listExcludeIndexes);
        $listExcludeIndexes = str_replace(",", ",-", $listExcludeIndexes);

        if(!empty($listExcludeIndexes)){
            $listIndexes = $listIndexes.',-'.$listExcludeIndexes;
        }

        $params = [
            'index' => $listIndexes,
            'size'  => 0,
            'body'  => [
                "query"=> [
                    "bool"=> [
                        "filter"=> [
                            "bool"=> [
                                "must"=> [
                                    [ "term"=> ["recordCategory.keyword" => $searchCategory] ]
                                ]
                            ]
                        ]
                    ]
                ],
                "aggs"=> [
                    "indexes"=> [
                      "terms"=> [
                        "field"=> "_index",
                        "order"=> [ "_key"=> "asc" ]
                      ],
                      "aggs"=> [
                        "hits"=> [
                          "top_hits"=> [
                            "sort"=> [
                              [
                                "recordDate"=> [
                                  "order"=> "desc"
                                ]
                              ]
                            ],
                            "_source"=> [
                              "includes"=> ["id_new","title"]
                            ],
                            "size"=> $sizeNews
                          ]
                        ]
                      ]
                    ]
                  ]
            ]
        ];

        $elasticsearchClient = new ElasticsearchService();
        $client              = $elasticsearchClient
                                ->setDomain($domain)
                                ->setPort($port)
                                ->setUser($user)
                                ->setPassword($password)
                                ->build();
        $results = $client->search($params);

        $result = array();


        if(is_array($results['aggregations']['indexes']['buckets'])){
            
            foreach ($results['aggregations']['indexes']['buckets'] as $key => $value) {
                $index = str_replace('_unal','',$value['key']);
                if(is_array($value['hits']['hits']['hits'])){
                    foreach ($value['hits']['hits']['hits'] as $kk => $vv) {

                        $id    = $vv['_index'].';'.$vv['_id'];
                        if($isfortemplate === true){
                            $label    = $vv['_source']['title'];
                            $product  = ucfirst($index);
                            $result[] = array($product, $id, $label);
                        }else{
                            $label = ucfirst($index).' | '.$vv['_source']['title'];
                            $result[] = array($label, $id);
                        }
                    }
                }
            }
                    
        }

        $config['items'] = $result;

    }

}