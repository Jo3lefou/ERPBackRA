<?php
namespace AppBundle\Form;

use AppBundle\Entity\RarMatter;
use AppBundle\Entity\RarMatterProvider;
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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class MatterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('sku', TextType::class)
            ->add('color', TextType::class)
            ->add('minShip', TextType::class)
            ->add('maxShip', TextType::class)
            ->add('composition', TextareaType::class)
            ->add('width', TextType::class)
            ->add('comment', TextareaType::class)
            ->add('matterprovider', entityType::class,
                       array(
                             'class'=>'AppBundle:RarMatterProvider',
                             'choice_label' => 'name',
                            )
                      )
            ->add('isActive', CheckboxType::class,
                array(
                    'required' => false,
                    )
                )
            ->add('save', SubmitType::class)
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RarMatter::class,
        ));

    }
}