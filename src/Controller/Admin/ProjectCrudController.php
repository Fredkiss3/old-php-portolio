<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ImageField::new('cover', 'Image')
            ->onlyOnIndex()
            ->setBasePath(
                '/uploads/images/projects'
            );

        yield TextField::new('coverFile', 'Image de couverture')
            ->onlyOnForms()
            ->setFormType(VichImageType::class)
//            ->setFormTypeOption('required', true)
        ;

        yield TextField::new('title', 'Titre du projet');

        yield ChoiceField::new('type', 'Type du projet')
            ->setChoices([
                'Stage' => Project::TYPE_INTERNSHIP,
                'Personnel' => Project::TYPE_PERSONAL,
                'Client' => Project::TYPE_CLIENT,
            ]);

        yield AssociationField::new('technologies', 'Technologies')
            ->setFormTypeOption('multiple', true)
            ->setFormTypeOption('required', true)
            ->onlyOnForms()
        ;

        yield UrlField::new('link', 'Lien du projet');
        yield IntegerField::new('yearOfRealization', 'Année de réalisation');

        yield TextareaField::new('excerpt', 'Résumé')
            ->onlyOnForms();

        yield TextEditorField::new('description', 'Description')
            ->onlyOnForms();

        yield TextField::new('image2File', 'Image 2')
            ->onlyOnForms()
            ->setFormType(VichImageType::class)
        ;

        yield TextField::new('image3File', 'Image 3')
            ->onlyOnForms()
            ->setFormType(VichImageType::class)
        ;

        yield TextField::new('image4File', 'Image 4')
            ->onlyOnForms()
            ->setFormType(VichImageType::class)
        ;


    }
}
