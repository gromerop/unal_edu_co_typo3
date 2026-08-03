<?php
namespace UNAL\UnalNews\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Oficina de Medios DIgitales - Unimedios <mediosdigitales@unal.edu.co>
 * @author Martha Lucía Chaves Muñoz <mlchavezm@unal.edu.co>
 * @author César Hansy Dueñas Barragán <chduenasba@unal.edu.co>
 */
class UnalNewsControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \UNAL\UnalNews\Controller\UnalNewsController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\UNAL\UnalNews\Controller\UnalNewsController::class)
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
    public function showActionAssignsTheGivenUnalNewsToView()
    {
        $unalNews = new \UNAL\UnalNews\Domain\Model\UnalNews();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('unalNews', $unalNews);

        $this->subject->showAction($unalNews);
    }
}
