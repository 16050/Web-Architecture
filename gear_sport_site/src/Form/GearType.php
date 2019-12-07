<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Sport;
use App\Entity\Gear;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    ' ' => ' ',
                    'Man' => 'Man',
                    'Woman' =>'Woman'
                ]
            ])
            ->add('description')
            ->add('image')
            ->add('link')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('sport', EntityType::class, [
                'class' => Sport::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gear::class,
            'allow_extra_fields'=>true,
            'csrf_protection'=>false
        ]);
    }
}
