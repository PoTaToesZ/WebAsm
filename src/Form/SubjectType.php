<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Subject Name',
                'required' => true,
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 30,
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Subject Description',
                'required' => true,
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 255,
                ]
            ])
            ->add('slot', IntegerType::class, [
                'label' => 'Number of Slots',
                'required' => true,
                'attr' => [
                    'min' => 1,
                    'max' => 50,
                ]
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
