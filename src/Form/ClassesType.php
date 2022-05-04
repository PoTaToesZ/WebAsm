<?php

namespace App\Form;

use App\Entity\Classes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClassesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Class Name',
                'required' => true,
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 50,
                ]
            ])
            ->add('start', DateType::class, [
                'label' => 'Class Start Date',
                'required' => true,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('end', DateType::class, [
                'label' => 'Class End Date',
                'required' => true,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('Save', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
