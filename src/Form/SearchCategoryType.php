<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', ChoiceType::class, array(
                'label' => 'Filtrer par catégorie',
                'choices' => array_flip(Category::getNameList()),
                'required' => false,
                'attr' => array('class' => 'select2', 'data-clearable' => true),
            ));
    }
}