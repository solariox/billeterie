<?php

namespace OC\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $today = new \DateTime();
        $halfday_attr = ($today->format('H')>14)
        ? ['checked'=> 'checked','disabled'=>'disabled','data_itsHalfday'=>'true']
        : [];
        $halfday_attr['class']='halfdayCheckbox';
 
            

        $builder
        ->add('owner', TextType::class,array(
            'label_format' => '%name%'))
        ->add('ownerBirthday', TextType::class, array(
            'label_format' => '%name%',
            'attr' => array('class' => 'datepickerBirthday', 
                            'type' => 'date')))
        ->add('bookdate', TextType::class, array(
            'label_format' => '%name%',
            'attr' => array('class' => 'datepickerBookdate', 
                            'type' => 'date',
                            'value'=>$today->format('d-m-Y'),
                            'data_today'=>$today->format('d-m-Y')
                            )))
                            
        ->add('reduced', CheckboxType::class, array(
            'attr' => array('class' => 'reduced',
                            'onchange'=>'handleChange(this)'),
            'label_format' => '%name%',
            'required' => false,))
        ->add('halfday', CheckboxType::class, array(
            'label_format' => '%name%',
            'required' => false,
            'attr'=>$halfday_attr)
            )
        ->add('country', TextType::class, array(
           'label_format' => '%name%',
            'required' => true,));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\TicketingBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_ticketingbundle_ticket';
    }


}
