<?php
declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Tests\Unit\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class MedioTest extends UnitTestCase
{
    /**
     * @var \UNAL\UnalSocialMedia\Domain\Model\Medio
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \UNAL\UnalSocialMedia\Domain\Model\Medio();
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
    public function getIconoReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getIcono()
        );
    }

    /**
     * @test
     */
    public function setIconoForFileReferenceSetsIcono()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setIcono($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'icono',
            $this->subject
        );
    }
}
