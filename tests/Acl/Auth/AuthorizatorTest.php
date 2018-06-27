<?php

namespace Tests\Acl\Auth;

use PHPUnit\Framework\TestCase;
use Tests\Shared\Module;
use Tests\Shared\MyAuthorizer;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Acl\Enum\ServiceEnum;
use Zend\Mvc\Acl\Exceptions\AuthException;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Service\EventManagerFactory;
use Zend\ServiceManager\ServiceManager;

class AuthorizatorTest extends TestCase
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var MvcEvent
     */
    private $mvcEvent;

    /**
     * setup
     */
    public function setUp(): void
    {
        $this->request = new Request();

        $serviceManager = new ServiceManager(include __DIR__ . '/../../Shared/module.config.php');
        $serviceManager->setFactory('EventManager', new EventManagerFactory());
        $serviceManager->setService('Request', $this->request);
        $serviceManager->setService('Response', new Response());
        $serviceManager->setService(ServiceEnum::AUTHORIZATOR, new MyAuthorizer());

        $this->mvcEvent = new MvcEvent();
        $this->mvcEvent->setApplication(new Application($serviceManager));
    }

    public function testWhenAnAuthorizedRequestIsMade(): void
    {
        $success = true;

        try
        {
            $this->request->setUri('/login');
            $this->mvcEvent->setRequest($this->request);

            $module = new Module();
            $module->onDispatch($this->mvcEvent);
        }
        catch (AuthException $ex)
        {
            $success = false;
        }

        $this->assertTrue($success);
    }

    /**
     * @expectedException \Zend\Mvc\Acl\Exceptions\AuthException
     */
    public function testWhenAnUnauthorizedRequestIsMade(): void
    {
        $this->request->setUri('/notlogin');
        $this->mvcEvent->setRequest($this->request);

        $module = new Module();
        $module->onDispatch($this->mvcEvent);
    }
}