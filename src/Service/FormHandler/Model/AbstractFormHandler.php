<?php

namespace App\Service\FormHandler\Model;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

abstract class AbstractFormHandler
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected FormFactoryInterface   $formFactory
    )
    {
    }

    protected function getFormErrors(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $key => $error) {
            $template = $error->getMessageTemplate();
            $parameters = $error->getMessageParameters();

            foreach ($parameters as $var => $value) {
                $template = str_replace($var, $value, $template);
            }

            $errors[$key] = $template;
        }

        if ($form->count()) {
            foreach ($form as $child) {
                if ($child->isSubmitted() && !$child->isValid()) {
                    $errors[$child->getName()] = $this->getFormErrors($child);
                }
            }
        }

        return $errors;
    }
}