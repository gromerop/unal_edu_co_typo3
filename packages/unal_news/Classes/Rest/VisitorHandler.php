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
class VisitorHandler implements HandlerInterface
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
       /* ------------ POST ------------- */
       # curl -X POST -H "Content-Type: application/json" -d '{"firstName":"john","lastName":"john"}' http://localhost:8888/rest/customhandler/create
       $router->add(
           Route::post(
               $request->getResourceType() . '/update/?',
               function (RestRequestInterface $request) {
                   $arguments = [
                       'queryparams' => $request->getSentData(),
                   ];
                   return $this->helper->callExtbasePlugin(
                    'Visitorcounter',
                    'UNAL',
                    'UnalNews',
                    'VisitCounter',
                    'edit',
                    $arguments
                   );
               }
           )
       );
    }
}