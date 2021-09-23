<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchCategoryType extends AbstractType
{
    private $ar;

    public function __construct(ArticleRepository $ar){
        $this->ar = $ar;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', ChoiceType::class, array(
                'label' => 'Filtrer par catégorie',
                'choices' => array_flip(Category::getNameList()),
                'required' => false,
                'attr' => array('class' => 'select2', 'data-clearable' => true),
            ));
    }
}