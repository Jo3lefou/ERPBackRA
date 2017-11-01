<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\RarModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MatterAttributedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matter', entityType::class,
               array(
                     'class'=>'AppBundle:RarMatter',
                     'choice_label' => 'name',
                     'required' => false,
                     'placeholder' => 'Choose a matter',
                )
            )
            ->add('quantity', NumberType::class, [
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\RarMatterAttributed',
        ]);
    }

    public function getBlockPrefix()
    {
        return 'MatterAttributedType';
    }
}