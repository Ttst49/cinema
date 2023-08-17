<?php

namespace App\Controller\Admin;

use App\Entity\Theater;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TheaterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Theater::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
