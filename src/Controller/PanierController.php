<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\DetailFormType;
use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    private $PlatRepo;

    public function __construct(PlatRepository $PlatRepo)
    {
        $this->PlatRepo = $PlatRepo;
    }

    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session, PlatRepository $PlatRepo)
    {
        $panier = $session->get('panier', []);

        $data = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $plat = $PlatRepo->find($id);

            $data[] = [
                'plat' => $plat,
                'quantite' => $quantite
            ];
            $total += $plat->getPrix() * $quantite;
        }

        return $this->render('panier/detail.html.twig', [
            'controller_name' => 'PanierController',
            'search' => '',
            'data' => $data,
            'total' => $total,
        ]);
    }

    #[Route('/panier/detail/{id}', name: 'app_panier2')]
    public function detail(Plat $plat): Response
    {
        $form = $this->createForm(DetailFormType::class);
        $id = $plat->getID();
        $categorie = $this->PlatRepo->getSomePlats($id);
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'search' => '',
            'plat' => $categorie,
            'form' => $form
        ]);
    }

    #[Route('/panier/add/{id}', name: 'app_addpanier')]
    public function add(Plat $plat, SessionInterface $session)
    {
        $id = $plat->getId();

        $panier = $session->get('panier', []);
        if (empty($panier[$id])) {
            $panier[$id] = 1;
        } else {
            $panier[$id]++;
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/sup/{id}', name: 'app_suppanier')]
    public function sup(Plat $plat, SessionInterface $session)
    {
        $id = $plat->getId();

        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/sup/{id}', name: 'app_delpanier')]
    public function del(Plat $plat, SessionInterface $session)
    {
        $id = $plat->getId();

        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            if ($panier[$id]) {
                unset($panier[$id]);
            }
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/clear', name: 'app_clearpanier')]
    public function clear(SessionInterface $session)
    {
        $session->remove('panier');

        return $this->redirectToRoute('app_accueil');
    }
}
