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
        $builder
        ->add('owner', TextType::class,array(
            'label'    => 'Propriétaire du billet'))
        ->add('ownerBirthday', TextType::class, array(
            'label'=> 'Date d\'anniversaire',
            'attr' => array('class' => 'datepickerBirthday', 
                            'type' => 'date')))
        ->add('bookdate', TextType::class, array(
            'label'=> 'Date de réservation',
            'attr' => array('class' => 'datepickerBookdate', 
                            'type' => 'date')))
                            
        ->add('reduced', CheckboxType::class, array(
            'attr' => array('class' => 'reduced',
                            'onchange'=>'handleChange(this)'),
            'label'    => 'Tarif réduit ',
            'required' => false,))
        ->add('halfday', CheckboxType::class, array(
            'label'    => 'Demi-journée ',
            'required' => false,))
        ->add('country', TextType::class, array(
            'label'    => 'Pays',
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
