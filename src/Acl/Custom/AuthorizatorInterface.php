<?php

namespace Zend\Mvc\Acl\Custom;

use Zend\Http\Request;

interface AuthorizatorInterface
{
    public function authorize(Request $request);
}