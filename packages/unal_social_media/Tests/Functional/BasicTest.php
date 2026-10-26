<?php
declare(strict_types=1);

namespace UNAL\UnalSocialMedia\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test case
 */
class BasicTest extends FunctionalTestCase
{
    /**
     * @var array
     */
    protected array $testExtensionsToLoad = [
        'unal/unal-social-media',
    ];

    /**
     * Just a dummy to show that at least one test is actually executed
     *
     * @test
     */
    public function dummy()
    {
        $this->assertTrue(true);
    }
}
