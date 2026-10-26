<?php
declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Tests\Unit\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class SedeTest extends UnitTestCase
{
    /**
     * @var \UNAL\UnalSocialMedia\Domain\Model\Sede
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \UNAL\UnalSocialMedia\Domain\Model\Sede();
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
}
