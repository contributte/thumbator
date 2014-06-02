<?php

/**
 * Test: Thumbator\Strategy
 *
 * @testCase  Thumbator\Strategy\ThumberStrategyTest
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @package Thumbator
 */

use Tester\TestCase;
use Thumbator\Strategy\ThumberStrategy;
use Nette\Utils\Image;
use Tester\Assert;
use Tester\Environment;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
class ThumberStrategyTest extends TestCase
{

    public function testResize()
    {
        $inst = new ThumberStrategy();
        $inst->resize(new FakeThumbator(), __DIR__ . '/../files/800x600.jpg', TEMP_DIR . '/test.jpg', 200, 100, Image::FIT);
    }
}

if (!extension_loaded('gd')) {
    Environment::skip('PHP ext-gd is not loaded.');
} else {
    (new ThumberStrategyTest())->run();
}

