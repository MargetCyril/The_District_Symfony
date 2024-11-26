<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;


use function Symfony\Component\Clock\now;

#[Route('/commande', name: 'app_commande_')]
class CommandeController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function add(SessionInterface $session, PlatRepository $platRepository, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        if ($panier === []) {
            $this->addFlash('message', 'votre panier est vide');
            return $this->redirectToRoute('app_accueil');
        }

         $order = new Commande;
        //$plouf = new DateTimeInterface();
        $order->setDateCommande(new \DateTime());
        //$order->setUtilisateur($session->get('user', []));
        $order->setUtilisateur($this->getUser()); 
        $total = 0; 
        foreach($panier as $item => $quantity) {
            $detail = new Detail();
                $plat = $platRepository->find($item);
                $prix = $plat->getPrix();
            $detail->setPlat($plat);
            $detail->setQuantite($quantity);
            $total = $prix*$quantity + $total;
        
            $em->persist($detail);
            $em->flush();
        
        $order->addDetail($detail);
        $order->setEtat("0");
        }
        $order->setTotal($total);

        $em->persist($order);
        $em->flush();
 



        

        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
}
