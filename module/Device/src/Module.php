<?php

namespace Device;


use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;



class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\DeviceTable::class => function($container) {
                    $tableGateway = $container->get(Model\DeviceTableGateway::class);
                    return new Model\DeviceTable($tableGateway);
                },
                Model\DeviceTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Device());
                    return new TableGateway('device', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\DeviceController::class => function($container) {
                    return new Controller\DeviceController(
                        $container->get(Model\DeviceTable::class)
                    );
                },
            ],
        ];
    }

}