<?php

namespace App\Form;

use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nombre')
            ->add('Descripcion', TextareaType::class, ['label' => 'Descripción', 'required'=>false])
            ->add('Precio', NumberType::class, ['label'=> 'Precio ($)','html5' => true, 'scale' => 2, 'attr' => ['min' => '0','max'=>'999999999', 'step'=>'1']])
            ->add('Stock', NumberType::class, ['html5' => true, 'scale' => 0, 'attr' => ['min' => '0','max'=>'999999999', 'step'=>'1']])
            ->add('Submit', SubmitType::class, ['label' => 'Guardar']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
