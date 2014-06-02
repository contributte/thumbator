<?php

namespace Thumbator;

use Nette\Http\Request;

/**
 * Thumbator service factory
 *
 * @version 1.0-beta
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
final class Factory implements IFactory
{

    /** @var Request */
    private $httpRequest;

    /** @var Config */
    private $config;

    /** @var Manipulator */
    private $manipulator;

    /**
     * @param Request $request
     * @param Config $config
     * @param Manipulator $manipulator
     */
    function __construct(Request $request, Config $config, Manipulator $manipulator)
    {
        $this->httpRequest = $request;
        $this->config = $config;
        $this->manipulator = $manipulator;
    }

    /**
     * @return Service
     */
    public function create()
    {
        return new Service($this->config, $this->manipulator, $this->httpRequest);
    }
}