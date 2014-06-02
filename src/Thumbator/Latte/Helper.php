<?php

namespace Thumbator\Latte;

use Nette\Utils\Image;
use Thumbator\Service;

/**
 * Thumbator latte helper
 *
 * @version 1.0-beta
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
class Helper
{

    /** @var Service */
    private $service;

    /**
     * @param Service $service
     */
    function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $src Image path
     * @param int $width Image width
     * @param int $height Image height
     * @param int $mode Image resize mod
     */
    public function image($src, $width = NULL, $height = NULL, $mode = Image::SHRINK_ONLY)
    {
        return $this->service->create(trim($src), $width, $height, $mode);
    }
}