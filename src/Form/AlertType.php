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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AlertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alertDate')
            // ->add('alertDate',HiddenType::class, array('data' => date('Y-m-d')))   //Date du signalement
            ->add('eventDate')
            // ->add('eventDate',DateTimeType::class)      //Date de l'evenement
            ->add('ipAddress')
            // ->add('ipAddress', HiddenType::class, array('data' => 1))   //Adresse ip
            // ->add('content')
            ->add('content',TextareaType::class)       //Contenu
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
