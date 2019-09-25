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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AlertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('alertDate',HiddenType::class, array('data' => date('Y-m-d')))   //Date du signalement
            ->add('eventDate', DateType::class, [        //Date de l'evenement
                'widget' => 'single_text',
                'html5'=>false,
                'label' => 'Date de l\'événement',
                'attr' => ['class' => 'js-datepicker'],

                ])          
            ->add('eventTime',TimeType::class, [        //Date de l'evenement
                'widget' => 'single_text',
                'html5'=>true,
                'label' => 'Date de l\'événement',
                'attr' => ['class' => 'js-datepicker'],

                ])          
            ->add('ipAddress', TextType::class, [
                'label' => 'Adresse Ip',
                ])           
            ->add('content', TextareaType::class, [
                'label' => 'Description de l\'événement',
            ])            //Contenu
            ->add('alertSender', EntityType::class, [       //Signalement expéditeur
                'class'=> User::class, 
                'choice_label'=>'lastName'          
            ])
            // ->add('alertManager', EntityType::class, [
            //     'class'=>User::class, 
            //     'required'=>false, 
            //     'expanded'=>true,
            //     'choice_label'=>'lastName'
            //])
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
                'expanded' => true,
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
