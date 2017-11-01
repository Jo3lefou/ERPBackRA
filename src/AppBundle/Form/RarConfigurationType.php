<?php

namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RarConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName', TextType::class, [
                'label' => 'Company name'
            ])
            ->add('address', TextType::class, [
                'label' => 'Customer facing address'
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Customer facing zip code'
            ])
            ->add('city', TextType::class, [
                'label' => 'Customer facing city'
            ])
            ->add('country', TextType::class, [
                'label' => 'Customer facing country'
            ])
            ->add('vATnum', TextType::class, [
                'label' => 'VAT Number'
            ])
            ->add('siretNum', TextType::class, [
                'label' => 'Siret Number'
            ])
            ->add('siegeSocialName', TextType::class, [
                'label' => 'Head office name'
            ])
            ->add('siegeSocialAddress', TextType::class, [
                'label' => 'Head office address'
            ])
            ->add('siegeSocialZipCode', TextType::class, [
                'label' => 'Head office zip code'
            ])
            ->add('siegeSocialCity', TextType::class, [
                'label' => 'Head office city'
            ])
            ->add('siegeSocialCountry', TextType::class, [
                'label' => 'Head office country'
            ])
            ->add('save', SubmitType::class)
            ->getForm();
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\RarConfiguration'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'configuration';
    }


}
