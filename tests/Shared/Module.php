<?php

namespace Tests\Shared;

use Zend\Mvc\Acl\Module\AbstractModule;

/**
 * Module
 *
 * @package Tests\Shared
 */
class Module extends AbstractModule
{
    /**
     * @return array
     */
    public function getConfig(): array
    {
        return include __DIR__ . '/module.config.php';
    }

}