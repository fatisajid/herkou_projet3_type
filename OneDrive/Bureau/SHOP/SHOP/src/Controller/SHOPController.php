<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SHOPController extends AbstractController
{
    #[Route('/SHOP', name: 'app_SHOP')]
    public function index(ProduitRepository $repo): Response
    {

        $produits = $repo->findAll();

        return $this->render('SHOP/index.html.twig', [
            'Produits' => $produits
        ]);

   }



// #[Route('/', name: 'home')]

// public function home(VehiculeRepository $repo) : Response
// {
//     $vehicules = $repo->findAll();
//     return $this->render('projet2/home.html.twig', [
//         'tabVehicules' => $vehicules
//     ]);
// }





}







