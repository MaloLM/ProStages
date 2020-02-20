<?php

namespace App\Form;

use App\Entity\Stage;
use src\Entity\Formation;
use src\Form\EntrepriseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('domaine')
            ->add('description')
            ->add('email')
            //->add('entreprise')
            ->add('Entreprise',EntrepriseType::class)
            ->add('formations',EntityType::class,['class'=>Formation::class,
            'choice_label'=>'nomLong',
            'multiple'=>true,
            'expanded'=> true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
