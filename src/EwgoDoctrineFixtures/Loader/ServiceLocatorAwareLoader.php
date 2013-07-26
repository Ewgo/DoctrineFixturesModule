<?php

namespace EwgoDoctrineFixtures\Loader;

use Doctrine\Common\DataFixtures\Loader;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;

/**
 * Doctrine fixtures loader
 * Injects the Servicemanager into ServiceLocatorAware fixture classes
 *
 * @package EwgoDoctrineFixtures\Loader
 */
class ServiceLocatorAwareLoader extends Loader
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * Initialization
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * {@inheritdoc}
     */
    public function addFixture(FixtureInterface $fixture)
    {
        if ($fixture instanceof ServiceLocatorAwareInterface) {
            $fixture->setServiceLocator($this->serviceLocator);
        }

        parent::addFixture($fixture);
    }
}