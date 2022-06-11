<?php

namespace ClubBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClubBundle\Entity\Club;
use Symfony\Component\HttpFoundation\Request;
use ClubBundle\Form\ClubType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ClubController extends Controller {

    public function listerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $clubs = $em->getRepository('ClubBundle:Club')->findAll();

        $message = $this->get('translator')->trans('club.liste.trouver', array(
            '%number%' => count($clubs)
        ));        
        
        return $this->render('@Club/Club/lister.html.twig', array('clubs'=>$clubs, 'number_of_club' => $message));
    }

    public function editerAction(Request $request, $id=null) {
       
        $em = $this->getDoctrine()->getManager();

        //modification d'un club existant sinon création d'un nouveau club
        if(isset($id)){
            $club = $em->find('ClubBundle:Club', $id);
        } else {
            $club = new Club();
        }

        // On crée un formulaire basé sur le format ClubType et l'objet club
         $form = $this->createForm(ClubType::class, $club);

        // Si le formulaire est soumis et si les données sont valides
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
 
            //On enregistre notre objet acteur dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
 
            $message = $this->get('translator')->trans('club.ajouter.succes', array(
                '%nom%' => $club->getNom()
            ));
            //On prépare un message pour informer du succés dans la page destination
            $request->getSession()->getFlashBag()->add('notice', $message);
 
            //on redirige vers la liste des clubs
            return $this->redirectToRoute('club_club_lister');
        }
 
        //on passe la méthode createView() du formulaire à la vue 
        //afin qu'elle puisse afficher le formulaire toute seule
 
        return $this->render('@Club/Club/editer.html.twig', array('form' => $form->createView()));
    }

    public function supprimerAction($id) {
        $em = $this->getDoctrine() -> getManager();
        $club = $em->find('ClubBundle:Club', $id);
        $message = $this->get('translator')->trans('club.ajouter.succes', array(
            '%nom%' => $club->getNom()
        ));
        if(!$club) { throw new NotFoundHttpException($message); }
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute('club_club_lister');

    }

}