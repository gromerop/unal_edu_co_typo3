<?php
namespace UNAL\UnalNews\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Oficina de Medios DIgitales - Unimedios <mediosdigitales@unal.edu.co>
 * @author Martha Lucía Chaves Muñoz <mlchavezm@unal.edu.co>
 * @author César Hansy Dueñas Barragán <chduenasba@unal.edu.co>
 */
class UnalNewsTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \UNAL\UnalNews\Domain\Model\UnalNews
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \UNAL\UnalNews\Domain\Model\UnalNews();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getIdentificatorReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getIdentificator()
        );
    }

    /**
     * @test
     */
    public function setIdentificatorForStringSetsIdentificator()
    {
        $this->subject->setIdentificator('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'identificator',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getVisitorCounterReturnsInitialValueForVisitCounter()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getVisitorCounter()
        );
    }

    /**
     * @test
     */
    public function setVisitorCounterForObjectStorageContainingVisitCounterSetsVisitorCounter()
    {
        $visitorCounter = new \UNAL\UnalNews\Domain\Model\VisitCounter();
        $objectStorageHoldingExactlyOneVisitorCounter = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneVisitorCounter->attach($visitorCounter);
        $this->subject->setVisitorCounter($objectStorageHoldingExactlyOneVisitorCounter);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneVisitorCounter,
            'visitorCounter',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addVisitorCounterToObjectStorageHoldingVisitorCounter()
    {
        $visitorCounter = new \UNAL\UnalNews\Domain\Model\VisitCounter();
        $visitorCounterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $visitorCounterObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($visitorCounter));
        $this->inject($this->subject, 'visitorCounter', $visitorCounterObjectStorageMock);

        $this->subject->addVisitorCounter($visitorCounter);
    }

    /**
     * @test
     */
    public function removeVisitorCounterFromObjectStorageHoldingVisitorCounter()
    {
        $visitorCounter = new \UNAL\UnalNews\Domain\Model\VisitCounter();
        $visitorCounterObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $visitorCounterObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($visitorCounter));
        $this->inject($this->subject, 'visitorCounter', $visitorCounterObjectStorageMock);

        $this->subject->removeVisitorCounter($visitorCounter);
    }
}
