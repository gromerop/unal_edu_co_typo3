<?php
declare(strict_types=1);

namespace Unal\UnalSocialMedia\Tests\Unit\Controller;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class DependenciaControllerTest extends UnitTestCase
{
    /**
     * @var \Unal\UnalSocialMedia\Controller\DependenciaController
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Unal\UnalSocialMedia\Controller\DependenciaController::class)
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

        $dependenciaRepository = $this->getMockBuilder(\Unal\UnalSocialMedia\Domain\Repository\DependenciaRepository::class)
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
}
