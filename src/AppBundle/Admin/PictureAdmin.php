<?php
// src/AppBundle/Admin/PictureAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Datagrid\ListMapper,
    Sonata\AdminBundle\Datagrid\DatagridMapper,
    Sonata\AdminBundle\Form\FormMapper;

class PictureAdmin extends Admin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', NULL, [
                'label' => "Название картины"
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        if( $picture = $this->getSubject() )
        {
            $imageRequired = ( $picture->getPictureName() ) ? FALSE : TRUE;

            $imageHelpOption = ( $imagePath = $picture->getPicturePath() )
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
                'label'    => "Год",
                'required' => FALSE
            ])
            ->add('pictureFile', 'vich_file', [
                'label'         => "Картина",
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
                        ]
                    ]
                ])
        ;
    }
}