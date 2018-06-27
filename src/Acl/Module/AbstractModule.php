<?php

namespace Zend\Mvc\Acl\Module;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Acl\Auth\Authorizator;
use Zend\Mvc\MvcEvent;

/**
 * AbstractModule
 *
 * @package Zend\Mvc\Acl\Module
 */
abstract class AbstractModule implements ModuleInterface
{
    /**
     * @param ModuleManager $manager
     */
    public function init(ModuleManager $manager): void
    {
        $eventManager = $manager->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        $sharedEventManager->attach(__NAMESPACE__, 'dispatch', [$this, 'onDispatch'], 100);
    }

    /**
     * @param MvcEvent $event
     * @throws \Zend\Mvc\Acl\Exceptions\AuthException
     */
    public function onDispatch(MvcEvent $event): void
    {
        $config = $this->getConfig();
        $serviceManager = $event->getApplication()->getServiceManager();
        $request = $event->getRequest();

        $authorizator = new Authorizator($config, $serviceManager);
        $authorizator->authorize($request);
    }
}