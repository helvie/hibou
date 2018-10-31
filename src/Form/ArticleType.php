<?php
/**
 * Created by PhpStorm.
 * User: banan
 * Date: 23/04/2018
 * Time: 22:34
 */

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;




class ArticleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('title', TextType::class, array(
                'required' => true,
            ))

            ->add('author', TextType::class, array(
                'required' => true,
            ))

            ->add('date', HiddenType::class, array(
                'required' => true,
            ))

            ->add('updateDate', HiddenType::class, array(
                'required' => true,
            ))

            ->add('categories', EntityType::class, array(
                'expanded' => true,
                'multiple' => true,
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function(EntityRepository $repo) use ($options) {

                    return $repo->createQueryBuilder('cat');
                }
            ))

            ->add('text', TextareaType::class, array(
                'required' => true,
            ))

            ->add('visible', CheckboxType::class, array(
                'required' => true,
            ))

            ->add('valid', HiddenType::class, array(
                'required' => true,
            ))

            ->add('submit', SubmitType::class)

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Article::class,
        ));
    }
}