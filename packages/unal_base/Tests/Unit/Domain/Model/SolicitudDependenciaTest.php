<?php
namespace UNAL\UnalBase\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Oficina de Medios Digitales - Unimedios <mediosdigitales@unal.edu.co>
 * @author Giovanni Romero Pérez <gromerop@unal.edu.co>
 */
class SolicitudDependenciaTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \UNAL\UnalBase\Domain\Model\SolicitudDependencia
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \UNAL\UnalBase\Domain\Model\SolicitudDependencia();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getSolicitanteReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setSolicitanteForIntSetsSolicitante()
    {
    }

    /**
     * @test
     */
    public function getNombreDependenciaReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getNombreDependencia()
        );

    }

    /**
     * @test
     */
    public function setNombreDependenciaForStringSetsNombreDependencia()
    {
        $this->subject->setNombreDependencia('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'nombreDependencia',
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
    public function getJustificacionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getJustificacion()
        );

    }

    /**
     * @test
     */
    public function setJustificacionForStringSetsJustificacion()
    {
        $this->subject->setJustificacion('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'justificacion',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getArchivoReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getArchivo()
        );

    }

    /**
     * @test
     */
    public function setArchivoForFileReferenceSetsArchivo()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setArchivo($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'archivo',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getFechaRespuestaReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getFechaRespuesta()
        );

    }

    /**
     * @test
     */
    public function setFechaRespuestaForDateTimeSetsFechaRespuesta()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setFechaRespuesta($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'fechaRespuesta',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getIdDependenciaCreadaReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setIdDependenciaCreadaForIntSetsIdDependenciaCreada()
    {
    }
}
