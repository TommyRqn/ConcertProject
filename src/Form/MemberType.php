<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Band;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du membre'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom du membre'
            ])
            ->add('job', TextType::class, [
                'label' => 'Poste du membre'
            ])
            ->add('birthdate', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd / MM / yyyy'
            ])
            ->add('picture', TextType::class, [
                'label' => 'Image du membre (ex: test.png)'
            ])
            ->add('band', EntityType::class, [
                'class' => Band::class,
                'choice_label' => 'name'
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
