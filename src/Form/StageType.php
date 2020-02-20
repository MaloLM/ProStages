<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Form\EntrepriseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;



class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,['constraints'=> new NotBlank()])
            ->add('domaine', TextType::class,['label' => "Domaine d'activité",'constraints'=> new NotBlank()])
            ->add('description', TextareaType::class,['constraints'=> new NotBlank()])
            ->add('email', EmailType::class,['constraints'=> new NotBlank()])
            ->add('entreprise',EntrepriseType::class)
            ->add('formations',EntityType::class,['class'=>Formation::class,
                                                  'choice_label'=>'nomLong',
                                                  'constraints'=> new NotBlank(),
                                                  'multiple'=>true,
                                                  'expanded'=> true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
