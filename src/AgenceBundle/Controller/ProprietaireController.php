<?php


namespace AgenceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AgenceBundle\Entity\Proprietaire;
use Symfony\Component\HttpFoundation\Request;
use AgenceBundle\Form\ProprietaireType;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProprietaireController extends Controller {

    public function listerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $proprietaires = $em->getRepository('AgenceBundle:Proprietaire')->findAll();
        $form = $this->createForm(ProprietaireType::class);

        $message = $this->get('translator')->trans('proprietaire.liste.trouver', array(
            '%number%' => count($proprietaires)
        ));

        return $this->render('@Agence/Proprietaire/lister.html.twig', array('proprietaires'=>$proprietaires, 'number_of_proprietaire' => $message, 'formRchProprietaire' => $form->createView()));
    }

    public function editerAction(Request $request, $id=null) {
       
        $em = $this->getDoctrine()->getManager();

        if(isset($id)){
            $proprietaire = $em->find('AgenceBundle:Proprietaire', $id);
        } else {
            $proprietaire = new Proprietaire();
        }

        // On crÃ©e un formulaire basÃ© sur le format BienType et l'objet bien
        $form = $this->createForm(ProprietaireType::class, $proprietaire);

        // Si le formulaire est soumis et si les donnÃ©es sont valides
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
 

            //On enregistre notre objet acteur dans la base de donnÃ©es
            $em = $this->getDoctrine()->getManager();
            $em->persist($proprietaire);
            $em->flush();
 
            $message = $this->get('translator')->trans('proprietaire.ajouter.succes', array(
                '%nom%' => $proprietaire->getNom()." ".$proprietaire->getPrenom()
            ));
            //On prÃ©pare un message pour informer du succÃ©s dans la page destination
            $request->getSession()->getFlashBag()->add('notice', $message);
 
            //on redirige vers la liste des clubs
            return $this->redirectToRoute('agence_proprietaire_lister');
        }
 
        //on passe la mÃ©thode createView() du formulaire Ã  la vue 
        //afin qu'elle puisse afficher le formulaire toute seule
 
        return $this->render('@Agence/Proprietaire/editer.html.twig', array('form' => $form->createView()));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $proprietaire =  $em->find('AgenceBundle:Proprietaire', $id);
        return $this->render('@Agence/Proprietaire/voir.html.twig', array('proprietaire'=>$proprietaire));
    }


    public function supprimerAction($id) {
        $em = $this->getDoctrine() -> getManager();
        $proprietaire = $em->find('AgenceBundle:Proprietaire', $id);

        $message = $this->get('translator')->trans('proprietaire.supprimer.echec');
        if(!$proprietaire) { throw new NotFoundHttpException($message); }
        $em->remove($proprietaire);
        $em->flush();
        return $this->redirectToRoute('agence_proprietaire_lister');
    }

}


