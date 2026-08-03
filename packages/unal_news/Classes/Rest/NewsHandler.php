<?php /** @noinspection PhpUnusedParameterInspection */
namespace UNAL\UnalNews\Rest;
use Cundd\Rest\Handler\HandlerInterface;
use Cundd\Rest\Http\RestRequestInterface;
use Cundd\Rest\Router\Route;
use Cundd\Rest\Router\RouterInterface;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
/**
 * Example handler
 */
class NewsHandler implements HandlerInterface
{
    /**
     * @var \Cundd\Rest\ObjectManagerInterface
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $objectManager;
    /**
     * @var \Cundd\Rest\ResponseFactoryInterface
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $responseFactory;
    /**
     * @var \UNAL\UnalNews\Rest\Helper
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $helper;
    /**
     * @inheritDoc
     */
    public function configureRoutes(RouterInterface $router, RestRequestInterface $request)
    {

        /*------------------------------------------------------
         * Simple callback functions
         *-----------------------------------------------------*/
        /*
         * These custom handler example routes return hardcoded values. They do not call any
         * extbase controller functions. (For that, see PersonController and Routes below.)
         */
        # curl -X GET http://localhost:8888/rest/customhandler
        $router->add(
            Route::get(
                $request->getResourceType(),
                function (RestRequestInterface $request) {
                    return [
                        'path'         => $request->getPath(),
                        'uri'          => (string)$request->getUri(),
                        'resourceType' => (string)$request->getResourceType(),
                    ];
                }
            )
        );
//        /* ------------ GET ------------- */
        # curl -X GET http://localhost:8888/rest/cund 
        $router->add(
            Route::get(
                '/unal-unal_news-unalNews/?',
                function (RestRequestInterface $request) {                    
                    return $this->helper->callExtbasePlugin(
                        'Vistasrest',
                        'UNAL',
                        'UnalNews',
                        'UnalNews',
                        'listRest',
                        []
                    );
                }
            )
        );
//        # curl -X GET http://localhost:8888/rest/cundd-custom_rest-person/show/12
        $router->add(
           Route::get(
               '/unal-unal_news-unalNews/show/{int}/?',
               function (RestRequestInterface $request, $int) {
                   $arguments = [
                       'uid' => $int,
                   ];
                   return $this->helper->callExtbasePlugin(
                       'Vistasrest',
                       'UNAL',
                       'UnalNews',
                       'UnalNews',
                       'showRest',
                       $arguments
                   );
               }
           )
       );

       $router->add(
        Route::get(
            '/unal-unal_news-unalNews/page/{int}/?',
            function (RestRequestInterface $request, $int) {
                $arguments = [
                    'page' => $int,
                ];
                return $this->helper->callExtbasePlugin(
                    'Vistasrest',
                    'UNAL',
                    'UnalNews',
                    'UnalNews',
                    'listRest',
                    $arguments
                );
            }
        )
        );
        
       /* ------------ POST ------------- */
       # curl -X POST -H "Content-Type: application/json" -d '{"firstName":"john","lastName":"john"}' http://localhost:8888/rest/customhandler/create
       $router->add(
           Route::post(
               '/unal-unal_news-unalNews/search/?',
               function (RestRequestInterface $request) {
                   $arguments = [
                       'queryparams' => $request->getSentData(),
                   ];
                   return $this->helper->callExtbasePlugin(
                    'Vistasrest',
                    'UNAL',
                    'UnalNews',
                    'UnalNews',
                    'searchRest',
                    $arguments
                   );
               }
           )
       );

       // End Points for Buscador de convergencia
       $router->add(
        Route::get(
                '/unal-unal_news-unalNews/all/{string}/{int}/?',
                function (RestRequestInterface $request, $string, $int) {
                    $arguments = [
                        'type' => $string,
                        'page' => $int
                    ];
                return $this->helper->callExtbasePlugin(
                    'Vistasrest',
                    'UNAL',
                    'UnalNews',
                    'UnalNews',
                    'allRest',
                    $arguments
                );
            }
        )
    );
    // End Points for get all news
    $router->add(
        Route::get(
                '/unal-unal_news-unalNews/autocomplete/{string}',
                function (RestRequestInterface $request, $string) {
                    $arguments = [
                        'search' => $string,
                    ];
                return $this->helper->callExtbasePlugin(
                    'Vistasrest',
                    'UNAL',
                    'UnalNews',
                    'UnalNews',
                    'autocompleteRest',
                    $arguments
                );
            }
        )
    );

    $router->add(
        Route::get(
            '/unal-unal_news-unalNews/deleted/?',
            function (RestRequestInterface $request) {
                return $this->helper->callExtbasePlugin(
                    'Vistasrest',
                    'UNAL',
                    'UnalNews',
                    'UnalNews',
                    'deletedRest',
                    []
                );
            }
        )
    );
    $router->add(
        Route::get(
            '/unal-unal_news-unalNews/edited/?',
            function (RestRequestInterface $request) {
                return $this->helper->callExtbasePlugin(
                    'Vistasrest',
                    'UNAL',
                    'UnalNews',
                    'UnalNews',
                    'editedRest',
                    []
                );
            }
        )
    );
    }
}