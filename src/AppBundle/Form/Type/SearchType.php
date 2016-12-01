<?php
// src/AppBundle/Form/Type/SearchType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("searchString", 'text', [
                'label'    => NULL,
                'required' => FALSE
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'AppBundle\Model\Search',
            'translation_domain' => 'forms'
        ]);
    }

    public function getName()
    {
        return "searchType";
    }
}
