<?php

namespace App\Service;


use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $rs;
    private $repo;

    public function __construct(RequestStack $rs, ProduitRepository $repo)

    {
        //hors d'un controller, nous devons faire les injections de dependances dans un construction

        $this->rs = $rs;
        $this->repo = $repo;
        
    }

    public function add($id)
    {
        $session = $this->rs->getSession();

        $cart = $session->get('cart', []);
        // je récupére l'attribut de session 'cart' s'il existe ou un tableau vide
        // si le produit existe deja dans mon panie, j'incremente sa quantité

         if (!empty($cart[$id]))
          {
            $cart[$id]++;
         }
         else
         {
             $cart[$id] = 1;
        // dans mon tableau $cart, a la case $id(qui correspond a l'id d'un produit), je donne la valeur 1
         }
        $session->set('cart', $cart);
    }
    public function remove($id)
    {
        $session = $this->rs->getSession();
        $cart = $session->get('cart', []);

        // si le produit exist deja dans mon panier, je le supprime du tableau $cart via unset()
        if(!empty($cart[$id]))
        {
            unset($cart[$id]);
        }
        $session->set('cart', $cart);
    }
    public function decrement($id)
    {
        $session =$this->rs->getSession();
        $cart = $session->get('cart',[]);

        if (!empty($cart[$id]))
         {
            if ($cart[$id] > 1)
             {
                $cart[$id]--;
                
            }
            else
            {
                unset($cart[$id]);

            }
        }
        $session->set('cart', $cart);
    }

    public function empty()
        {
            $session = $this->rs->getSession();
        $session->set('cart',[]);

        
        }
    public function getCartWithData()
        {
            $session = $this->rs->getSession();
        $cart = $session->get('cart', []);
        $totalQuantity = 0;
        //$totalQuantity va contenir le nombre total de pdt de mon panier

        // je vais cree un nouveau tableau qui contiendra des objects product et les quantités de chaque objet
        $cartWithData = [];
        // $cartWithData[] est un tableau multidimentionnel: pour chaque id qui se trouve dans le panier, nous allons cree
        //un nouveau tableau dans $cartWithData[] qui contiendra 2 cases : product et quantity

        foreach($cart as $id => $quantity)
        {
            $cartWithData[] = [
                'produit'=>$this->repo->find($id),
                'quantity'=> $quantity

            ];
            //cette syntaxe signifie : je cree une nouvelle case dans $cartWithData
            $totalQuantity += $quantity;

        }

        $session->set('totalQuantity', $totalQuantity);
        // je cree l'attr de session 'totalQuantity' ayantble valeur de $totalQuantity
        return $cartWithData;
        
        }
        public function getTotal()
{
    $total = 0; //j'initialise mon total 
    $cartWithData = $this->getCartWithData();// je récupère $cartWithdata via mlaméthode du service getCartWithData

    // pour chaque produit dans mon panier , je récupère le total par produit puis je l'ajoute au total final
   
   
    foreach ($cartWithData as $item) {
        $totalItem = $item['produit']->getPrix() * $item['quantity'];
        $total += $totalItem;

        //équivalent à $total = $total + $totalItem

    }
    return $total;
}


}


