<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RarCustomerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('salutation', ChoiceType::class, [
                    'choices'  => array(
                        'Mrs' => 2,
                        'Miss' => 3,
                        'Mr' => 1,
                    ), 
                    'label' => 'Salutation'
                ]
            )
            ->add('firstName', TextType::class, [
                'label' => 'First name'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last name'
            ])
            ->add('address', TextType::class, [
                'required'   => false, 
                'label' => 'Postal Address',
            ])
            ->add('postCode', TextType::class, [
                'required'   => false, 
                'label' => 'Post Code',
            ])
            ->add('city', TextType::class, [
                'required'   => false, 
                'label' => 'City',
            ])
            ->add('state', TextType::class, [
                'required'   => false, 
                'label' => 'State',
            ])
            ->add('country', TextType::class, [
                'required'   => false, 
                'label' => 'Country',
            ])
            ->add('phone', TextType::class, [
                'required'   => false, 
                'label' => 'Phone number',
            ])
            ->add('email', TextType::class, [
                'label' => 'Email'
            ])
            ->add('optin', CheckboxType::class, [
                'required'   => false, 
                'label' => 'Opt-In',
            ])
            ->add('locale', HiddenType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\RarCustomer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'customer';
    }


}
