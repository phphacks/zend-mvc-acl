<?php

namespace Zend\Mvc\Acl\Interfaces;

use Zend\Stdlib\Request;

/**
 * AuthInterface
 *
 * @package Zend\Mvc\Acl\Interfaces
 */
interface AuthInterface
{
    /**
     * @param Request $request
     */
    public function validate(Request $request): void;
}