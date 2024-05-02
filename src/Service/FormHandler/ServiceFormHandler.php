<?php

namespace App\Service\FormHandler;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Service\FormHandler\Model\AbstractFormHandler;
use Symfony\Component\HttpFoundation\Request;

class ServiceFormHandler extends AbstractFormHandler
{
    public function handle(Service $service, Request $request, string $method): array
    {
        $data = json_decode($request->getContent(), true);

        $form = $this->formFactory->create(ServiceType::class, $service, [
            "method" => $method
        ]);

        $form->submit($data, !($method === "PATCH"));

        if (!$form->isValid()) {
            return ["success" => false, "errors" => $this->getFormErrors($form)];
        }

        $this->em->persist($service);
        $this->em->flush();

        return ["success" => true, "service" => $service];
    }
}