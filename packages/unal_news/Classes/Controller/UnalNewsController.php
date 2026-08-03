<?php
namespace UNAL\UnalNews\Controller;

use GeorgRinger\News\Domain\Model\Dto\NewsDemand;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\DebugUtility;
use UNAL\UnalNews\Utility\FirstMediaImage;

/***
 *
 * This file is part of the "UNAL News extension" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Oficina de Medios DIgitales - Unimedios <mediosdigitales@unal.edu.co>, Universidad Nacional de Colombia
 *           Martha Lucía Chaves Muñoz <mlchavezm@unal.edu.co>, Universidad Nacional de Colombia
 *           César Hansy Dueñas Barragán <chduenasba@unal.edu.co>, Universidad Nacional de Colombia
 *
 ***/
/**
 * UnalNewsController
 */
class UnalNewsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * unalNewsRepository
     * 
     * @var \UNAL\UnalNews\Domain\Repository\UnalNewsRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $unalNewsRepository = null;
    public function initializeListRestAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    /**
     * action listRest
     * 
     * @return void
     */
    public function listRestAction()
    {
        $baseUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
        $arguments = $this->request->getArguments();
        $totalElements = $this->unalNewsRepository->total();
        $pages = ceil($totalElements / 9);
        $next_page = '';
        $prev_page = '';

        #GET Page to load
        if ($arguments['page'] and $arguments['page'] != '') {
            $page_to_load = $arguments['page'];
        } else {
            $page_to_load = 1;
        }

        #Configuration of pagination
        if ($page_to_load == $pages) {
            $prev = $page_to_load - 1;
            $prev_page = $baseUrl."/television/rest/noticias/page/{$prev}";
        } elseif ($page_to_load == 1) {
            $next = $page_to_load + 1;
            $next_page = $baseUrl."/television/rest/noticias/page/{$next}";
        } else {
            $prev = $page_to_load - 1;
            $prev_page = $baseUrl."/television/rest/noticias/page/{$prev}";
            $next = $page_to_load + 1;
            $next_page = $baseUrl."/television/rest/noticias/page/{$next}";
        }
        $jsonPreparedElements = array();
        $jsonPreparedElements['info']['count'] = $totalElements;
        $jsonPreparedElements['info']['pages'] = $pages;
        $jsonPreparedElements['info']['next'] = $next_page;
        $jsonPreparedElements['info']['prev'] = $prev_page;
        $result = $this->unalNewsRepository->paginated($page_to_load);
        $collection_parsed_results = array();
        foreach ($result as $news) {
            array_push($collection_parsed_results, $news->parsedArray());
        }
        $jsonPreparedElements['results'] = $collection_parsed_results;
        $this->view->assign('value', $jsonPreparedElements);
    }

    public function initializeSearchRestAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    /**
     * action searchRest
     * 
     * @return void
     */
    public function searchRestAction()
    {
        $arguments = $this->request->getArguments();
        $jsonPreparedElements = array();
        $result = $this->unalNewsRepository->getRelated($arguments['queryparams']['size']);
        foreach ($result as $news) {
            array_push($jsonPreparedElements, $news->parsedArray());
        }
        $this->view->assign('value', $jsonPreparedElements);
    }


    public function initializeAutocompleteRestAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    /**
     * action autocompleteRest
     * 
     * @return void
     */
    public function autocompleteRestAction()
    {
        $arguments = $this->request->getArguments();
        $jsonPreparedElements = array();
        $result = $this->unalNewsRepository->getData($arguments['search']);
        $jsonPreparedElements = $result;
        $this->view->assign('value', $jsonPreparedElements);
    }



    /**
     * action showRest
     * 
     * @return void
     */
    public function showRestAction()
    {
    }
    public function initializeMostViewedAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    /**
     * action mostViewed
     * 
     * @return void
     */
    public function mostViewedAction()
    {
        $arguments = $this->request->getArguments();
        $time = $arguments['time'];
        $results = $this->unalNewsRepository->getMostViewed($time);
        $collection_parsed_results = array();
        foreach ($results as $news) {
            array_push($collection_parsed_results, $news->parsedArray());
        }
        $jsonPreparedElements['results'] = $collection_parsed_results;
        $this->view->assign('value', $jsonPreparedElements);
    }

    /*
     * Actions for Buscador de convergencia
     */
    public function initializeAllRestAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    /**
     * Create demand to search news paginated
     * 
     * @param $page
     * @param $size
     * @return NewsDemand
     */
    protected function createDemandObject($page = 1, $size = 22)
    {
        $demand = $this->objectManager->get(NewsDemand::class);
        $begin = ($page - 1) * $size;
        $demand->setOffset($begin);
        $demand->setLimit($size);
        $demand->setOrder('datetime desc');
        $demand->setOrderByAllowed('datetime');
        $demand->setStoragePage(FALSE);
        return $demand;
    }

    /**
     * action allRest
     * 
     * @return void
     */
    public function allRestAction()
    {
        $totalElements = $this->unalNewsRepository->total();
        $jsonPreparedElements = array();
        $arguments = $this->request->getArguments();

        //$result = $this->unalNewsRepository->findAll();
        //DebugUtility::debug($arguments,"arguments");
        #GET Page to load
        if ($arguments['page'] and $arguments['page'] != '') {
            $page_to_load = $arguments['page'];
        } else {
            $page_to_load = 1;
        }
        $objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $externalNewsRepository = $objectManager->get(\GeorgRinger\News\Domain\Repository\NewsRepository::class);
        $demand = $this->createDemandObject($page_to_load, 100);
        $result = $externalNewsRepository->findDemanded($demand);

        //DebugUtility::debug($result,"result");
        //exit();
        $collection_parsed_results = array();
        $tipo = $arguments['type'];
        foreach ($result as $news) {
            if (method_exists($news, 'parsedArray')) {
                $media_array = $news->parsedArrayElastic(false, $tipo);

                //DebugUtility::debug($media_array,"chao");
                if ($tipo != "new") {

                    //DebugUtility::debug($media_array,"chao");
                    foreach ($media_array as $media) {
                        array_push($collection_parsed_results, $media);
                    }
                } else {
                    array_push($collection_parsed_results, $media_array);
                }
            }
        }
        $jsonPreparedElements['results'] = $collection_parsed_results;
        $this->view->assign('value', $collection_parsed_results);
    }
    public function initializeDeletedRestAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    /**
     * action deletedRest
     * 
     * @return void
     */
    public function deletedRestAction()
    {
        $arguments = $this->request->getArguments();
        $jsonPreparedElements = array();
        $yesterday = time() - 86400;
        $result = $this->unalNewsRepository->getDeleted($yesterday);

        //DebugUtility::debug($result,"chao");
        $collection_parsed_results = array();
        foreach ($result as $news) {
            array_push($collection_parsed_results, $news->getUid());
        }
        $jsonPreparedElements['results'] = $collection_parsed_results;
        $jsonPreparedElements['info']['count'] = count($collection_parsed_results);
        $this->view->assign('value', $collection_parsed_results);
    }
    public function initializeEditedRestAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    /**
     * action editedRest
     * 
     * @return void
     */
    public function editedRestAction()
    {
        $arguments = $this->request->getArguments();
        $jsonPreparedElements = array();
        $yesterday = time() - 86400;
        $result = $this->unalNewsRepository->getEdited($yesterday);

        //DebugUtility::debug(time()-86400,"chao");
        $collection_parsed_results = array();
        foreach ($result as $news) {
            array_push($collection_parsed_results, $news->parsedArrayElastic(false, "new"));
        }
        $jsonPreparedElements['results'] = $collection_parsed_results;
        $jsonPreparedElements['info']['count'] = count($collection_parsed_results);
        $this->view->assign('value', $collection_parsed_results);
    }

    /**
     * @param \UNAL\UnalNews\Domain\Repository\UnalNewsRepository $unalNewsRepository
     */
    public function injectUnalNewsRepository(\UNAL\UnalNews\Domain\Repository\UnalNewsRepository $unalNewsRepository)
    {
        $this->unalNewsRepository = $unalNewsRepository;
    }
}
