<?php
namespace UNAL\UnalBase\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Oficina de Medios Digitales - Unimedios <mediosdigitales@unal.edu.co>
 * @author Giovanni Romero Pérez <gromerop@unal.edu.co>
 */
class SolicitudDependenciaControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \UNAL\UnalBase\Controller\SolicitudDependenciaController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\UNAL\UnalBase\Controller\SolicitudDependenciaController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllSolicitudDependenciasFromRepositoryAndAssignsThemToView()
    {

        $allSolicitudDependencias = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $solicitudDependenciaRepository = $this->getMockBuilder(\UNAL\UnalBase\Domain\Repository\SolicitudDependenciaRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $solicitudDependenciaRepository->expects(self::once())->method('findAll')->will(self::returnValue($allSolicitudDependencias));
        $this->inject($this->subject, 'solicitudDependenciaRepository', $solicitudDependenciaRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('solicitudDependencias', $allSolicitudDependencias);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenSolicitudDependenciaToSolicitudDependenciaRepository()
    {
        $solicitudDependencia = new \UNAL\UnalBase\Domain\Model\SolicitudDependencia();

        $solicitudDependenciaRepository = $this->getMockBuilder(\UNAL\UnalBase\Domain\Repository\SolicitudDependenciaRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $solicitudDependenciaRepository->expects(self::once())->method('add')->with($solicitudDependencia);
        $this->inject($this->subject, 'solicitudDependenciaRepository', $solicitudDependenciaRepository);

        $this->subject->createAction($solicitudDependencia);
    }
}
