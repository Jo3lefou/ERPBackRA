<?php
namespace AppBundle\Form;

use AppBundle\Entity\RarShop;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('extention', TextType::class)
            ->add('address', TextType::class, [
                'required'   => false, //important!
            ])
            ->add('zipCode', TextType::class, [
                'required'   => false, //important!
            ])
            ->add('city', TextType::class)
            ->add('country', TextType::class)
            ->add('email', TextType::class)
            ->add('phone', TextType::class, [
                'required'   => false, //important!
            ])
            ->add('isDirectCustomer', CheckboxType::class, [
                'required'   => false, //important!
            ])
            ->add('isActive', CheckboxType::class, [
                'required'   => false, //important!
            ])
            ->add('isVat', CheckboxType::class, [
                'required'   => false, //important!
            ])
            ->add('amountVat', NumberType::class, [
                'required'   => false, //important!
            ])
            ->add('isContract', CheckboxType::class, [
                'required'   => false, //important!
            ])
            ->add('isEshop', CheckboxType::class, [
                'required'   => false, //important!
            ])
            ->add('amountContract', NumberType::class, [
                'required'   => false, //important!
            ])
            ->add('users', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:User',
                'choice_label' => 'username',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ))
            ->add('locale', HiddenType::class)
            ->add('vatNum', TextType::class)
            ->add('token', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RarShop::class,
        ));

    }
}