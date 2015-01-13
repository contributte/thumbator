<?php

namespace Thumbator;

/**
 * Thumbator configuration
 *
 * @version 1.0.0
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
final class Config
{

    /** @var string */
    private $storageDir;

    /** @var string */
    private $tempPath;

    /** @var string */
    private $tempDir;

    /**
     * @param string $storageDir
     * @param string $tempDir
     * @param string $tempPath
     */
    function __construct($storageDir, $tempDir, $tempPath)
    {
        $this->storageDir = rtrim($storageDir, '/');
        $this->tempDir = rtrim($tempDir, '/');
        $this->tempPath = trim($tempPath, '/');
    }

    /**
     * @return string
     */
    public function getStorageDir()
    {
        return $this->storageDir;
    }

    /**
     * @return string
     */
    public function getTempDir()
    {
        return $this->tempDir;
    }

    /**
     * @return string
     */
    public function getTempPath()
    {
        return $this->tempPath;
    }

}