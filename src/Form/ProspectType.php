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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\Prospect;




class ProspectType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('name', TextType::class, array(
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Nom et prénom, ou société',
                )
            ))

            ->add('email', EmailType::class, array(
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Email',
                )            ))

            ->add('quoteRequest', HiddenType::class, array(
                'required' => false,
            ))

            ->add('newsletterRequest', HiddenType::class, array(
                'required' => false,
            ))

            ->add('informationsRequest', HiddenType::class, array(
                'required' => false,
            ))

            ->add('archived', HiddenType::class, array(
                'required' => false,
            ))

            ->add('lastAction', HiddenType::class, array(
                'required' => false,
            ))

            ->add('lastActionDate', HiddenType::class, array(
                'required' => false,
            ))

            ->add('nextAction', HiddenType::class, array(
                'required' => false,
            ))


            ->add('nextActionDate', HiddenType::class, array(
                'required' => false,
            ))

            ->add('applicant', HiddenType::class, array(
                'required' => false,
            ))

            ->add('information', HiddenType::class, array(
                'required' => false,
            ))

            ->add('save', SubmitType::class, ['attr' => ['class' => 'btn btn btn-info buttonValid btnSave']]);

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Prospect::class,
        ));
    }
}