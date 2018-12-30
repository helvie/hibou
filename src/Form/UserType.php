<?php
/**
 * Created by PhpStorm.
 * User: banan
 * Date: 26/04/2018
 * Time: 20:25
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
        {

        $builder

        ->add('username', TextType::class)

        ->add('email', EmailType::class)



//        ->add('password', RepeatedType::class, array(
//            'type' => PasswordType::class,
//            'first_options' => array('label' => 'Password'),
//            'second_options' => array('label' => 'Repeat Password')))

        ->add('isActive', HiddenType::class)

//        ->add('userKey', HiddenType::class)


        ->add('save', SubmitType::class, ['attr' => ['class' => 'btn btn btn-info btnSave']])



        ->add('plainPassword', RepeatedType::class, array(
            'type' => PasswordType::class,
            'first_options'  => array('label' => 'Mot de passe'),
            'second_options' => array('label' => 'Confirmer le mot de passe')));



        }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));

    }
}

