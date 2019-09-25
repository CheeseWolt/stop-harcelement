<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ProfilUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName', TextType::class)
            // ->add('lastName')
            // ->add('firstName')
            // ->add('password')
            // ->add('birthDate', DateType::class, [
            //     'required'=>false,
            //     'format'=>'dd-MM-yyyy',
            //     'empty_data'=> ''
            // ])
            ->add('phone', TelType::class)
            ->add('address', TextType::class)
            ->add('email', EmailType::class)
            // ->add('role', EntityType::class, [
            //     'class'=>Role::class,
            //     'choice_label'=>'name'
            // ])
            // ->add('sex', EntityType::class, [
            //     'class'=>Sex::class,
            //     'choice_label'=>'name'
            // ])
            // ->add('studentClassName', EntityType::class, [
            //     'class'=>ClassName::class,
            //     'choice_label'=>'name'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
