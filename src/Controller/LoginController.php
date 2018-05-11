<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Members;
use App\Form\LoginType;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function index(Request $request)
    {
        $member = new Members();

        $form = $this->createForm(LoginType::class, $member);
        $form->handleRequest($request);
   
        $em =$this->getDoctrine()->getManager();
        $pseudo = $em->createQuery(
            'SELECT a.pseudo FROM App:Members a'
        );

        if($form->isSubmitted() && $form->isValid()){
            if($pseudo){

                
                return new Response('Bienvenu dans la communauté Gaia, votre profil a bien été inscrit');
            
            } elseif(!$pseudo){
               
                throw $this->createNotFoundException("L'utilisateur existe déjà !");
            } 
        }
            
            
       

        $formView = $form->createView();
        
        return $this->render('login/Login.html.twig', array('form'=>$formView));
  
    }
}
