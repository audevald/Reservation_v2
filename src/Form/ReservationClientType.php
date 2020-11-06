<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ReservationClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('date', DateType::class, [
                'label' => 'A quelle date ?',
                'widget' => 'single_text'
                ])
            ->add('time', TimeType::class, [
                'label' => 'Pour quelle heure ?',
                'widget' => 'single_text'
                ])
            ->add('nb_client', null, [
                'label' => 'Combien de personnes ?'
            ])
            ->add('name', null, [
                'label' => 'A quel nom ?'
            ])
            ->add('phone', null, [
                'label' => 'Votre numéro de téléphone'
            ])
            ->add('email', null, [
                'label' => 'Votre email'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
