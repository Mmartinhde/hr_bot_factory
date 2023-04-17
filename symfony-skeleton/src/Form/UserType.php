<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nombre',
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'Apellidos'
            ))
            ->add('town', TextType::class, array(
                'label' => 'Población'
            ))
            ->add('category', ChoiceType::class, array(
                'label' => 'Categoría',
                'choices' => array(
                    'X' => 'X',
                    'Y' => 'Y',
                    'Z' => 'Z'
                )
            ))
            ->add('age', NumberType::class, array(
                'label' => 'Edad'
            ))
            ->add('active', ChoiceType::class, array(
                'label' => 'Activo',
                'choices' => array(
                    'Sí' => '1',
                    'No' => '0'
                )
            ))
            ->add('Guardar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
