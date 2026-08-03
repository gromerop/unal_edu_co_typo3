<?php
namespace UNAL\UnalNews\Controller;


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
 * VisitCounterController
 */
class VisitCounterController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * visitCounterRepository
     * 
     * @var \UNAL\UnalNews\Domain\Repository\VisitCounterRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $visitCounterRepository = null;

    /**
     * unalNewsRepository
     * 
     * @var \UNAL\UnalNews\Domain\Repository\UnalNewsRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $unalNewsRepository = null;
    public function initializeEditAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    /**
     * action edit
     */
    public function editAction()
    {
        $arguments = $this->request->getArguments();
        $jsonPreparedElements['mesagge'] = 'Esta vacía la identifación de la noticia.';
        if (isset($arguments['queryparams']['news']) and $arguments['queryparams']['news'] > 0) {
            $newsUid = $arguments['queryparams']['news'];
        }
        if ($newsUid) {
            $news = $this->unalNewsRepository->findByUid($newsUid);
            if ($news) {
                $news->actualizarVisita();
                $this->unalNewsRepository->update($news);
                $jsonPreparedElements['mesagge'] = 'Se registró la visita.';
            }
        }
        $this->view->assign('value', $jsonPreparedElements);
    }

    /**
     * action update
     * 
     * @param \UNAL\UnalNews\Domain\Model\VisitCounter $visitCounter
     * @return void
     */
    public function updateAction(\UNAL\UnalNews\Domain\Model\VisitCounter $visitCounter)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->visitCounterRepository->update($visitCounter);
        $this->redirect('list');
    }

    /**
     * action selectorReport
     * 
     * @return void
     */
    public function selectorReportAction()
    {
    }

    /**
     * action generateReport
     * 
     * @return void
     */
    public function generateReportAction()
    {
    }

    /**
     * @param \UNAL\UnalNews\Domain\Repository\VisitCounterRepository $visitCounterRepository
     */
    public function injectVisitCounterRepository(\UNAL\UnalNews\Domain\Repository\VisitCounterRepository $visitCounterRepository)
    {
        $this->visitCounterRepository = $visitCounterRepository;
    }
}
