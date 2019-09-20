<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Alert;
use App\Entity\Status;
use App\Entity\Location;
use App\Entity\AlertStyle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alertDate')
            ->add('eventDate')
            ->add('ipAddress')
            ->add('content')
            ->add('alertSender', EntityType::class, [
                'class'=>User::class, 
                'choice_label'=>'lastName'
            ])
            ->add('alertManager', EntityType::class, [
                'class'=>User::class, 
                'required'=>false, 
                'expanded'=>true,
                'choice_label'=>'lastName'
            ])
            ->add('location', EntityType::class, [
                'class'=>Location::class, 
                'expanded'=>true,
                'choice_label'=>'name'
            ])
            ->add('status', EntityType::class, [
                'class'=>Status::class, 
                'expanded'=>true,
                'choice_label'=>'name'
            ])
            ->add('alertStyle', EntityType::class, [
                'class'=>AlertStyle::class, 
                'multiple'=>true,
                'expanded'=>true,
                'choice_label'=>'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Alert::class,
        ]);
    }
}
