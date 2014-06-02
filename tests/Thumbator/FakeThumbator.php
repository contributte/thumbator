<?php

require_once __DIR__ . '/bootstrap.php';

use Thumbator\Service;
use Thumbator\Config;
use Thumbator\Manipulator;
use Nette\Http\RequestFactory;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
final class FakeThumbator extends Service
{

    function __construct()
    {
        parent::__construct(new Config(TEMP_DIR, TEMP_DIR, 'tmp'), new Manipulator(), (new RequestFactory)->createHttpRequest());
    }

}