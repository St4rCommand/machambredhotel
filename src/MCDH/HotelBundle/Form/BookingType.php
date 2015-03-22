<?php

namespace MCDH\HotelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$year = (new \DateTime())->format('y');
    	
        $builder
            ->add('beginDate',	'date', 		array('years' => range($year,$year+2)))
            ->add('endDate',	'date')
            ->add('people',		'integer')
            ->add('breakfast',	'checkbox',		array('required'  => false))
            ->add('save',      	'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MCDH\HotelBundle\Entity\Booking'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mcdh_hotelbundle_booking';
    }
}
