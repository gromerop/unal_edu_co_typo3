<?php
namespace UNAL\UnalBase\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Oficina de Medios Digitales - Unimedios <mediosdigitales@unal.edu.co>
 * @author Giovanni Romero Pérez <gromerop@unal.edu.co>
 */
class DependenciaControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \UNAL\UnalBase\Controller\DependenciaController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\UNAL\UnalBase\Controller\DependenciaController::class)
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
    public function listActionFetchesAllDependenciasFromRepositoryAndAssignsThemToView()
    {

        $allDependencias = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dependenciaRepository = $this->getMockBuilder(\UNAL\UnalBase\Domain\Repository\DependenciaRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $dependenciaRepository->expects(self::once())->method('findAll')->will(self::returnValue($allDependencias));
        $this->inject($this->subject, 'dependenciaRepository', $dependenciaRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('dependencias', $allDependencias);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenDependenciaToView()
    {
        $dependencia = new \UNAL\UnalBase\Domain\Model\Dependencia();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('dependencia', $dependencia);

        $this->subject->showAction($dependencia);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenDependenciaToDependenciaRepository()
    {
        $dependencia = new \UNAL\UnalBase\Domain\Model\Dependencia();

        $dependenciaRepository = $this->getMockBuilder(\UNAL\UnalBase\Domain\Repository\DependenciaRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $dependenciaRepository->expects(self::once())->method('add')->with($dependencia);
        $this->inject($this->subject, 'dependenciaRepository', $dependenciaRepository);

        $this->subject->createAction($dependencia);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenDependenciaToView()
    {
        $dependencia = new \UNAL\UnalBase\Domain\Model\Dependencia();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('dependencia', $dependencia);

        $this->subject->editAction($dependencia);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenDependenciaInDependenciaRepository()
    {
        $dependencia = new \UNAL\UnalBase\Domain\Model\Dependencia();

        $dependenciaRepository = $this->getMockBuilder(\UNAL\UnalBase\Domain\Repository\DependenciaRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $dependenciaRepository->expects(self::once())->method('update')->with($dependencia);
        $this->inject($this->subject, 'dependenciaRepository', $dependenciaRepository);

        $this->subject->updateAction($dependencia);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenDependenciaFromDependenciaRepository()
    {
        $dependencia = new \UNAL\UnalBase\Domain\Model\Dependencia();

        $dependenciaRepository = $this->getMockBuilder(\UNAL\UnalBase\Domain\Repository\DependenciaRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $dependenciaRepository->expects(self::once())->method('remove')->with($dependencia);
        $this->inject($this->subject, 'dependenciaRepository', $dependenciaRepository);

        $this->subject->deleteAction($dependencia);
    }
}
