<?php
namespace UNAL\UnalBase\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Oficina de Medios Digitales - Unimedios <mediosdigitales@unal.edu.co>
 * @author Giovanni Romero Pérez <gromerop@unal.edu.co>
 */
class OficinaTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \UNAL\UnalBase\Domain\Model\Oficina
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \UNAL\UnalBase\Domain\Model\Oficina();
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
    public function getDependenciaReturnsInitialValueForDependencia()
    {
        self::assertEquals(
            null,
            $this->subject->getDependencia()
        );

    }

    /**
     * @test
     */
    public function setDependenciaForDependenciaSetsDependencia()
    {
        $dependenciaFixture = new \UNAL\UnalBase\Domain\Model\Dependencia();
        $this->subject->setDependencia($dependenciaFixture);

        self::assertAttributeEquals(
            $dependenciaFixture,
            'dependencia',
            $this->subject
        );

    }
}
