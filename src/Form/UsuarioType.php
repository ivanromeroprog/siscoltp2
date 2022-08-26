<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, ['label' => 'Nombre de Usuario'])
            //->add('roles')
            ->add('password', RepeatedType::class, [
    'type' => PasswordType::class,
    'invalid_message' => 'Los campos de Clave deben ser iguales.',
    'options' => ['attr' => ['class' => 'password-field']],
    'required' => $options['required_password'],
    'first_options'  => ['label' => 'Clave'],
    'second_options' => ['label' => 'Repetir Clave'],
])
            ->add('email', EmailType::class)
            ->add('Dni', NumberType::class, ['html5' => true, 'scale' => 0, 'attr' => ['min' => '0']])
            ->add('Nombre')
            ->add('Apellido')
            ->add('Telefono', TelType::class, ['required' => false,'label' => 'Teléfono'])
            ->add('Direccion', TextType::class, ['required' => false,'label' => 'Dirección'])
            ->add('Submit', SubmitType::class, ['label' => 'Guardar', 'attr'=>[ 'style'=>"float:right;"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
            'required_password' => true,
        ]);
    }
}
