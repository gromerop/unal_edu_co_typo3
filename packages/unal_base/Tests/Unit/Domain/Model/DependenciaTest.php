<?php
namespace UNAL\UnalBase\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Oficina de Medios Digitales - Unimedios <mediosdigitales@unal.edu.co>
 * @author Giovanni Romero Pérez <gromerop@unal.edu.co>
 */
class DependenciaTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \UNAL\UnalBase\Domain\Model\Dependencia
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \UNAL\UnalBase\Domain\Model\Dependencia();
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
    public function getIdSuperiorReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setIdSuperiorForIntSetsIdSuperior()
    {
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
    public function getOcultarEnPapeleriaReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getOcultarEnPapeleria()
        );

    }

    /**
     * @test
     */
    public function setOcultarEnPapeleriaForBoolSetsOcultarEnPapeleria()
    {
        $this->subject->setOcultarEnPapeleria(true);

        self::assertAttributeEquals(
            true,
            'ocultarEnPapeleria',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getDireccionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDireccion()
        );

    }

    /**
     * @test
     */
    public function setDireccionForStringSetsDireccion()
    {
        $this->subject->setDireccion('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'direccion',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getEdificioPisoReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEdificioPiso()
        );

    }

    /**
     * @test
     */
    public function setEdificioPisoForStringSetsEdificioPiso()
    {
        $this->subject->setEdificioPiso('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'edificioPiso',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getCiudadReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCiudad()
        );

    }

    /**
     * @test
     */
    public function setCiudadForStringSetsCiudad()
    {
        $this->subject->setCiudad('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'ciudad',
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
    public function getCodigoReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCodigo()
        );

    }

    /**
     * @test
     */
    public function setCodigoForStringSetsCodigo()
    {
        $this->subject->setCodigo('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'codigo',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getActoAdminReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getActoAdmin()
        );

    }

    /**
     * @test
     */
    public function setActoAdminForStringSetsActoAdmin()
    {
        $this->subject->setActoAdmin('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'actoAdmin',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getExcepcionReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getExcepcion()
        );

    }

    /**
     * @test
     */
    public function setExcepcionForBoolSetsExcepcion()
    {
        $this->subject->setExcepcion(true);

        self::assertAttributeEquals(
            true,
            'excepcion',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getPonerNombreEnEncabezadoReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getPonerNombreEnEncabezado()
        );

    }

    /**
     * @test
     */
    public function setPonerNombreEnEncabezadoForBoolSetsPonerNombreEnEncabezado()
    {
        $this->subject->setPonerNombreEnEncabezado(true);

        self::assertAttributeEquals(
            true,
            'ponerNombreEnEncabezado',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getTxtJerarquiaReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTxtJerarquia()
        );

    }

    /**
     * @test
     */
    public function setTxtJerarquiaForStringSetsTxtJerarquia()
    {
        $this->subject->setTxtJerarquia('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'txtJerarquia',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getOcultarReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getOcultar()
        );

    }

    /**
     * @test
     */
    public function setOcultarForBoolSetsOcultar()
    {
        $this->subject->setOcultar(true);

        self::assertAttributeEquals(
            true,
            'ocultar',
            $this->subject
        );

    }
}
