<?php

namespace App\Form;

use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nombre', TextType::class,['disabled' => $options['view']] )
            ->add('Descripcion', TextareaType::class, ['label' => 'Descripción', 'required'=>false, 'disabled' => $options['view']])
            ->add('Precio', NumberType::class, ['label'=> 'Precio ($)','html5' => true, 'scale' => 2, 'attr' => ['min' => '0','max'=>'999999999', 'step'=>'1'], 'disabled' => $options['view']])
            ->add('Stock', NumberType::class, ['html5' => true, 'scale' => 0, 'attr' => ['min' => '0','max'=>'999999999', 'step'=>'1'], 'disabled' => $options['view']])
            ;
        
        if(!$options['view'])
            $builder->add('Submit', SubmitType::class, ['label'=>'Guardar', 'attr'=>[ 'style'=>"float:right;"],'disabled' => $options['view']]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
            'view' => false
        ]);
    }
}
