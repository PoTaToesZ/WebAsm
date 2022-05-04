<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
                    'maxlength' => 30,
                ]
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Student Age',
                'required' => true,
                'attr' => [
                    'min' => 1,
                    'max' => 30,
                ]
            ])
            ->add('dob', DateType::class, [
                'label' => 'Student Date of Birth',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('email', TextType::class, [
                'label' => 'Student Email',
                'required' => true,
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 40,
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
            ->add('subjects', EntityType::class, [
                'label' => 'Student Subjects',
                'required' => true,
                'class' => Subject::class,
                'choice_label' => 'name',
                'multiple' => true,
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
