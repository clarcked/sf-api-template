<?php


namespace App\Dbal;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

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
        $options = ["tag" => "default","name" => "default",];
        /** @var RequestStack $requestStack */
        $requestStack = $this->getContainer()
            ->get("request_stack");
        $request = $requestStack->getCurrentRequest();
        if (!$request) return $options;
        $headers = $request->headers;
        $options = [
            "tag" => $headers->get("project-tag") ?? 'default',
            "name" => $headers->get("project-name") ?? 'default',
            "user" => $headers->get("project-user") ?? '',
            "apikey" => $headers->get("project-apikey") ?? '',
        ];
        return $options;
    }
}