<?php
namespace AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Entity\RarShop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('password', PasswordType::class)
            ->add('email', TextType::class)
            ->add('userColor', TextType::class)
            ->add('locale', HiddenType::class)
            ->add('city', TextType::class)
            ->add('mobile', TextType::class)
            ->add('state', TextType::class)
            ->add('country', TextType::class)
            ->add('imageFile', FileType::class, [
                'data_class' => null,
                'required'   => false, //important!
            ])
            ->add('save', SubmitType::class)
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => RarShop::class,
        ));*/

        /*$resolver->setDefaults(array(
            'data_class' => User::class,
        ));*/
    }
}