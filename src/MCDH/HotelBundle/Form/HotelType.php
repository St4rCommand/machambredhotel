<?php

namespace MCDH\HotelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HotelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',		'text')
            ->add('address',	'text')
            ->add('postcode',	'text')
            ->add('city',		'text')
            ->add('country',	'text')
            ->add('save',      	'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MCDH\HotelBundle\Entity\Hotel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mcdh_hotelbundle_hotel';
    }
}