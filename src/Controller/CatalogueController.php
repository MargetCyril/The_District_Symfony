<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatalogueController extends AbstractController
{

    private $CategorieRepo;
    private $PlatRepo;

    public function __construct(CategorieRepository $CategorieRepo, PlatRepository $PlatRepo)
    {
        $this->CategorieRepo = $CategorieRepo;
        $this->PlatRepo = $PlatRepo;
    }

    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        $titre = "Acceuil";
        $search = '<form method="post" action="search.php">;
                    <label for="recherche"></label>;
                    <input type="text" name="recherche" id="recherche" placeholder="recherche...">;
                    </form>;';
        $categorie = $this->CategorieRepo->findAll();
        $plat = $this->PlatRepo->findAll();

        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'titre' => $titre,
            'search' => $search,
            'categorie' => $categorie,
            'plat' => $plat,
        ]);
    }

 #[Route('/categories', name: 'app_categories')]
    public function categories(Request $request): Response
    {
        $titre = "Catégories";
        $search = "";

        $categorie = $this->CategorieRepo->findAll();

        return $this->render('catalogue/categorie.html.twig', [
            'controller_name' => 'CategoriesController',
            'titre' => $titre,
            'search' => $search,
            'categorie' => $categorie
        ]);
    }
    
    #[Route('/plats', name: 'app_plats')]
    public function plats(): Response
    {
        $titre = "Plats";
        $search = "";
        $plat = $this->PlatRepo->findAll();


        return $this->render('catalogue/plat.html.twig', [
            'controller_name' => 'PlatsController',
            'titre' => $titre,
            'search' => $search,
            'plat' => $plat,
        ]);
    }
 
    #[Route('/categories/plat', name: 'app_categoriesid')]
    public function categoriesid(Request $request): Response
    {
        $titre = "Plats de cette catégorie";
        $search = "";
        $param = $request->query->get('id');
    
        $categorie = $this->PlatRepo->getSomeCategories($param);

        return $this->render('catalogue/categorie.html.twig', [
            'controller_name' => 'CategoriesController',
            'titre' => $titre,
            'search' => 'ça marche',
            'categorie' => $categorie,
        ]);
    } 
}
