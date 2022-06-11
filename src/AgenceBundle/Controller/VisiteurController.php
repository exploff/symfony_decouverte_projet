<?php

namespace AgenceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AgenceBundle\Entity\Visiteur;
use AgenceBundle\Form\VisiteurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VisiteurController extends Controller {
    
    public function listerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $visiteurs = $em->getRepository('AgenceBundle:Visiteur')->findAll();

        $message = $this->get('translator')->trans('visiteur.liste.trouver', array(
            '%number%' => count($visiteurs)
        ));

        return $this->render('@Agence/Visiteur/lister.html.twig', array('visiteurs'=>$visiteurs, 'number_of_visiteur' => $message));
    }

    public function editerAction(Request $request, $id=null) {
       
        $em = $this->getDoctrine()->getManager();

        if(isset($id)){
            $visiteur = $em->find('AgenceBundle:Visiteur', $id);
        } else {
            $visiteur = new Visiteur();
        }

        $form = $this->createForm(VisiteurType::class, $visiteur);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
 
            $em = $this->getDoctrine()->getManager();
            $em->persist($visiteur);
            $em->flush();
 
            $message = $this->get('translator')->trans('visiteur.ajouter.succes', array(
                '%prenom%' => $visiteur->getPrenom(),
                '%nom%' => $visiteur->getNom()
            ));
            $request->getSession()->getFlashBag()->add('notice', $message);
 
            return $this->redirectToRoute('agence_visiteur_lister');
        }
  
        return $this->render('@Agence/Visiteur/editer.html.twig', array('form' => $form->createView()));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $visiteur =  $em->find('AgenceBundle:Visiteur', $id);
        return $this->render('@Agence/Visiteur/voir.html.twig', array('visiteur'=>$visiteur));
    }


    public function supprimerAction($id) {
        $em = $this->getDoctrine() -> getManager();
        $visiteur = $em->find('AgenceBundle:Visiteur', $id);

        $message = $this->get('translator')->trans('visiteur.supprimer.echec');
        if(!$visiteur) { throw new NotFoundHttpException($message); }
        $em->remove($visiteur);
        $em->flush();
        return $this->redirectToRoute('agence_visiteur_lister');
    }

    public function topAction(Request $request, $max = 5) {
        $em = $this->getDoctrine() -> getManager();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder->select('v')
                ->from('AgenceBundle:Visiteur', 'v')
                ->orderBy('v.nom', 'ASC')
                ->setMaxResults($max);
        $query = $queryBuilder->getQuery();
        $visiteurs = $query->getResult();

        
        $message = $this->get('translator')->trans('visiteur.liste.trouver', array(
            '%number%' => count($visiteurs)
        ));        

        return $this->render('@Agence/Visiteur/liste.html.twig', array('visiteurs'=>$visiteurs, 'number_of_visiteur' => $message));

    } 

}