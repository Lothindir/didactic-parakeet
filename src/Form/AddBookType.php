<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('ReleaseDate', DateType::class, [
                'label' => 'Date de parution',
                'years' => range(date('Y')-250, date('Y'))
            ])
            ->add('CoverImage', FileType::class, [
                'label' => 'Image de couverture'
            ])
            ->add('Category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégorie',
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
