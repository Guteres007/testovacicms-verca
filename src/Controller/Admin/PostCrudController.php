<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name', 'Nadpis');
        $description = TextEditorField::new('description', 'Popis');

         if (Action::NEW == $pageName || Action::EDIT === $pageName) {
            return [$name, $description,
                TextareaField::new('image')->setFormType(PostImageType::class)
             ];
         }

        return [
            $name,
            $description,
            ImageField::new('image')->setBasePath('uploads/images')
            ->onlyOnIndex()
        ];

    }

}
