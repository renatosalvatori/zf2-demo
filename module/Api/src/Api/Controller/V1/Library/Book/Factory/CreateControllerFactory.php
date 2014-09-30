<?php

namespace Api\Controller\V1\Library\Book\Factory;

use Api\Controller\V1\Library\Book\CreateController;
use Library\Form\Book\CreateFormInputFilter;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return CreateController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();
        /**
         * @var $service CrudService
         * @var $filter  CreateFormInputFilter
         */
        $filter = $serviceLocator->get(CreateFormInputFilter::class);
        $service = $serviceLocator->get(CrudService::class);

        return new CreateController($filter, $service);
    }
}