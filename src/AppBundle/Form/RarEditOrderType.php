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

class RarEditOrderType extends AbstractType
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
            $choices['Controlled'] = 5;
            $choices['Delivered'] = 6;
            $choices['In Stock'] = 7;
        }

        if($options['attr']['classic'] == true){
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
                ]);
        }
        
        $builder
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
            ->add('save', SubmitType::class)
            ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\RarOrder',
            'attr' => [ 'adminRights' => false, 'type' => 'create', 'classic' => true ],
            'translation_domain' => 'messages'
        ));
    }

    public function getBlockPrefix()
    {
        return 'OrderType';
    }


}
