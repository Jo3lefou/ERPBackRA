<?php

namespace AppBundle\Form;

use AppBundle\Entity\RarWorkroom;
use AppBundle\Form\Bloc\SizeType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Product name',
            ])
            ->add('sku', TextType::class, [
                'label' => 'SKU Code',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Model Type',
                'choices'   => array(
                    'Ready-Made Model' => '1',
                    'Ceremony' => '2',
                    'Both' => '3',
                    'Other' => '4',
                ),
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Category',
                'choices'   => array(
                    'Dress' => array(
                        'Dress' => 'Dress',
                        'Wedding Dress' => 'Wedding Dress',
                    ),
                    'Usual' => array(
                        'Bottom' => 'Bottom',
                        'Top' => 'Top',
                        'Jumper' => 'Jumper',
                        'Kaftan' => 'Kaftan',
                        'Swimwear' => 'Swimwear',
                    ),
                    'Accessories' => array(
                        'Accessories' => 'Accessories',
                        'Home Accessories' => 'Home Accessories',
                    ) 
                ),
            ])
            ->add('collectionId', TextType::class, [
                'label' => 'ID Collection',
            ])
            ->add('prixHT', NumberType::class, [
                'label' => 'Price (no VAT)',
            ])
            ->add('prixShop', NumberType::class, [
                'label' => 'Price wholesale',
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'On sale',
                'required' => false,
            ])
            ->add('isShop', CheckboxType::class, [
                'label' => 'On sale for shops',
                'required' => false,
            ])
            ->add('isContract', CheckboxType::class, [
                'label' => 'On sale for shops under contract',
                'required' => false,
            ])
            ->add('minShipWeek', NumberType::class, [
                'label' => 'Min number of week before shipping',
            ])
            ->add('maxShipWeek', NumberType::class, [
                'label' => 'Max number of week before shipping',
            ])
            ->add('sizes', CollectionType::class, [
                'label'        => 'Manage sizes for product.',
                'entry_type'   => SizeType::class,
                'entry_options' => [
                    'attr' => [
                        'class' => 'item', // we want to use 'tr.item' as collection elements' selector
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
            ->add('matterAttributed', CollectionType::class, [
                'label'        => 'Add your matters here',
                'entry_type'   => MatterAttributedType::class,
                'entry_options' => [
                    'attr' => [
                        'class' => 'item',
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
            ->add('workroom', entityType::class,
               array(
                    'label' => 'Workroom',
                     'class'=>'AppBundle:RarWorkroom',
                     'choice_label' => 'name',
                     'required' => false,
                     'placeholder' => 'Choose a workroom',
                     'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('m')->where('m.isActive = 1');
                      }
                )
              )
            ->add('save', SubmitType::class, [
                'label' => 'Save',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\RarModel',
        ]);
    }

    public function getBlockPrefix()
    {
        return 'ModelType';
    }
}