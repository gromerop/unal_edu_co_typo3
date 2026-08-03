<?php
namespace UNAL\UnalNews\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Oficina de Medios DIgitales - Unimedios <mediosdigitales@unal.edu.co>
 * @author Martha Lucía Chaves Muñoz <mlchavezm@unal.edu.co>
 * @author César Hansy Dueñas Barragán <chduenasba@unal.edu.co>
 */
class CityTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \UNAL\UnalNews\Domain\Model\City
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \UNAL\UnalNews\Domain\Model\City();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->subject
        );
    }
}
