<?php
declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Tests\Unit\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class DependenciaTest extends UnitTestCase
{
    /**
     * @var \UNAL\UnalSocialMedia\Domain\Model\Dependencia
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \UNAL\UnalSocialMedia\Domain\Model\Dependencia();
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
    public function getFacultadReturnsInitialValueForFacultad()
    {
        self::assertEquals(
            null,
            $this->subject->getFacultad()
        );
    }

    /**
     * @test
     */
    public function setFacultadForFacultadSetsFacultad()
    {
        $facultadFixture = new \UNAL\UnalSocialMedia\Domain\Model\Facultad();
        $this->subject->setFacultad($facultadFixture);

        self::assertAttributeEquals(
            $facultadFixture,
            'facultad',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCuentasReturnsInitialValueForCuenta()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getCuentas()
        );
    }

    /**
     * @test
     */
    public function setCuentasForObjectStorageContainingCuentaSetsCuentas()
    {
        $cuenta = new \UNAL\UnalSocialMedia\Domain\Model\Cuenta();
        $objectStorageHoldingExactlyOneCuentas = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneCuentas->attach($cuenta);
        $this->subject->setCuentas($objectStorageHoldingExactlyOneCuentas);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneCuentas,
            'cuentas',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addCuentaToObjectStorageHoldingCuentas()
    {
        $cuenta = new \UNAL\UnalSocialMedia\Domain\Model\Cuenta();
        $cuentasObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $cuentasObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($cuenta));
        $this->inject($this->subject, 'cuentas', $cuentasObjectStorageMock);

        $this->subject->addCuenta($cuenta);
    }

    /**
     * @test
     */
    public function removeCuentaFromObjectStorageHoldingCuentas()
    {
        $cuenta = new \UNAL\UnalSocialMedia\Domain\Model\Cuenta();
        $cuentasObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $cuentasObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($cuenta));
        $this->inject($this->subject, 'cuentas', $cuentasObjectStorageMock);

        $this->subject->removeCuenta($cuenta);
    }

    /**
     * @test
     */
    public function getSedeReturnsInitialValueForSede()
    {
        self::assertEquals(
            null,
            $this->subject->getSede()
        );
    }

    /**
     * @test
     */
    public function setSedeForSedeSetsSede()
    {
        $sedeFixture = new \UNAL\UnalSocialMedia\Domain\Model\Sede();
        $this->subject->setSede($sedeFixture);

        self::assertAttributeEquals(
            $sedeFixture,
            'sede',
            $this->subject
        );
    }
}
