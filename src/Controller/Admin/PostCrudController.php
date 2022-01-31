<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $url = $this->getParameter('image_path');
        return [
            TextField::new('name', 'Nadpis'),
            TextEditorField::new('description', 'Popis'),
            ImageField::new('imgPath')->onlyOnIndex(),
            ImageField::new('image')->setUploadDir('/public/'.$url)->onlyOnForms()
        ];
    }

}
