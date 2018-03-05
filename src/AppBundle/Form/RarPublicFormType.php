<?php
namespace AppBundle\Form;

use AppBundle\Entity\RarPublicForm;
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
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RarPublicFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q1', TextType::class)
            ->add('q2', TextType::class)
            //->add('q3', TextType::class) CheckBox Dresses (return serialized list.)
            ->add('q4', ChoiceType::class, [
                'choices' => array(
                        'Yes' => 1,
                        'No' => 0
                    ),
                'expanded' => true,
                'multiple' => false
                ])
            ->add('q5', ChoiceType::class, [
                'choices' => array(
                        'Yes' => 1,
                        'No' => 0
                    ),
                'expanded' => true,
                'multiple' => false,
                'required'   => false,
                ])
            ->add('q6', ChoiceType::class, [
                'choices' => array(
                        'Yes' => 1,
                        'No' => 0
                    ),
                'expanded' => true,
                'multiple' => false
                ])
            ->add('q7', TextType::class, [
                'required'   => false,
                ])
            ->add('q8', ChoiceType::class, [
                'choices' => array(
                        'Yes' => 1,
                        'No' => 0
                    ),
                'expanded' => true,
                'multiple' => false
                ])
            ->add('q9', TextType::class, [
                'required'   => false,
                ])
            ->add('q10', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RarPublicForm::class,
        ));

    }
}