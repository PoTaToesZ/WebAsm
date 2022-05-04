<?php

namespace App\Form;

use App\Entity\Major;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MajorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Major Name',
            'required' => true,
            'attr' => [
                'minlength' => 2,
                'maxlength' => 40,
            ]
        ])
        ->add('description', TextType::class, [
            'label' => 'Major Description',
            'required' => true,
            'attr' => [
                'minlength' => 2,
                'maxlength' => 255,
            ]
        ])
        ->add('image', TextType::class, [
            'label' => 'Major Image',
            'required' => true,
        ])
        ->add('quantity',TextType::class, [
            'label' => 'Major Quantity',
            'required' => true,
            'attr' => [
                'minlength' => 1,
                'maxlength' => 255,
            ]
        ])
        ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
