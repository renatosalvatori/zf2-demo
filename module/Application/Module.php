<?php

namespace Application;

use Module\Api\Exception\AbstractException;
use Zend\Log\Logger;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Loader\StandardAutoloader;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sharedManager = $eventManager->getSharedManager();
        $sm = $e->getApplication()->getServiceManager();

        $sharedManager->attach(
            'Zend\Mvc\Application',
            MvcEvent::EVENT_DISPATCH_ERROR,
            function (MvcEvent $e) use ($sm) {
                if (($exception = $e->getParam('exception')) && !($exception instanceof AbstractException)) {
                    /** @var Logger $logger */
                    $logger = $sm->get('Logger');
                    $logger->crit($e->getParam('exception'));
                }
            }
        );
    }

    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/controller.config.php',
            include __DIR__ . '/config/router.config.php',
            include __DIR__ . '/config/console-router.config.php',
            include __DIR__ . '/config/service.config.php',
            include __DIR__ . '/config/view.config.php'
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            StandardAutoloader::class => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    __NAMESPACE__ . 'Test' => __DIR__ . '/test/' . __NAMESPACE__ . 'Test'
                ),
            ),
        );
    }

}
