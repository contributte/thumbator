<?php

namespace Thumbator;

use Nette\Http\Request;
use Nette\Object;
use Nette\Utils\Image;
use Nette\InvalidArgumentException;
use Nette\InvalidStateException;

/**
 * Thumbator service - easy-use util for resizing images on website
 *
 * @version 1.0-beta
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 *
 * @property-read Config $config
 * @property-read Manipulator $manipulator
 *
 * @method onResize(Service $thumbator, string $original, string $thumb, int $width, int $height, int $method)
 * @method onPlacehold(Service $thumbator, string $original, string $filename, int $width, int $height, int $method)
 */
class Service extends Object
{

    /** Thumbator modes */
    const MODE_STRICT = 1;
    const MODE_SILENT = 2;

    /** @var int */
    private $mode = self::MODE_STRICT;

    /** @var Request */
    private $httpRequest;

    /** @var Config */
    private $config;

    /** @var Manipulator */
    private $manipulator;

    /** MAGIC METHODS */

    /** @var array of function($thumbator, $original, $thumb, $width, $height, $method) */
    public $onResize;

    /** @var array of function($thumbator, $original, $filename, $width, $height, $method) */
    public $onPlacehold;

    /**
     * @param Config $config
     * @param Manipulator $manipulator
     * @param Request $httpRequest
     */
    function __construct(Config $config, Manipulator $manipulator, Request $httpRequest)
    {
        $this->config = $config;
        $this->manipulator = $manipulator;
        $this->httpRequest = $httpRequest;
    }

    /** GETTERS/SETTERS ***************************************************** */

    /**
     * @param int $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return Manipulator
     */
    public function getManipulator()
    {
        return $this->manipulator;
    }

    /**
     * @param callable $callback
     * @throws InvalidArgumentException
     */
    public function registerResizeStrategy($callback)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Given callback is not callable');
        }
        $this->onResize[] = $callback;
    }

    /**
     * @param callable $callback
     * @throws InvalidArgumentException
     */
    public function registerPlaceholdStrategy($callback)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Given callback is not callable');
        }
        $this->onPlacehold[] = $callback;
    }

    /** HELPERS ************************************************************* */

    /**
     * @return string
     */
    protected function getBasePath()
    {
        return rtrim($this->httpRequest->url->basePath, '/');
    }

    /** API ***************************************************************** */

    /**
     * @param string $file
     * @param int $width
     * @param int $height
     * @param int $method
     * @return string
     * @throws InvalidStateException
     * @throws InvalidArgumentException
     */
    public function create($file, $width = NULL, $height = NULL, $method = Image::EXACT)
    {
        // Validate given file
        if ($file == NULL || empty($file)) {
            throw new InvalidArgumentException("Invalid file given!");
        }

        // Validate height and width
        if ($height == NULL && $width = NULL) {
            throw new InvalidArgumentException("Both params height and width can't be empty!");
        }

        // Validate resize method
        if ($method == NULL) {
            throw new InvalidArgumentException("Invalid resize method.");
        }

        // Validate strategy
        if (count($this->onResize) <= 0) {
            throw new InvalidStateException('No resize strategy found.');
        }

        // Absolute path to original file
        $original = $this->config->getStorageDir() . DIRECTORY_SEPARATOR . $file;

        // Webalize filename
        $filename = $this->manipulator->thumbalize($file);

        // Exist original file?
        if (!file_exists($original)) {
            if ($this->mode == self::MODE_SILENT) {
                return $this->onPlacehold($this, $file, $filename, $width, $height, $method);
            } else {
                throw new InvalidStateException("Original file ($original) does not exist!");
            }
        }

        // Generate mask
        $mask = $this->manipulator->mask($filename, $width, $height, $method);

        // Absolute path to thumb
        $thumb = $this->config->getTempDir() . DIRECTORY_SEPARATOR . $mask;

        // Exist thumb?
        if (!file_exists($thumb) || (filemtime($original) > filemtime($thumb))) {
            // Resize image to thumb
            $this->onResize($this, $original, $thumb, $width, $height, $method);

            // Clear pointers, variables, stats..
            unset($image);
            clearstatcache();
        }

        return implode('/', array($this->getBasePath(), $this->config->getTempPath(), $mask));
    }

}