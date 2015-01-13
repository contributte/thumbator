<?php

namespace Thumbator\Strategy;

use Nette\Utils\Image;
use Thumbator\Helpers;
use Thumbator\Service;

/**
 * Placehold.it strategy
 *
 * @version 1.0.0
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
final class PlaceholdStrategy
{

    /** @var string */
    private $placeholder = "http://placehold.it/%ux%u";

    /**
     * @param Service $thumbator
     * @param string $original
     * @param string $filename
     * @param int $width
     * @param int $height
     * @param int $method
     * @return string
     */
    public function placehold($thumbator, $original, $filename, $width, $height, $method)
    {
        try {
            $data = @file_get_contents(sprintf($this->placeholder, $width, $height));
            if ($data) {
                $image = Image::fromString($data);
                Helpers::mkdir(dirname($thumbator->config->getStorageDir() . DIRECTORY_SEPARATOR . $original));
                $image->save($thumbator->config->getStorageDir() . DIRECTORY_SEPARATOR . $original);
                return $thumbator->create($original, $width, $height, $method);
            }
        } catch (\Exception $e) {
            // Silent..
        }

        return sprintf($this->placeholder, $width, $height);
    }
}