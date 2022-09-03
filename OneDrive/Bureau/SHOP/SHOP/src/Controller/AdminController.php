<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig'); 
    }
    
      #[Route('/admin/produits', name:'admin_produits')]
      

      public function adminProduits(ProduitRepository $repo, EntityManagerInterface $manager)
      {
        //on utilise le manager pour recuperer le nom des champ de la table produit
        $champs = $manager->getClassMetadata(Produit::class)->getFieldNames();
        // dd($champs); //dd(): dump & die : afficher des info et arreter l'execution du code

        $produit = $repo->findAll();

        return $this->render("admin/admin_produits.html.twig",[
      'produits' => $produit,
      'champs' => $champs
        ]);

    }

    /**
     * @Route("/admin/produit/new",name="admin_new_produit")
     * @Route("/admin/produit/edit/{id}", name="admin_edit_produit")
     */

public function produit_form(Produit $produit = null, Request $superglobals, EntityManagerInterface $manager)
{
    if($produit == null)
    {
        $produit = new Produit;
        $produit->setDateEnregistrement(new \DateTime());

    }
    $form = $this->createForm(ProduitType::class, $produit);
    $form->handleRequest($superglobals);
    if($form->isSubmitted() && $form->isValid())
    {
        $manager->persist($produit);
        $manager->flush();
        return $this->redirectToRoute('admin_produits');
    }

    return $this->renderForm("admin/admin_form.html.twig", [
        'formProduit' => $form,
        'editMode' => $produit->getId() !== NULL
    ]);
}
/**
 * @Route ("/admin/produit/delete/{id}", name="admin_delete_produit")
 */
 public function produit_delete(EntityManagerInterface $manager, ProduitRepository $repo, $id)
    {
        $produit = $repo->find($id);
        $manager->remove($produit);


        $manager->flush();

        $this->addFlash('success', "produit a bien ete supprimé");

        return $this->redirectToRoute("admin_produits");
    }
}












   





















