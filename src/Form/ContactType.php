<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "empty_data" => "",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add('email', EmailType::class, [
                "empty_data" => "",
                "constraints" => [
                    new NotBlank(),
                ]
            ])
            ->add('businessName', TextType::class, [
                "empty_data" => "",
                "constraints" => [
                    new NotBlank(),
                ]
            ])
            ->add('message', TextType::class, [
                "empty_data" => "",
                "constraints" => [
                    new NotBlank(),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }
}
