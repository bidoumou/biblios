<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('dateOfBirth', DateType::class, [
                'input' => 'datetime_immutable',
                'widget' => 'single_text'
            ])
            ->add('dateOfDeath', DateType::class, [
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('nationality', TextType::class, [
                'required' => false,
            ])
            ->add('books', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'title',
                'multiple' => true,
                'required' => false,
                'by_reference' => false,
            ])
            ->add('certification', CheckboxType::class, [
                'mapped' => false,          # Indique que ce champ ne correspond à aucune entité du formulaire
                'label' => "Je certifie de l'exactitude des informations fournies.",
                'constraints' => [
                    new Assert\IsTrue(message: 'Vous devez cocher la case pour ajouter un auteur.'),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
