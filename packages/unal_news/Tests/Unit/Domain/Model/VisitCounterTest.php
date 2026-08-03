<?php
namespace UNAL\UnalNews\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Oficina de Medios DIgitales - Unimedios <mediosdigitales@unal.edu.co>
 * @author Martha Lucía Chaves Muñoz <mlchavezm@unal.edu.co>
 * @author César Hansy Dueñas Barragán <chduenasba@unal.edu.co>
 */
class VisitCounterTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \UNAL\UnalNews\Domain\Model\VisitCounter
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \UNAL\UnalNews\Domain\Model\VisitCounter();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getQuantityReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getQuantity()
        );
    }

    /**
     * @test
     */
    public function setQuantityForIntSetsQuantity()
    {
        $this->subject->setQuantity(12);

        self::assertAttributeEquals(
            12,
            'quantity',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFechaRegistroReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getFechaRegistro()
        );
    }

    /**
     * @test
     */
    public function setFechaRegistroForDateTimeSetsFechaRegistro()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setFechaRegistro($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'fechaRegistro',
            $this->subject
        );
    }
}
