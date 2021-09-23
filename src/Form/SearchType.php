<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keyword', TextType::class, array(
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Recherche par mot-clés',
                    'class' => 'select2',
                    'data-clearable' => true
                )
            ))
        ;
    }
}