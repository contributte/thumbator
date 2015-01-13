<?php

namespace Thumbator;

use Nette\Utils\Strings;

/**
 * File manipulator
 *
 * @version 1.0.0
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
final class Manipulator
{

    /** @var string */
    private $mask;

    /** @var array */
    private $placeholders = array(
        '%width%',
        '%height%',
        '%filename%',
        '%ext%',
        '%method%',
        '%day%',
        '%month%',
        '%year%',
        '%date%',
        '%time%',
        '%microtime%',
    );

    /**
     * @param string $mask
     */
    function __construct($mask = '%date%/%filename%.%ext%')
    {
        $this->mask = $mask;
    }

    /** GETTERS/SETTERS ***************************************************** */

    /**
     * @param string $mask
     */
    public function setMask($mask)
    {
        $this->mask = $mask;
    }

    /**
     * @return string
     */
    public function getMask()
    {
        return $this->mask;
    }

    /** API ***************************************************************** */

    /**
     * @param string $file
     * @return string
     */
    public function thumbalize($file)
    {
        return Strings::webalize($file, '.');
    }

    /**
     * @param string $file
     * @param int $width
     * @param int $height
     * @param int $method
     * @return string
     */
    public function mask($file, $width, $height, $method)
    {
        $pathinfo = pathinfo($file);
        $ext = isset($pathinfo['extension']) ? $pathinfo['extension'] : 'img';

        $replacements = array(
            intval($width),
            intval($height),
            $pathinfo['filename'],
            $ext,
            Helpers::method2name($method),
            date('d'),
            date('m'),
            date('Y'),
            date('dmy'),
            time(),
            microtime()
        );

        return str_replace($this->placeholders, $replacements, $this->mask);
    }

}