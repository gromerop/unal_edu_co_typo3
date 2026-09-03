<?php
declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Tests\Unit\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class CuentaTest extends UnitTestCase
{
    /**
     * @var \UNAL\UnalSocialMedia\Domain\Model\Cuenta
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \UNAL\UnalSocialMedia\Domain\Model\Cuenta();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNombreCuentaReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getNombreCuenta()
        );
    }

    /**
     * @test
     */
    public function setNombreCuentaForStringSetsNombreCuenta()
    {
        $this->subject->setNombreCuenta('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'nombreCuenta',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTipoReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTipo()
        );
    }

    /**
     * @test
     */
    public function setTipoForStringSetsTipo()
    {
        $this->subject->setTipo('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'tipo',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getUrlReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getUrl()
        );
    }

    /**
     * @test
     */
    public function setUrlForStringSetsUrl()
    {
        $this->subject->setUrl('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'url',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMediosReturnsInitialValueForMedio()
    {
        self::assertEquals(
            null,
            $this->subject->getMedios()
        );
    }

    /**
     * @test
     */
    public function setMediosForMedioSetsMedios()
    {
        $mediosFixture = new \UNAL\UnalSocialMedia\Domain\Model\Medio();
        $this->subject->setMedios($mediosFixture);

        self::assertAttributeEquals(
            $mediosFixture,
            'medios',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getResponsableReturnsInitialValueForResponsable()
    {
        self::assertEquals(
            null,
            $this->subject->getResponsable()
        );
    }

    /**
     * @test
     */
    public function setResponsableForResponsableSetsResponsable()
    {
        $responsableFixture = new \UNAL\UnalSocialMedia\Domain\Model\Responsable();
        $this->subject->setResponsable($responsableFixture);

        self::assertAttributeEquals(
            $responsableFixture,
            'responsable',
            $this->subject
        );
    }
}
