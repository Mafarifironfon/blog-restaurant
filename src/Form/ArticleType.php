<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Keyword;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Titre'
                )
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'placeholder' => 'Description',
                    'class' => 'summernote',
                )
            ))
            ->add('author', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Auteur'
                )
            ))
            ->add('creationDate', DateTimeType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'datepicker',
                    'placeholder' => 'Crée le'
                )
            ))
            ->add('image', FileType::class, [
                'required' => false,
                'attr' => array(
                    'class' => 'custom-file-input',
                    'placeholder' => 'Image',
                    'data-browse' => 'Parcourir'
                ),
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Merci de choisir une image en JPG/JPEG ou PNG',
                    ])
                ],
            ])
            ->add('category', EntityType::class, array(
                'required' => false,
                'class' => Category::class,
                'attr' => array(
                    'placeholder' => 'Catégories',
                    'class' => 'select2',
                ),
            ))
            ->add('keywords', EntityType::class, array(
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'class' => Keyword::class,
                'attr' => array(
                    'placeholder' => 'Mots-clés',
                    'class' => 'select2'
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}