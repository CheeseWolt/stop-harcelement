<?php

namespace App\Form;

use App\Entity\Sex;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\ClassName;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ProfilUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName')
            ->add('lastName')
            ->add('firstName')
            ->add('password')
            ->add('birthDate', DateType::class, [
                'required'=>false,
                'format'=>'dd-MM-yyyy',
                'empty_data'=> ''
            ])
            ->add('phone')
            ->add('address')
            ->add('email')
            ->add('role', EntityType::class, [
                'class'=>Role::class,
                'choice_label'=>'name'
            ])
            ->add('sex', EntityType::class, [
                'class'=>Sex::class,
                'choice_label'=>'name'
            ])
            ->add('studentClassName', EntityType::class, [
                'class'=>ClassName::class,
                'choice_label'=>'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
