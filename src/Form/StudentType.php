<?php

namespace App\Form;

use App\Entity\Major;
use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Student Name',
            'required' => true,
            'attr' => [
                'minlength' => 5,
                'maxlength' => 50,
            ]
        ])
        ->add('age', IntegerType::class, [
            'label' => 'Student Age',
            'required' => true,
            'attr' => [
                'min' => 18,
                'max' => 30,
            ]
        ])
        ->add('dob', DateType::class, [
            'label' => 'Student Date of Birth',
            'required' => true,
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
        ])
        ->add('email', EmailType::class, [
            'label' => 'Student Email',
            'required' => true,
            'attr' => [
                'minlength' => 5,
                'maxlength' => 50,
            ]
        ])
        ->add('address', TextType::class, [
            'label' => 'Student Address',
            'required' => true,
            'attr' => [
                'minlength' => 5,
                'maxlength' => 50,
            ]
        ])
        ->add('image', TextType::class, [
            'label' => 'Student Image',
            'required' => true,
        ])
        ->add('major', EntityType::class, [
            'label' => 'Major Name',
            'required' => true,
            'class' => Major::class,
            'choice_label' => 'name',
            'multiple' => false,
            'expanded' => false,
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
