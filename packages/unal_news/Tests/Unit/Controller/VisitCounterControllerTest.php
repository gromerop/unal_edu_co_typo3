<?php
namespace UNAL\UnalNews\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Oficina de Medios DIgitales - Unimedios <mediosdigitales@unal.edu.co>
 * @author Martha Lucía Chaves Muñoz <mlchavezm@unal.edu.co>
 * @author César Hansy Dueñas Barragán <chduenasba@unal.edu.co>
 */
class VisitCounterControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \UNAL\UnalNews\Controller\VisitCounterController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\UNAL\UnalNews\Controller\VisitCounterController::class)
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
    public function editActionAssignsTheGivenVisitCounterToView()
    {
        $visitCounter = new \UNAL\UnalNews\Domain\Model\VisitCounter();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('visitCounter', $visitCounter);

        $this->subject->editAction($visitCounter);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenVisitCounterInVisitCounterRepository()
    {
        $visitCounter = new \UNAL\UnalNews\Domain\Model\VisitCounter();

        $visitCounterRepository = $this->getMockBuilder(\UNAL\UnalNews\Domain\Repository\VisitCounterRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $visitCounterRepository->expects(self::once())->method('update')->with($visitCounter);
        $this->inject($this->subject, 'visitCounterRepository', $visitCounterRepository);

        $this->subject->updateAction($visitCounter);
    }
}
