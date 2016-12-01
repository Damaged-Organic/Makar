<?php
// src/AppBundle/Admin/BlogArticleUploadedFileAdmin.php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Datagrid\ListMapper,
    Sonata\AdminBundle\Datagrid\DatagridMapper,
    Sonata\AdminBundle\Form\FormMapper;

class BlogArticleUploadedFileAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $imagePathData = ( ($blogArticleUploadedFile = $this->getSubject()) && ($imagePath = $blogArticleUploadedFile->getImagePath()) )
            ? $imagePath
            : FALSE;

        $formMapper
            ->add('imagePath', 'text', [
                'label'     => "Имя файла",
                'mapped'    => FALSE,
                'read_only' => TRUE,
                'data'      => $imagePathData
            ])
            ->add('imageFile', 'file', [
                'label'    => "Добавить файл",
                'required' => FALSE
            ])
        ;
    }
}
