<?php

namespace Zend\Mvc\Acl\Module;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;

/**
 * ModuleInterface
 *
 * @package Zend\Mvc\Acl\Module
 */
interface ModuleInterface
{
    /**
     * @return array
     */
    public function getConfig(): array;

    /**
     * @param ModuleManager $manager
     */
    public function init(ModuleManager $manager): void;

    /**
     * @param MvcEvent $event
     */
    public function onDispatch(MvcEvent $event): void;
}