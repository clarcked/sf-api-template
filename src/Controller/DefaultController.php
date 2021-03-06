<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/")
     * @return JsonResponse
     */
    function index(): JsonResponse
    {
        $request = $this->get("request_stack");
        $resp = [];
        $resp["name"] = $request->getCurrentRequest()->headers->get("project-name") ?? "sf_api";
        $resp["tag"] = $request->getCurrentRequest()->headers->get("project-tag") ?? "default";
        $resp["apikey"] = $request->getCurrentRequest()->headers->get("project-apikey") ?? "0000";
        $resp["user"] = $request->getCurrentRequest()->headers->get("project-user") ?? "anonymous";
        return $this->json($resp);
    }
}