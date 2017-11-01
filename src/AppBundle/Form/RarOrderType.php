<?php

namespace AppBundle\Form;


use AppBundle\Entity\RarShop;
use AppBundle\Form\Bloc\ModelOrderedType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class RarOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // initially w/out APC
        $choices = [
            'Draft' => 0,
            'Published' => 1,
        ];
        if( $options['attr']['adminRights'] == true && $options['attr']['type'] != 'create' ) {
            $choices['Validated'] = 2;
            $choices['Error'] = 3;
            $choices['Canceled'] = 4;
            $choices['Delivered'] = 5;
            $choices['In Stock'] = 6;
        }

        
        $builder
            ->add('dateCivil', DateType::class, [
                'label' => 'Civil Wedding Date',
                'required' => false,
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+100),
            ])
            ->add('dateChurch', DateType::class,[
                'label' => 'Church Wedding Date',
                'required' => false,
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+100),
            ])
            ->add('dateMinShip', DateType::class,[
                'label' => 'Minimum date shipping',
                'required' => false,
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+100),
            ])
            ->add('dateMaxShip', DateType::class,[
                'label' => 'Maximum date shipping',
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+100),
            ])
            ->add('comment', TextareaType::class,[
                'label' => 'Comment',
                'required' => false
            ])
            ->add('state', ChoiceType::class,[
                'label' => 'Status',
                'choices'  => $choices
            ])
            ->add('modelsOrdered', CollectionType::class, [
                'label'        => 'Add your models here',
                'entry_type'   => ModelOrderedType::class,
                'entry_options' => [
                    'attr' => [
                        'class' => 'item', // we want to use 'tr.item' as collection elements' selector
                        'adminRights' => $options['attr']['adminRights'],
                        'type' => $options['attr']['type'],
                    ],
                ],
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'required'     => false,
                'by_reference' => true,
                'delete_empty' => true,
                'attr' => [
                    'class' => 'table size-collection',
                ],

            ])
            ->add('save', SubmitType::class)
            ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\RarOrder',
            'attr' => [ 'adminRights' => false, 'type' => 'create' ],
            'translation_domain' => 'messages'
        ));
    }

    public function getBlockPrefix()
    {
        return 'OrderType';
    }


}
