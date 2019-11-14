<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', TextType::class, [
                'label' => 'Titre du livre',
            ])
            ->add('ExtractLink', UrlType::class, [
                'label' => 'Lien de l\'extrait'
            ])
            ->add('Summary', TextareaType::class, [
                'label' => 'Résumé'
            ])
            ->add('AuthorLastName', TextType::class, [
                'label' => 'Nom de l\'auteur'
            ])
            ->add('AuthorFirstName', TextType::class, [
                'label' => 'Prénom de l\'auteur'
            ])
            ->add('Editor', TextType::class, [
                'label' => 'Editeur'
            ])
            ->add('NumberPages', IntegerType::class, [
                'label' => 'Nombre de pages'
            ])
            ->add('ReleaseDate')
            ->add('CoverImage')
            ->add('AddedDate')
            ->add('Category')
            ->add('User')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
