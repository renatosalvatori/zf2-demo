<?php

namespace Application\Listener\Lang\SLFactory;

use Application\Listener\Lang\LangRecognizer;
use Application\Model\LangConfig;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class LangRecognizerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LangRecognizer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var LangConfig $langConfig
         */
        $langConfig = $serviceLocator->get(LangConfig::class);

        return new LangRecognizer($langConfig);
    }
}