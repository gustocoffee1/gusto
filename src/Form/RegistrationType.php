<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',
                EmailType::class ,
                $this->getConfiguration("Adresse mail *","Adresse mail...")
            )
            ->add('firstname',
                TextType::class,
                $this->getConfiguration("Prénom *","Prénom...")
            )
            ->add('lastname',
                TextType::class,
                $this->getConfiguration("Nom*","Nom...")
            )
            ->add('phone',
                TextType::class,
                $this->getConfiguration("Téléphone *","Téléphone...")
            )
            ->add('society',
                TextType::class,
                $this->getConfiguration("Société","Société...",['required'=> false])
            )
            ->add('password',
                PasswordType::class,
                $this->getConfiguration("Mot de passe *","*******")
                )
            ->add('confirm_password',PasswordType::class,
                $this->getConfiguration("Confirmation du mot de passe","*******")
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
