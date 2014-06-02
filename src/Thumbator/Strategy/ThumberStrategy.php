<?php

namespace Thumbator\Strategy;

use Nette\InvalidStateException;
use Nette\Utils\Image;
use Nette\Utils\UnknownImageFileException;
use Thumbator\Helpers;
use Thumbator\Service;

/**
 * Thumb strategy
 *
 * @version 1.0-beta
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
final class ThumberStrategy
{

    /**
     * @param Service $thumbator
     * @param string $original
     * @param string $thumb
     * @param int $width
     * @param int $height
     * @param int $method
     * @return void
     */
    public function resize($thumbator, $original, $thumb, $width, $height, $method)
    {
        try {
            $image = Image::fromFile($original);
        } catch (UnknownImageFileException $e) {
            throw new InvalidStateException("Image: loading image error!");
        }

        // Create dirs
        Helpers::mkdir(dirname($thumb));

        // Resize image
        $image->resize($width, $height, $method);

        // Save thumb
        $image->save($thumb);
    }
}