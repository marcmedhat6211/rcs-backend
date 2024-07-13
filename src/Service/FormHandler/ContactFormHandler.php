<?php

namespace App\Service\FormHandler;

use App\Entity\Service;
use App\Form\ContactType;
use App\Form\ServiceType;
use App\Service\FormHandler\Model\AbstractFormHandler;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactFormHandler extends AbstractFormHandler
{
    #[Pure]
    public function __construct(
        EntityManagerInterface $em,
        FormFactoryInterface $formFactory,
        private MailerInterface $mailer,
        private Security $security
    )
    {
        parent::__construct($em, $formFactory);
    }

    public function handle(Request $request): array
    {
        $data = json_decode($request->getContent(), true);

        $form = $this->formFactory->create(ContactType::class, $data, [
            "method" => "POST"
        ]);

        $form->submit($data, true);

        if (!$form->isValid()) {
            return ["success" => false, "errors" => $this->getFormErrors($form)];
        }

        $this->sendEmail($data);

        return ["success" => true, "message" => "Your message has been submitted successfully, we'll get back to you as soon as possible"];
    }

    private function sendEmail(array $data): void
    {
        $email = (new TemplatedEmail())
            ->from($_ENV["FROM_EMAIL"])
            ->to($_ENV["OWNER_EMAIL"])
            ->subject("Contact Us Email")
            ->htmlTemplate("contact/email.html.twig")
            ->context([
                "data" => $data
            ]);

        $this->mailer->send($email);
    }
}