<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\ImageType;

class AdType extends AbstractType
{
    /**
     * Permet de personnaliser un champ d'un formulaire
     *
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    private function getFormConfiguration($label, $placeholder, $options = []) 
    {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title', TextType::class, $this->getFormConfiguration('Titre', 'Titre de l\'annonce')
                )
            ->add('slug', TextType::class, $this->getFormConfiguration('Url', 'Nom de l\'url automatique', [
                'required' => false
            ])
            )
            ->add(
                'coverImage', UrlType::class, $this->getFormConfiguration('Url de l\'image principale', 'Donnez l\'adresse de l\'image qui donne envie')
                )
            ->add(
                'introduction', TextType::class, $this->getFormConfiguration('Introduction', 'Introduction de votre annonce')
                )
            ->add(
                'content', TextareaType::class, $this->getFormConfiguration('Contenu', 'Donner une description qui donne vraiment envie de venir')
                )
            ->add(
                'price', MoneyType::class, $this->getFormConfiguration('Prix', 'Prix par nuit par personne')
                )
            ->add(
                'rooms', IntegerType::class, $this->getFormConfiguration('Nombre de chambre', 'Nombre de chambre que vous mettez à disposition')
                )
            ->add(
                'images', 
                CollectionType::class, [                //sous-formulaire pouvant se répéter à la demande
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            )
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
