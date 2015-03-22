<?php

namespace MCDH\HotelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RoomType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',			'text')
            ->add('floor',			'integer', 	array('required' => false))
            ->add('people',			'integer')
            ->add('orientation',	'choice', 	array('choices' => array('north'=>'Nord','south'=>'Sud','east'=>'Est','west'=>'Ouest')))
            ->add('price',			'money')
            ->add('image', 			new ImageType(), 	array('required' => false))
            ->add('save',      		'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MCDH\HotelBundle\Entity\Room'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mcdh_hotelbundle_room';
    }
}
