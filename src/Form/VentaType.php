<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Venta;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VentaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'cliente',
                EntityType::class,
                ['class' => Cliente::class, 'attr' => ['class' => 'js-choice']]
            )
            ->add(
                'TipoFactura',
                \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class,
                ['choices' => ['C' => 'C', 'B' => 'B', 'A' => 'A'], 'label' => 'Tipo de Factura']
            )
            ->add(
                'Factura',
                TextType::class,
                ['required' => true, 'label' => 'Nº de Factura']
            )
            ->add(
                'Fecha',
                DateTimeType::class,
                ['html5' => true, 'widget' => 'single_text',
                'attr' => ['placeholder' => 'aaaa-mm-ddThh:mm:ss',
                'onchange'=>'fechacel("venta_Fecha");']]
            )
            //->add('Total')
            //->add('Estado')
            //->add('usuario')
            ->add(
                'detalles',
                CollectionType::class,
                [
                    'entry_type' => DetalleVentaType::class,
                    'label' => false,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'by_reference' => false,
                ]
            )
            ->add('Submit', SubmitType::class, ['label' => 'Guardar', 'attr' => ['style' => "float:right;"]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Venta::class,
        ]);
    }
}
