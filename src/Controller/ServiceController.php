<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Service\FormHandler\ServiceFormHandler;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Route("service")]
class ServiceController extends AbstractFOSRestController
{
    #[Rest\Get('/list')]
    #[Rest\View(serializerGroups: ['services_list'])]
    public function list(
        ServiceRepository $serviceRepository
    ): View
    {
        return $this->view(["success" => true, "services" => $serviceRepository->findAll()], Response::HTTP_OK);
    }

    #[Rest\Post('/create')]
    #[Rest\View(serializerGroups: ['services_list'])]
    public function create(
        Request $request,
        ServiceFormHandler $formHandler
    ): View
    {
        return $this->view($formHandler->handle(new Service(), $request, "POST"));
    }

    #[Rest\Patch('/{service}/update')]
    #[Rest\View(serializerGroups: ['services_list'])]
    public function update(
        Request $request,
        ServiceFormHandler $formHandler,
        Service $service
    ): View
    {
        return $this->view($formHandler->handle($service, $request, "PATCH"));
    }

    #[Rest\Delete('/{service}/delete')]
    public function delete(
        EntityManagerInterface $em,
        Service $service
    ): View
    {
        $em->remove($service);
        $em->flush();

        return $this->view(["success" => true, "message" => "Service deleted successfully"]);
    }
}
