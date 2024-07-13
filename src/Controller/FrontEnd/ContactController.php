<?php

namespace App\Controller\FrontEnd;

use App\Service\FormHandler\ContactFormHandler;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;

#[Route("contact")]
class ContactController extends AbstractFOSRestController
{
    #[Rest\Post('')]
    public function contact(
        Request $request,
        ContactFormHandler $formHandler
    ): View
    {
        return $this->view($formHandler->handle($request));
    }
}
