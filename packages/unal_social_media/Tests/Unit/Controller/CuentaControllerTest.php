<?php
declare(strict_types=1);

namespace Unal\UnalSocialMedia\Tests\Unit\Controller;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class CuentaControllerTest extends UnitTestCase
{
    /**
     * @var \Unal\UnalSocialMedia\Controller\CuentaController
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Unal\UnalSocialMedia\Controller\CuentaController::class)
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
    public function listActionFetchesAllCuentasFromRepositoryAndAssignsThemToView()
    {
        $allCuentas = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $cuentaRepository = $this->getMockBuilder(\Unal\UnalSocialMedia\Domain\Repository\CuentaRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $cuentaRepository->expects(self::once())->method('findAll')->will(self::returnValue($allCuentas));
        $this->inject($this->subject, 'cuentaRepository', $cuentaRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('cuentas', $allCuentas);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
