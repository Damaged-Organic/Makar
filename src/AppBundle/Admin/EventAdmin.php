<?php
// src/AppBundle/Admin/EventAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Datagrid\ListMapper,
    Sonata\AdminBundle\Datagrid\DatagridMapper,
    Sonata\AdminBundle\Form\FormMapper;

class EventAdmin extends Admin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('datetime', 'date', [
                'label'  => "Дата и время мероприятия",
                'format' => "Y-m-d"
            ])
            ->add('city', 'text', [
                'label' => "Город"
            ])
            ->add('title', 'text', [
                'label' => "Название мероприятия"
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $attr = ( $this->getSubject()->getIsActive() == TRUE )
            ? ['checked' => 'checked']
            : [];

        $formMapper
            ->add('datetime', 'sonata_type_datetime_picker', [
                'label'  => "Дата и время мероприятия",
                'format' => "yyyy-MM-dd HH:mm"
            ])
            ->add('title', 'text', [
                'label' => "Название мероприятия"
            ])
            ->add('city', 'text', [
                'label' => "Город"
            ])
            ->add('address', 'text', [
                'label'    => "Место проведения",
                'required' => FALSE
            ])
            ->add('link', 'text', [
                'label'    => "Ссылка на покупку билетов",
                'required' => FALSE
            ])
            ->add('isActive', 'checkbox', [
                'label'    => "Показывать пользователям",
                'required' => FALSE,
                'attr'     => $attr
            ])
            ->end()
            ->with('Локализации')
                ->add('translations', 'a2lix_translations_gedmo', [
                    'label' => "Управление локализациями",
                    'translatable_class' => 'AppBundle\Entity\Event',
                    //TODO: For now. Make it TRUE after.
                    'required' => FALSE,
                    'fields' => [
                        'title' => [
                            'locale_options' => [
                                'en' => [
                                    'label' => "Event name"
                                ]
                            ]
                        ],
                        'city' => [
                            'locale_options' => [
                                'en' => [
                                    'label' => 'City'
                                ]
                            ]
                        ],
                        'address' => [
                            'locale_options' => [
                                'en' => [
                                    'label' => 'Location'
                                ]
                            ]
                        ]
                    ]
                ])
        ;
    }
}
