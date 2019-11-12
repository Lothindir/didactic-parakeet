<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title')
            ->add('ExtractLink')
            ->add('Summary')
            ->add('AuthorLastName')
            ->add('AuthorFirstName')
            ->add('Editor')
            ->add('NumberPages')
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
