<?php
// src/AppBundle/Admin/AlbumAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Datagrid\ListMapper,
    Sonata\AdminBundle\Datagrid\DatagridMapper,
    Sonata\AdminBundle\Form\FormMapper;

class AlbumAdmin extends Admin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', NULL, [
                'label' => "Название альбома"
            ])
            ->add('year', NULL, [
                'label' => "Год"
            ])
            ->add('songsNumber', NULL, [
                'label' => "Количество песен"
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        if( $album = $this->getSubject() )
        {
            $imageRequired = ( $album->getCoverName() ) ? FALSE : TRUE;

            $imageHelpOption = ( $imagePath = $album->getCoverPath() )
                ? '<img src="'.$imagePath.'" class="admin-preview" />'
                : FALSE;
        } else {
            $imageRequired   = TRUE;
            $imageHelpOption = FALSE;
        }

        $formMapper
            ->add('title', 'text', [
                'label' => 'Название'
            ])
            ->add('year', 'number', [
                'label'  => "Год"
            ])
            ->add('songsNumber', 'number', [
                'label'    => "Количество песен"
            ])
            ->add('coverFile', 'vich_file', [
                'label'         => "Обложка альбома",
                'required'      => $imageRequired,
                'allow_delete'  => FALSE,
                'download_link' => FALSE,
                'help'          => $imageHelpOption
            ])
            ->add('buyLink', 'text', [
                'label'    => "Ссылка на страницу покупки альбома",
                'required' => FALSE,
            ])
            ->add('description', 'sonata_formatter_type', [
                'label'                => "Описание",
                'required'             => FALSE,
                'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field'         => 'contentFormatter',
                'source_field'         => 'rawContent',
                'ckeditor_context'     => 'album_config',
                'source_field_options' => [
                    'attr' => [
                        'class' => 'span10', 'rows' => 10
                    ]
                ],
                'listener'             => TRUE,
                'target_field'         => 'description'
            ])
            ->end()
            ->with('Песни в альбоме')
                ->add('albumSongs', 'sonata_type_collection', [
                    'label'        => "Управление песнями",
                    'by_reference' => FALSE,
                    'required'     => FALSE,
                    'btn_add'      => 'Добавить песню'
                ], [
                    'edit'   => 'inline',
                    'inline' => 'table'
                ])
            ->end()
            ->with('Локализации')
                ->add('translations', 'a2lix_translations_gedmo', [
                    'label' => "Управление локализациями",
                    'translatable_class' => 'AppBundle\Entity\Album',
                    //TODO: For now. Make it TRUE after.
                    'required' => FALSE,
                    'fields' => [
                        'title' => [
                            'locale_options' => [
                                'en' => [
                                    'label' => 'Title'
                                ]
                            ]
                        ],
                        'description' => [
                            'locale_options' => [
                                'en' => [
                                    'label'       => 'Description',
                                    'field_type'  => 'ckeditor',
                                    'config_name' => 'album_config'
                                ]
                            ],
                            'required' => FALSE
                        ],
                        'slug' => [
                            'display' => FALSE
                        ]
                    ]
                ])
            ;
    }
}
