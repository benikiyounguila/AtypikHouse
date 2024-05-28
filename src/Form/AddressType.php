<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function __construct(private FormListenerFactory $Listenerfactory) {
    
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rue', TextType::class,[
                'empty_data' => ''
            ])

            ->add('code_postal', TextType::class,[
                'empty_data' => ''
            ])

            ->add('ville', TextType::class,[
                'empty_data' => ''
            ])

            ->add('pays', TextType::class,[
                'empty_data' => ''
            ])

           
            ->add('slug', TextType::class,[
                'required'=>false,
                'empty_data' => ''
            ])

            ->add('save', SubmitType::class,[
                'label' => 'Enregistrer'
            ])
            // ->add('createdAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->addEventListener(FormEvents::PRE_SUBMIT, $this->Listenerfactory->autoSlug('ville'))
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->Listenerfactory->Slug('rue,code_postal,ville,pays'))
            ->addEventListener(FormEvents::POST_SUBMIT, $this->Listenerfactory->timestamps())
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
