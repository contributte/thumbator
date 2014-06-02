<?php

/**
 * Test: Thumbator
 *
 * @testCase  Thumbator\ConfigTest
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @package Thumbator
 */

use Tester\TestCase;
use Thumbator\Config;
use Nette\Utils\Image;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
class ConfigTest extends TestCase
{

    public function testFields()
    {
        $inst = new Config('a', 'b', 'c');
        Assert::equal('a', $inst->getStorageDir());
        Assert::equal('b', $inst->getTempDir());
        Assert::equal('c', $inst->getTempPath());
    }

    public function testTrims()
    {
        $inst = new Config('a/', 'b/', '/c/');
        Assert::equal('a', $inst->getStorageDir());
        Assert::equal('b', $inst->getTempDir());
        Assert::equal('c', $inst->getTempPath());
    }
}

(new ConfigTest())->run();