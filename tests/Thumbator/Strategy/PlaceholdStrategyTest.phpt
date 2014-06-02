<?php

/**
 * Test: Thumbator\Strategy
 *
 * @testCase  Thumbator\Strategy\PlaceholdStrategyTest
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @package Thumbator
 */

use Tester\TestCase;
use Thumbator\Strategy\PlaceholdStrategy;
use Nette\Utils\Image;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
class PlaceholdStrategyTest extends TestCase
{

    public function testPlacehold()
    {
        $inst = new PlaceholdStrategy();
        Assert::equal('http://placehold.it/100x200', $inst->placehold(new FakeThumbator(), 'original.jpg', 'test.jpg', 100, 200, Image::FIT));
    }
}

(new PlaceholdStrategyTest())->run();