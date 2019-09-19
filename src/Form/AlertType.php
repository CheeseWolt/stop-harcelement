<?php

namespace App\Form;

use App\Entity\Alert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('startSupportDate')
            ->add('endSupportDate')
            ->add('alertSender')
            ->add('alertManager')
            ->add('location')
            ->add('status')
            ->add('alertStyle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Alert::class,
        ]);
    }
}
