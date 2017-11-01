<?php

namespace AppBundle\Form\Bloc;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\RarModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ModelOrderedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if( $options['attr']['adminRights'] == true ){
            if( $options['attr']['type'] == 'edit' ){
              $builder
                  ->add('model', entityType::class,
                     array(
                           'class'=>'AppBundle:RarModel',
                           'choice_label' => 'name',
                           'required' => false,
                           'placeholder' => 'Choose a model',
                      )
                  )
                  ->add('size', HiddenType::class, [
                      'label' => false,
                  ])
                  ->add('heels', NumberType::class, [
                      'label' => false,
                      'empty_data' => 0,
                  ])
                  ->add('comment', TextareaType::class, [
                      'label' => false,
                  ])
                  ->add('status', choiceType::class, [
                      'label' => false,
                      'choices'  => array(
                        'To be done' => '0',
                        'In Stock' => '1',
                        'Sent to workroom' => '2',
                        'In production' => '3',
                        'Sent by fullfilment house' => '4',
                        'Received by Rime Arodaky' => '5',
                        'Received with error' => '6',
                        'Controled' => '7',
                        'Finished' => '9',
                        'Delivered' => '8',
                      )
                  ])
                  ->add('isCommentInvoice', CheckboxType::class, [
                        'required' => false,
                    ]);
            }else{
              $builder
                  ->add('model', entityType::class,
                     array(
                           'class'=>'AppBundle:RarModel',
                           'choice_label' => 'name',
                           'required' => false,
                           'placeholder' => 'Choose a model',
                      )
                  )
                  ->add('size', HiddenType::class, [
                      'label' => false,
                  ])
                  ->add('heels', NumberType::class, [
                      'label' => false,
                      'empty_data' => 0,
                  ])
                  ->add('comment', TextareaType::class, [
                      'label' => false,
                  ]);
            }
        }else{
            $builder
            ->add('model', entityType::class,
               array(
                     'class'=>'AppBundle:RarModel',
                     'choice_label' => 'name',
                     'required' => false,
                     'placeholder' => 'Choose a model',
                     'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('m')->where('m.isActive = 1');
                      }
                    )
            )
            ->add('size', HiddenType::class, [
                'label' => false,
            ])
            ->add('heels', NumberType::class, [
                'label' => false,
                'empty_data' => 0,
            ])
            ->add('comment', TextareaType::class, [
                'label' => false,
            ])
        ;
        }
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\RarModelOrdered',
            'translation_domain' => 'messages'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'ModelOrderedType';
    }
}