<?php


namespace App\Dbal;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class Api implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container
            ->getDefinition('doctrine.dbal.dynamic_connection')
            ->addMethodCall('setDbSwitcher', [
                new Reference('database.switcher')
            ]);
    }
}