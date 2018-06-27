<?php

namespace Zend\Db\Acl\Custom;

use Zend\Http\Request;

interface AuthorizatorInterface
{
    public function authorize(Request $request);
}