<?php

namespace Module\Api;

use Module\Api\Exception;
use Module\Api\Listener\ResolveExceptionToJsonModelListener;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Loader\StandardAutoloader;
use Zend\View\Model\JsonModel;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sm = $e->getApplication()->getServiceManager();
        $resolveExceptionToJsonModelListener = $sm->get(ResolveExceptionToJsonModelListener::class);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, $resolveExceptionToJsonModelListener, 0);
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, $resolveExceptionToJsonModelListener, 0);
    }

    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/config/controller.config.php',
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/router.config.php',
            include __DIR__ . '/config/service.config.php'
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            StandardAutoloader::class => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/Api',
                    __NAMESPACE__ . 'Test' => __DIR__ . '/test/ApiTest'
                ),
            ),
        );
    }
}
