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

    public function getWorkingEntityManager(): array
    {
        $headers = $this->getContainer()
            ->get("request_stack")
            ->request->getCurrentRequest()
            ->headers;
        return [
            "name" => $headers->get("project-name") ?? 'default',
            "user" => $headers->get("project-user") ?? '',
            "apikey" => $headers->get("project-apikey") ?? '',
        ];
    }
}