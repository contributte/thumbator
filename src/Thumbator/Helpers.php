<?php

namespace Thumbator;

use Nette\Utils\Image;

/**
 * Thumbator helpers
 *
 * @version 1.0.0
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
final class Helpers
{

    /**
     * @param string $path
     * @return void
     */
    public static function mkdir($path)
    {
        @mkdir($path, 0777, TRUE);
    }

    /**
     * @param int $method
     * @return string
     */
    public static function method2name($method)
    {
        switch ($method) {
            case Image::SHRINK_ONLY:
                return 'shrink';
            case Image::FILL:
                return 'fill';
            case Image::FIT:
                return 'fit';
            case Image::STRETCH:
                return 'stretch';
            case Image::EXACT:
                return 'exact';
            default:
                return 'mix';
        }
    }
}

