<?php
declare(strict_types=1);

namespace Unal\UnalSocialMedia\Tests\Unit\Controller;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class MedioControllerTest extends UnitTestCase
{
    /**
     * @var \Unal\UnalSocialMedia\Controller\MedioController
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Unal\UnalSocialMedia\Controller\MedioController::class)
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
    public function listActionFetchesAllMediosFromRepositoryAndAssignsThemToView()
    {
        $allMedios = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $medioRepository = $this->getMockBuilder(\Unal\UnalSocialMedia\Domain\Repository\MedioRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $medioRepository->expects(self::once())->method('findAll')->will(self::returnValue($allMedios));
        $this->inject($this->subject, 'medioRepository', $medioRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('medios', $allMedios);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
