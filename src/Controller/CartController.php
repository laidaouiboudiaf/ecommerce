<?php

namespace App\Controller;


use App\Repository\ProductRepository;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        $panier = $session->get('panier', []);
        $panierData=[];
        foreach ($panier as $id => $quantity) {





            $panierData[] = [

                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        // dd($panierData);

        return $this->render('cart/index.html.twig', [
            'items' => $panierData

        ]);
    }

    /**
     * @Route("/panier/add/{id}" ,name="cart_add")
     */

    public function add($id, HttpFoundation\Session\SessionInterface $session)
    {
        /*        $session = $request->getSession();*/
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }


        $session->set('panier', $panier);


        return $this->redirectToRoute("cart_index");
    }
    /**
     * @Route("/panier/remove/{id}" ,name="cart_remove")
     */
    public function remove($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

     if (!empty($panier[$id]) && $panier[$id]>1)
        
        {
            $panier[$id]--;}
            
        else if ( $panier[$id]<=1)
        
        {
         
            unset($panier[$id]);
        
        }
    
        
    
        $session->set('panier', $panier);


        return $this->redirectToRoute("cart_index");
    }
}
