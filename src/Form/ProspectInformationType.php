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
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\ProspectInformation;




class ProspectInformationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('company', TextType::class, array(
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Société',
                )
            ))

            ->add('respCivility', ChoiceType::class, array(
                'label' => 'Civilité du responsable * :',
                'choices' => array('M.' => 0, 'Mme' => 1 ),
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'attr' => array(
                    'placeholder' => 'monPlaceholder',
                )
            ))

            ->add('respName', TextType::class, array(
                'required' => false,
                'label' => 'Nom du responsable : ',
                'attr' => array(
                    'placeholder' => 'Nom du responsable',
                )
            ))

            ->add('activity', TextType::class, array(
                'required' => true,
                'attr' => array(
                    'placeholder' => "Domaine d'activité",
                )
            ))


            ->add('siret', NumberType::class, array(
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Numéro de siret',
                )
            ))

            ->add('phone', TelType::class, array(
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Téléphone',
                )
            ))

            ->add('email', EmailType::class, array(
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Adresse mail',
                )
            ))


            ->add('postalCode', NumberType::class, array(
                'required' => false,
                'attr' => array(
                    'class' => 'postalCode',
                    'name' => 'postalCode',
                    'placeholder' => 'Code postal',

                )
            ))


            ->add('locality', TextType::class, array(
                'required' => false,
                'attr' => array(
                    'class' => 'locality',
                    'name' => 'locality',
                    'placeholder' => 'Ville',

                )
            ))


            ->add('save2', SubmitType::class, ['attr' => ['class' => 'btn btn btn-info buttonValid btnSave']]);

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProspectInformation::class,
        ));
    }
}