<?php

namespace AppBundle\Form;

use AppBundle\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RecipeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'required'    => false,
                    'constraints' => new NotBlank()
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'required'    => false,
                    'constraints' => new NotBlank()
                ]
            )
            ->add(
                'ingredients',
                CollectionType::class,
                [
                    'entry_type'    => EntityType::class,
                    'entry_options' => [
                        'class' => 'AppBundle:Ingredient',
                        'choice_label' => 'name'
                    ],
                    'allow_add'     => true,
                    'required'      => false,
                    'constraints'   => new NotBlank()
                ]
            )
            ->add(
                'submit',
                SubmitType::class
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Recipe::class,
        ));
    }

    public function getName()
    {
        return 'recipe_form';
    }
}
