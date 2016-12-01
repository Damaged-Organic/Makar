<?php
// src/AppBundle/Admin/BlogArticleAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Datagrid\ListMapper,
    Sonata\AdminBundle\Datagrid\DatagridMapper,
    Sonata\AdminBundle\Form\FormMapper;

class BlogArticleAdmin extends Admin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', NULL, [
                'label' => "Заголовок"
            ])
            ->add('blogTopic', 'entity', [
                'class' => 'AppBundle\Entity\BlogTopic',
                'label' => "Тема"
            ])
            ->add('date', 'date', [
                'label' => "Дата публикации"
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $attr = ( $this->getSubject()->getIsActive() == TRUE )
            ? ['checked' => 'checked']
            : [];

        $formMapper
            ->add('title', 'text', [
                'label' => 'Заголовок статьи'
            ])
            ->add('date', 'sonata_type_date_picker', [
                'label' => "Дата публикации"
            ])
            ->add('views', 'integer', [
                'label'    => "Количество просмотров",
                'required' => FALSE,
                'disabled' => TRUE
            ])
            ->add('content', 'sonata_formatter_type', [
                'label'                => "Содержание",
                'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field'         => 'contentFormatter',
                'source_field'         => 'rawContent',
                'ckeditor_context'     => 'my_config',
                'source_field_options' => [
                    'attr' => [
                        'class' => 'span10', 'rows' => 10
                    ]
                ],
                'listener'             => TRUE,
                'target_field'         => 'content'
            ])
            ->add('videoLink', 'url', [
                'label'    => "Ссылка на видео из YouTube",
                'required' => FALSE
            ])
            ->add('isActive', 'checkbox', [
                'label'    => "Показывать пользователям",
                'required' => FALSE,
                'attr'     => $attr
            ])
            ->end()
            ->with('Изображения')
                ->add('uploadedFile', 'sonata_type_collection', [
                    'label'        => "Управление изображениями",
                    'by_reference' => FALSE,
                    'btn_add'      => 'Добавить изображение'
                ], [
                    'edit'   => 'inline',
                    'inline' => 'table'
                ])
            ->end()
            ->with('Локализации')
                ->add('translations', 'a2lix_translations_gedmo', [
                    'label' => "Управление локализациями",
                    'translatable_class' => 'AppBundle\Entity\BlogArticle',
                    //TODO: For now. Make it TRUE after.
                    'required' => FALSE,
                    'fields' => [
                        'title' => [
                            'locale_options' => [
                                'en' => [
                                    'label' => 'Article title'
                                ]
                            ]
                        ],
                        'content' => [
                            'locale_options' => [
                                'en' => [
                                    'label'       => 'Content',
                                    'field_type'  => 'ckeditor',
                                    'config_name' => 'my_config'
                                ]
                            ]
                        ],
                        'slug' => [
                            'display' => FALSE
                        ]
                    ]
                ])
        ;
    }
}
