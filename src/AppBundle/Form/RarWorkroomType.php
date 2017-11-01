<?php

namespace AppBundle\Form;

use AppBundle\Entity\RarWorkroom;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RarWorkroomType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required'   => false,
                'label' => 'Workroom Name',
            ])
            ->add('address', TextType::class, [
                'required'   => false,
                'label' => 'Address',
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
            ->add('email', TextType::class, [
                'required'   => false,
                'label' => 'Email',
            ])
            ->add('phone', TextType::class, [
                'required'   => false,
                'label' => 'Phone',
            ])
            ->add('isActive', CheckboxType::class, [
                'required'   => false,
                'label' => 'Is active ?',
            ])
            ->add('users', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:User',
                'choice_label' => 'username',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ))
            ->add('save', SubmitType::class)
            ->getForm();
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\RarWorkroom'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'workroom';
    }


}
