<?php

namespace App\Form;

use App\Entity\Calculation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', TextType::class, [
                'attr' => [
                    'placeholder' => '0.00',
                    'class'       => 'form-control text-end'
                ],
            ])
            ->add('vatPercentage', TextType::class, [
                'attr' => [
                    'placeholder' => '0.00',
                    'class'       => 'form-control text-end'
                ],
            ])
            ->add('calculate', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mb-3'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calculation::class,
        ]);
    }
}
