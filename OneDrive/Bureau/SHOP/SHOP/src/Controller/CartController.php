<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cs): Response

    {
        $cartWithData = $cs->getCartWithData();
        $total = $cs->getTotal();


        return $this->render('cart/index.html.twig', [
            'items' => $cartWithData,
            'total' => $total
        ]);
    }
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cs)
    {
        $cs->add($id);
        return $this->redirectToRoute('app_cart');

    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cs)
    {
        $cs->remove($id);
        return $this->redirectToRoute('app_cart');

    }

    /**
     * @Route("/cart/decrement/{id}", name = "cart_decrement")
     */


     public function decrement($id, CartService $cs)
     {
        $cs->decrement($id);    
        return $this->redirectToRoute('app_cart');
     }

     /**
      * @Route("/cart/empty", name="cart_empty")
      */
      public function empty(CartService $cs)
      {
        
        $cs->empty();
        return $this->redirectToRoute('app_cart');
      }
      
}
