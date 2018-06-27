<?php

namespace Tests\Shared;

use Zend\Mvc\Acl\Custom\AuthorizatorInterface;
use Zend\Http\Request;
use Zend\Mvc\Acl\Exceptions\AuthException;

class MyAuthorizer implements AuthorizatorInterface
{
    public function authorize(Request $request): bool
    {
        throw new AuthException('I deny everything, fuck you.');
    }
}