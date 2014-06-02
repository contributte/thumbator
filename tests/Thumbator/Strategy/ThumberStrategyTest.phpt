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
        $file = TEMP_DIR . '/test.jpg';
        $inst = new ThumberStrategy();
        $inst->resize(new FakeThumbator(), __DIR__ . '/../files/800x600.jpg', $file, 200, 100, Image::FIT);

        $image = Image::fromFile($file);
        Assert::equal(200, $image->width);
        Assert::equal(100, $image->height);
    }
}

if (!extension_loaded('gd')) {
    Environment::skip('PHP ext-gd is not loaded.');
} else {
    (new ThumberStrategyTest())->run();
}

