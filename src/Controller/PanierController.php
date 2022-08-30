<?php

namespace App\Controller;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        
        $panier = $session->get('panier', []);
        // on fabrique les données

        $dataPanier=[];
        $total=0;

        foreach ( $panier as $id => $quantite) {
             $product = $productRepository->find($id);
             $dataPanier[] = [
                'product' => $productRepository->find($id),
                'quantite' => $quantite
            ];

            $total += $product->getPrix()* $quantite;
        }
     return $this->render('panier/index.html.twig',compact ("dataPanier","total"));
}



    #[Route('/panier/add/{id}', name :'panier_add')]
    public function add (Product $product,SessionInterface $session)
    {
        // on récupère le panier
        {
            $panier = $session->get('panier', []);
            $id=$product ->getId();


            if (!empty($panier[$id])) {
                $panier[$id]++;
            } else {
                $panier[$id] = 1;
            }
    
            $session->set('panier', $panier);
        }
        return $this->redirectToRoute('app_panier');
    }


 #[Route("/panier/remove/{id}", name:"panier_remove")]
//      */diminue la quantité
 
        public function remove(Product $product,SessionInterface $session)
        {
            $panier = $session->get('panier', []);
            $id=$product->getId();

            if (!empty($panier[$id])) {
                if($panier[$id] > 1){
                    $panier[$id]--;
                }else{
                    unset($panier[$id]);
                }
           
                $session->set('panier', $panier);
            }

            return $this->redirectToRoute('app_panier');
        }

#[Route("/panier/delete/{id}", name:"panier_delete")]
//      */supprime l'élément

public function delete(Product $product,SessionInterface $session)
{
    $panier = $session->get('panier', []);
    $id=$product->getId();

    if (!empty($panier[$id])) {
            unset($panier[$id]);
        }   

        $session->set('panier', $panier);

    return $this->redirectToRoute('app_panier');
}

}