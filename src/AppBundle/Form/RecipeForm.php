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
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
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
                    'constraints' => [
                        new NotBlank(['message' => 'Поле не может быть пустым']),
                        new Length(['max' => 64, 'maxMessage' => 'Значение не может быть больше 64 символов']),
                    ],
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'required'    => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Поле не может быть пустым']),
                        new Length(['max' => 255, 'maxMessage' => 'Значение не может быть больше 255 символов']),
                    ],
                ]
            )
            ->add(
                'ingredients',
                CollectionType::class,
                [
                    'entry_type'    => EntityType::class,
                    'entry_options' => [
                        'class'        => 'AppBundle:Ingredient',
                        'choice_label' => 'name',
                    ],
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'required'      => false,
                    'delete_empty'  => true,
                ]
            )
            ->add(
                'submit',
                SubmitType::class
            )
            ->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();

                    $ingredients = $form->getData()->getIngredients();

                    $existIds = [];

                    foreach ($ingredients as $ingredient) {

                        if (in_array($ingredient->getId(), $existIds)) {
                            $form->addError(new FormError('Ингредиенты не должны повторятся'));

                            return false;
                        }

                        $existIds[] = $ingredient->getId();
                    }

                    return true;
                }
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Recipe::class,
            ]
        );
    }

    public function getName()
    {
        return 'recipe_form';
    }
}
