<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', TextType::class, [
                'attr' =>
                [
                'class' => 'form-control mb-2'
                ],
                'label' => 'Titre'
            ])
            ->add('Description', TextareaType::class, [
                'attr' =>
                [
                'class' => 'form-control mb-2',
                'rows' => '8'
                ],
            ])
            ->add('image', FileType::class, [
                
                'attr' =>
                [
                'class' => 'm-2'
                ],
                'label' => 'Photo (jpeg ou PNG)',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/PNG',
                        ],
                        'mimeTypesMessage' => 'uploader une image valide',
                    ])
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' =>
                [
                    'class' => 'btn btn-primary shadow m-1'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
