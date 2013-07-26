<?php

namespace EwgoDoctrineFixtures;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\EventManager\EventInterface;
use EwgoDoctrineFixtures\Command\LoadFixturesCommand;

class Module implements AutoloaderProviderInterface, InitProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function init(ModuleManagerInterface $moduleManager)
    {
        $moduleManager->getEventManager()->getSharedManager()
            ->attach('doctrine', 'loadCli.post', function(EventInterface $e){
                $command = new LoadFixturesCommand();
                $command->setServiceLocator($e->getParam('ServiceManager'));
                $e->getTarget()->add($command);
            });
    }
}
