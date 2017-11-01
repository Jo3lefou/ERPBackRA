<?php

namespace AppBundle\Form\Bloc;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameSize', TextType::class, [
                'label' => false,
            ])
            ->add('codeSize', TextType::class, [
                'label' => false,
            ])
            ->add('supPriceHT', NumberType::class, [
                'label' => false,
            ])
            ->add('supPriceShop', NumberType::class, [
                'label' => false,
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\RarSize',
        ]);
    }

    public function getBlockPrefix()
    {
        return 'SizeType';
    }
}