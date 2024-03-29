<?php

namespace App\Form;

use App\Entity\DetalleVenta;
use App\Entity\Producto;
use App\Repository\ProductoRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetalleVentaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('producto', EntityType::class,
                        ['class' => Producto::class, 'label' => false,
                            'attr' => ['class' => 'js-choice'],
                            'query_builder' => function (ProductoRepository $er) {
                                return $er->createQueryBuilder('p')
                                ->where('p.Stock > 0')
                                ->orderBy('p.id', 'DESC');
                            },
                        ])
                ->add('Cantidad', NumberType::class,
                        ['html5' => true, 'scale' => 0, 'label' => false,
                            'attr' => ['min' => '0', 'max' => '999999999',
                                'step' => '1',
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'left',
                                'title' => 'Stock Actual: X', 'class' => 'producto_cantidad']])
        //->add('CostoUnitario', NumberType::class, ['label'=> 'CostoUnitario','html5' => true, 'scale' => 2, 'attr' => ['min' => '0','max'=>'999999999', 'step'=>'1']])
        //->add('venta')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => DetalleVenta::class,
        ]);
    }

}
