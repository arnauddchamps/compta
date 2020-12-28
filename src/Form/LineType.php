<?php

namespace App\Form;

use App\Entity\Line;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\DateTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LineType extends AbstractType
{
    private $transformer;
 
    public function __construct(DateTransformer $transformer)
    {
       $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', TextType::class,
            [
               'attr' => [
                  'placeholder' => 'DD/MM/YYYY',
                  'maxLength' => 10,
               ]
           ])
            ->add('title')
            ->add('description')
            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'title',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('code')
            ->add('amount')
            ->add('submit', SubmitType::class)
        ;
        $builder
        ->get('date')
        ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Line::class,
        ]);
    }
}
