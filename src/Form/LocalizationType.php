<?php

namespace App\Form;
use App\Entity\Localization;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalizationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', CityAutocompleteField::class, [
                'label' => 'Ville',
                'placeholder' => 'Entrez une ville ou un code postal',
                'required' => true
            ])
            ->add('radius')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Localization::class,
        ]);
    }
}
