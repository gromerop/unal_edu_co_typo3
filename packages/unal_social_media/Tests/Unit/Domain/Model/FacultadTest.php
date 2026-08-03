<?php
declare(strict_types=1);

namespace Unal\UnalSocialMedia\Tests\Unit\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class FacultadTest extends UnitTestCase
{
    /**
     * @var \Unal\UnalSocialMedia\Domain\Model\Facultad
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Unal\UnalSocialMedia\Domain\Model\Facultad();
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
        $sedeFixture = new \Unal\UnalSocialMedia\Domain\Model\Sede();
        $this->subject->setSede($sedeFixture);

        self::assertAttributeEquals(
            $sedeFixture,
            'sede',
            $this->subject
        );
    }
}
