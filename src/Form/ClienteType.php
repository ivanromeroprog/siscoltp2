<?php

namespace App\Form;

use App\Entity\Cliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Dni', NumberType::class, ['html5' => true, 'scale' => 0, 'attr' => ['min' => '0'], 'disabled' => $options['view']])
            ->add('Nombre', TextType::class, ['disabled' => $options['view']])
            ->add('Apellido', TextType::class, ['disabled' => $options['view']])
            ->add('Telefono', TelType::class,['required' => false,'label'=>'Teléfono','disabled' => $options['view']])
            ->add('Direccion', TextType::class,['required' => false,'label'=>'Dirección','disabled' => $options['view']])
            ->add('Submit', SubmitType::class, ['label'=>'Guardar', 'attr'=>[ 'style'=>"float:right;"],'disabled' => $options['view']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cliente::class,
            'view' => false
        ]);
    }
}
