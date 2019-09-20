<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\ClassName;
use App\Entity\ClassLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassNameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('userManager', EntityType::class, [
                'class'=>User::class,
                'expanded'=>true,
                'choice_label'=>'lastName'
            ])
            ->add('classLevel', EntityType::class, [
                'class'=>ClassLevel::class,
                'expanded'=>true,
                'choice_label'=>'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClassName::class,
        ]);
    }
}
