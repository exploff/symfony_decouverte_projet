<?php

namespace ClubBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ClubBundle\Entity\Adherent;

use ClubBundle\Form\AdherentType;

use ClubBundle\Form\AdherentRechercheType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdherentController extends Controller {

    public function editerAction(Request $request, $id=null) {
        $em = $this->getDoctrine()->getManager();
        if(isset($id)){
            $adherent = $em->find('ClubBundle:Adherent', $id);
        }
        else{
            $adherent = new Adherent();
        }

        $form = $this->createForm(AdherentType::class, $adherent);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            
            $em->persist($adherent);
            $em->flush();
            
            $message = $this->get('translator')->trans('adherent.ajouter.succes', array(
                '%nom%' => $adherent->getNom(),
                '%prenom%' => $adherent->getPrenom()
            ));
            $request->getSession()->getFlashBag()->add('notice', $message);

            return $this->redirectToRoute('club_adherent_lister');
        }

        return $this->render('@Club/Adherent/editer.html.twig', array('form' => $form->createView()));
    }

    public function listerAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $adherents= $em->getRepository('ClubBundle:Adherent')->findAll();
        $form = $this->createForm(AdherentRechercheType::class);


        $message = $this->get('translator')->trans('adherent.liste.trouver', array(
            '%number%' => count($adherents)
        ));

        return $this->render ('@Club/Adherent/lister.html.twig',array('adherents' => $adherents, 
                                                                        'formRechAdh' => $form->createView(), 
                                                                        'number_of_adherents' => $message));
    }

    public function supprimerAction($id){
        $em = $this->getDoctrine()->getManager();
        $adherent = $em->find('ClubBundle:Adherent', $id);

        $message = $this->get('translator')->trans('adherent.ajouter.succes');
        if(!$adherent) { throw new NotFoundHttpException($message); }
        $em->remove($adherent);
        $em->flush();
        return $this->redirectToRoute('club_adherent_lister');
    }

    public function topAction($max = 5){
        $em = $this ->getDoctrine()->getManager();    
        $qb=$em->createQueryBuilder();
        $qb->select('a')
            ->from('ClubBundle:Adherent','a')
            ->orderBy('a.date','DESC')
            ->setMaxResults($max);
        $query = $qb->getQuery();
        $adherents = $query->getResult();

        $message = $this->get('translator')->trans('adherent.liste.trouver', array(
            '%number%' => count($adherents)
        ));

        return $this->render('@Club/Adherent/liste.html.twig',array('adherents'=>$adherents, 'number_of_adherents' => $message));
    }

    public function rechercherAction(Request $request) {

        // si la m??thode AHAX a ??t?? utilis??e
        if($request->isXmlHttpRequest()) {
            $motcle = '';
            // on r??cup??re le contenu du champs motcl??
            $motcle = $request->request->get('motcle');
            // on r??cup??re le gestionnaire d'entit??
            $em = $this->getDoctrine()->getManager();
            // si le mot-cl?? existe ...
            if($motcle != '') {
                $qb = $em->createQueryBuilder();
                // on d??finit une requ??te pr??par??e qui va rechercher les adherents dont le nom ou le pr??nom ressemble au mot-cl?? saisi
                $qb->select('a')
                    ->from('ClubBundle:Adherent', 'a')
                    ->where("a.nom LIKE :motcle OR a.prenom LIKE :motcle")
                    ->orderBy('a.nom', 'ASC')
                    ->setParameter('motcle', '%'.$motcle.'%');
                $query = $qb->getQuery();   $adherents = $query->getResult();
            }
            // sinon on r??cup??re tous les adh??rents
            else { 
                $adherents = $em->getRepository('ClubBundle:Adherent')->findAll(); 
            }
    
            $message = $this->get('translator')->trans('adherent.liste.trouver', array(
                '%number%' => count($adherents)
            ));

            // on retourne la liste des adh??rents trouv??s dans le formulaire list.html.twig
            return $this->render('@Club/Adherent/liste.html.twig', array('adherents'=>$adherents, 'number_of_adherents' => $message));
        }
        // si la m??thode AJAX n'a pas ??t?? appel??e alors o renvoie vers la m??thode listerAction
        else { return $this->listerAction($request); }
    }
}

