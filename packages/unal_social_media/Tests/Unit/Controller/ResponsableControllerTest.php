<?php
declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Tests\Unit\Controller;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class ResponsableControllerTest extends UnitTestCase
{
    /**
     * @var \UNAL\UnalSocialMedia\Controller\ResponsableController
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\UNAL\UnalSocialMedia\Controller\ResponsableController::class)
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
    public function listActionFetchesAllResponsablesFromRepositoryAndAssignsThemToView()
    {
        $allResponsables = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $responsableRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $responsableRepository->expects(self::once())->method('findAll')->will(self::returnValue($allResponsables));
        $this->inject($this->subject, 'responsableRepository', $responsableRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('responsables', $allResponsables);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
