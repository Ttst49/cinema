<?php

namespace App\Form;

use App\Entity\Director;
use App\Entity\Movie;
use App\Entity\MovieCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('releaseDate')
            ->add('synopsis')
            ->add('rating')
            ->add('duration')
            ->add('title')
            /**->add('casting')**/
            /**->add('category',CollectionType::class,[
                "entry_type"=>MovieCategory::class,
                "allow_add"=>true,
                "allow_delete"=>true,
                "prototype_data"=>"name"
            ])**/

            ->add("director",EntityType::class,[
                "class"=>Director::class,
                "choice_label"=>"name",
            ])
            ->add("isNew")
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
