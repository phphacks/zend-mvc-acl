<?php

namespace Zend\Mvc\Acl\Auth;

use Zend\Db\Acl\Custom\AuthorizatorInterface;
use Zend\Http\Request;
use Zend\Mvc\Acl\Enum\ServiceEnum;
use Zend\Mvc\Acl\Exceptions\AuthException;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Authorizator
 *
 * @package Zend\Mvc\Acl\Auth
 */
class Authorizator
{
    /**
     * @var array
     */
    private $whitelist = [];

    /**
     * @var ServiceManager
     */
    private $serviceManager;

    /**
     * Authorizator constructor.
     *
     * @param array $config
     * @param ServiceLocatorInterface $serviceManager
     */
    public function __construct(array $config, ServiceLocatorInterface $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        if (isset($config['router']) && isset($config['router']['whitelist'])) {
            $this->whitelist = $config['router']['whitelist'];
        }

    }

    /**
     * @param Request $request
     * @return bool
     * @throws AuthException
     */
    public function authorize(Request $request): bool
    {
        if (in_array($request->getUriString(), $this->whitelist)) {
            return true;
        }

        if (!$this->serviceManager->has(ServiceEnum::AUTHORIZATOR)) {
            throw new AuthException('Authorization service not defined.');
        }

        /** @var AuthorizatorInterface $authorizator */
        $authorizator = $this->serviceManager->get(ServiceEnum::AUTHORIZATOR);
        return $authorizator->authorize($request);
    }
}