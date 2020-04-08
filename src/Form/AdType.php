<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    /**
     * Permet d'avoir le config de base d'un champ
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    private function getConfiguration($label,$placeholder){

        return[
                'label'=>$label,
                'attr'=>[
                    'placeholder'=>$placeholder
                ]
            ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,
                $this->getConfiguration("Titre","Titre de votre annonce"))

            ->add('slug',TextType::class,
                $this->getConfiguration("Chaine Url",
                    "Adresse web (automatique)"))

            ->add('coverImage',UrlType::class,
                $this->getConfiguration("Image principale",
                    "Adresse de l'image principale"))

            ->add('introduction',TextType::class,
                $this->getConfiguration("Introduction",
                    "Faites une description de votre bien"))

            ->add('content',TextareaType::class,
                $this->getConfiguration("Contenu",
                    "Décrivez votre bien dans les moindre détails"))

            ->add('rooms',IntegerType::class,
                $this->getConfiguration("Nombre de pièces",
                    "Nombre de pièces disponible"))

            ->add('price',MoneyType::class,
                $this->getConfiguration("Prix/nuit","Prix par nuit"))

            ->add('images',
                CollectionType::class,
                [
                    'entry_type'=>ImageType::class
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
