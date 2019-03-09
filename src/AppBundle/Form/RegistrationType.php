<?php
 
// src/AppBundle/Form/RegistrationType.php
 
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
 
class RegistrationType extends AbstractType
 
{
   public function buildForm(FormBuilderInterface $builder, array $options)
 
   {
       $builder->add('first_name');
       $builder->add('last_name');
       $builder->add('address');
       $builder->add('userinfo', "AppBundle\Form\UserInfoType", array('data_class' => 'AppBundle\Entity\UserInfo'));
       /*$builder->add('skills', CollectionType::class, [
            'entry_type' => UserskillType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'prototype'     => true,
            ]);*/
       //$builder->add('skills', UserskillType::class, array('data_class' => 'AppBundle\Entity\Userskill'));
   }
 
   public function getParent()
 
   {
       return 'FOS\UserBundle\Form\Type\RegistrationFormType';
   }
 
   public function getBlockPrefix()
 
   {
       return 'app_user_registration';
   }
 
   public function getName()
 
   {
       return $this->getBlockPrefix();
   }
 
}