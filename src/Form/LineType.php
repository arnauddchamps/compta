<?php

namespace App\Form;

use App\Entity\Line;
use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\DateTransformer;
use Symfony\Component\Form\FormBuilderInterface;
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
