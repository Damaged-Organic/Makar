<?php
// src/AppBundle/Admin/AlbumSongAdmin.php
namespace AppBundle\Admin;

use Symfony\Component\Validator\Constraints as Assert;

use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Datagrid\ListMapper,
    Sonata\AdminBundle\Datagrid\DatagridMapper,
    Sonata\AdminBundle\Form\FormMapper;

class AlbumSongAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('position', 'number', [
                'label' => "Номер в списке"
            ])
            ->add('title', 'text', [
                'label' => "Название"
            ])
            ->add('durationMinutes', 'integer', [
                'label'    => "Длительность (минут)",
                'required' => FALSE,
                'constraints' => [
                    new Assert\Range(['min' => 0, 'max' => 59]),
                ]
            ])
            ->add('durationSeconds', 'integer', [
                'label'    => "Длительность (секунд)",
                'required' => FALSE,
                'constraints' => [
                    new Assert\Range(['min' => 0, 'max' => 59]),
                ]
            ])
        ;
    }
}
