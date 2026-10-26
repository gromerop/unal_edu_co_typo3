<?php
declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Tests\Unit\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class ResponsableTest extends UnitTestCase
{
    /**
     * @var \UNAL\UnalSocialMedia\Domain\Model\Responsable
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \UNAL\UnalSocialMedia\Domain\Model\Responsable();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNombreReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getNombre()
        );
    }

    /**
     * @test
     */
    public function setNombreForStringSetsNombre()
    {
        $this->subject->setNombre('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'nombre',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getApellidosReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getApellidos()
        );
    }

    /**
     * @test
     */
    public function setApellidosForStringSetsApellidos()
    {
        $this->subject->setApellidos('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'apellidos',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTelefonoReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTelefono()
        );
    }

    /**
     * @test
     */
    public function setTelefonoForStringSetsTelefono()
    {
        $this->subject->setTelefono('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'telefono',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getExtensionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getExtension()
        );
    }

    /**
     * @test
     */
    public function setExtensionForStringSetsExtension()
    {
        $this->subject->setExtension('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'extension',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEmailReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail()
    {
        $this->subject->setEmail('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'email',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCargoReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCargo()
        );
    }

    /**
     * @test
     */
    public function setCargoForStringSetsCargo()
    {
        $this->subject->setCargo('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'cargo',
            $this->subject
        );
    }
}
