<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


class PictureCrudController extends AbstractCrudController
{
    private $picture;

    public function __construct(PictureRepository $picture)
    {
        $this->picture = $picture;
    }

    // public function searchPictureAction(Request $request, PictureRepository $picture)
    // {
    //     $PictureSearch = new PictureSearch();
    //     $results = $picture->getRepository(Picture::class)->searchFull( $PictureSearch);
    // }
    public const PICTURE_BASE_PATH = 'upload/pictures';
    public const PICTURE_UPLOAD_DIR = 'public/upload/pictures';
    public static function getEntityFqcn(): string
    {
        return Picture::class;
    }   

    public function configureFields(string $picture): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('file_url')
                ->setBasePath(self::PICTURE_BASE_PATH)
                ->setUploadDir(self::PICTURE_UPLOAD_DIR)
                ->setSortable(false),
            TextEditorField::new('description'),
            TextField::new('type')
            // ChoiceField::new('product')
            //     ->setChoices('Interieur', 'Exterieur')
            // ChoiceField::new('type')
            //         ->allowMultipleChoices()
            //         ->autocomplete()
            //         ->setChoices([  '0' => 'Intérieur',
            //                         '1' => 'Extérieur'],
        // ),
        ];
    }


}
