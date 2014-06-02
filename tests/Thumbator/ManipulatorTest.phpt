<?php

/**
 * Test: Thumbator
 *
 * @testCase  Thumbator\ManipulatorTest
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @package Thumbator
 */

use Tester\TestCase;
use Thumbator\Manipulator;
use Nette\Utils\Image;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
class ManipulatorTest extends TestCase
{

    public function testThumbalize()
    {
        $inst = new Manipulator();
        Assert::equal('a-b-cdef-g', $inst->thumbalize('$a-b_cdef g'));
    }

    public function testMasks()
    {
        $inst = new Manipulator();

        $inst->setMask('%filename%');
        Assert::equal('test', $inst->mask('test.jpg', 100, 200, Image::FIT));

        $inst->setMask('%ext%');
        Assert::equal('jpg', $inst->mask('test.jpg', 100, 200, Image::FIT));

        $inst->setMask('%date%');
        Assert::equal(date('dmy'), $inst->mask('test.jpg', 100, 200, Image::FIT));

        $inst->setMask('%width%x%height%');
        Assert::equal('100x200', $inst->mask('test.jpg', 100, 200, Image::FIT));
    }

}

(new ManipulatorTest())->run();