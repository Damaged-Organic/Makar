<?php
// src/AppBundle/Admin/BookAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Datagrid\ListMapper,
    Sonata\AdminBundle\Datagrid\DatagridMapper,
    Sonata\AdminBundle\Form\FormMapper;

class BookAdmin extends Admin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', NULL, [
                'label' => "Название книги"
            ])
            ->add('year', NULL, [
                'label' => "Год"
            ])
            ->add('pagesNumber', NULL, [
                'label' => "Количество страниц"
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        if( $book = $this->getSubject() )
        {
            $imageRequired = ( $book->getCoverName() ) ? FALSE : TRUE;

            $imageHelpOption = ( $imagePath = $book->getCoverPath() )
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
            ->add('pagesNumber', 'number', [
                'label'    => "Количество страниц"
            ])
            ->add('description', 'sonata_formatter_type', [
                'label'                => "Описание",
                'required'             => FALSE,
                'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field'         => 'contentFormatter',
                'source_field'         => 'rawContent',
                'ckeditor_context'     => 'book_config',
                'source_field_options' => [
                    'attr' => [
                        'class' => 'span10', 'rows' => 10
                    ]
                ],
                'listener'             => TRUE,
                'target_field'         => 'description'
            ])
            ->add('buyLink', 'text', [
                'label' => "Ссылка на страницу покупки книги"
            ])
            ->add('coverFile', 'vich_file', [
                'label'         => "Обложка книги",
                'required'      => $imageRequired,
                'allow_delete'  => FALSE,
                'download_link' => TRUE,
                'help'          => $imageHelpOption
            ])
            ->end()
            ->with('Локализации')
                ->add('translations', 'a2lix_translations_gedmo', [
                    'label' => "Управление локализациями",
                    'translatable_class' => 'AppBundle\Entity\Book',
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
                                    'config_name' => 'book_config'
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
