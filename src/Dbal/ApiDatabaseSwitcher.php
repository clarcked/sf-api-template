<?php


namespace App\Dbal;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiDatabaseSwitcher
{
    use ContainerAwareTrait;

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function getWorkingEntityManager(): string
    {
        // return Request::getHeader('im-project-tag') ?? 'main' ;
        return 'default';
    }
}