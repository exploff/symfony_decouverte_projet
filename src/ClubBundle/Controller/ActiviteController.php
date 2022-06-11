<?php

namespace ClubBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClubBundle\Entity\Activite;
use Symfony\Component\HttpFoundation\Request;
use ClubBundle\Form\ActiviteType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ActiviteController extends Controller {

    public function listerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $activites = $em->getRepository('ClubBundle:Activite')->findAll();

        $message = $this->get('translator')->trans('activite.liste.trouver', array(
            '%number%' => count($activites)
        ));

        return $this->render('@Club/Activite/lister.html.twig', array('activites'=>$activites, 'number_of_activite' => $message));
    }

    public function editerAction(Request $request, $id=null) {
       
        $em = $this->getDoctrine()->getManager();

        //modification d'une activite existante sinon création d'une nouvelle activite
        if(isset($id)){
            $activite = $em->find('ClubBundle:Activite', $id);
        } else {
            $activite = new Activite();
        }

        // On crée un formulaire basé sur le format ActiviteType et l'objet activite
        $form = $this->createForm(ActiviteType::class, $activite);

        // Si le formulaire est soumis et si les données sont valides
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
 
            //On enregistre notre objet acteur dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($activite);
            $em->flush();
 
            $message = $this->get('translator')->trans('activite.ajouter.succes', array(
                '%titre%' => $activite->getTitre()
            ));
            //On prépare un message pour informer du succés dans la page destination
            $request->getSession()->getFlashBag()->add('notice', $message);
 
            //on redirige vers la liste des clubs
            return $this->redirectToRoute('club_activite_lister');
        }
 
        //on passe la méthode createView() du formulaire à la vue 
        //afin qu'elle puisse afficher le formulaire toute seule
 
        return $this->render('@Club/Activite/editer.html.twig', array('form' => $form->createView()));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $activite =  $em->find('ClubBundle:Activite', $id);
        return $this->render('@Club/Activite/voir.html.twig', array('activite'=>$activite));
    }


    public function supprimerAction($id) {
        $em = $this->getDoctrine() -> getManager();
        $activite = $em->find('ClubBundle:Activite', $id);

        $message = $this->get('translator')->trans('activite.supprimer.echec');
        if(!$activite) { throw new NotFoundHttpException($message); }
        $em->remove($activite);
        $em->flush();
        return $this->redirectToRoute('club_activite_lister');
    }

    public function topAction(Request $request, $max = 5) {
        $em = $this->getDoctrine() -> getManager();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder->select('a')
                ->from('ClubBundle:Activite', 'a')
                ->orderBy('a.titre', 'ASC')
                ->setMaxResults($max);
        $query = $queryBuilder->getQuery();
        $activites = $query->getResult();

        
        $message = $this->get('translator')->trans('activite.liste.trouver', array(
            '%number%' => count($activites)
        ));        

        return $this->render('@Club/Activite/liste.html.twig', array('activites'=>$activites, 'number_of_activite' => $message));

    } 

}