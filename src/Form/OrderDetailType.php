<?php

namespace App\Form;

use App\Document\OrderDetail;
use App\Document\Product;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class OrderDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', DocumentType::class, [
                'class' => Product::class,
                'constraints' => [
                    new NotNull(message: 'Product is required')
                ]
            ])
            ->add('quantity', IntegerType::class, [
                'constraints' => [
                    new Positive(message: 'Quantity should be more than 0')
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => OrderDetail::class
        ]);
    }
}
