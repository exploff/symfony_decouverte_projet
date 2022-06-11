<?php

namespace AgenceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AgenceBundle\Entity\Bien;
use Symfony\Component\HttpFoundation\Request;
use AgenceBundle\Form\BienType;
use AgenceBundle\Form\BienRechercheType;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BienController extends Controller {

    public function listerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $biens = $em->getRepository('AgenceBundle:Bien')->findAll();
        $form = $this->createForm(BienRechercheType::class);

        $message = $this->get('translator')->trans('bien.liste.trouver', array(
            '%number%' => count($biens)
        ));

        return $this->render('@Agence/Bien/lister.html.twig', array('biens'=>$biens, 'number_of_bien' => $message, 'formRchBien' => $form->createView()));
    }

    public function editerAction(Request $request, $id=null) {
       
        $em = $this->getDoctrine()->getManager();

        //modification d'une bien existante sinon crÃ©ation d'un nouveau bien
        if(isset($id)){
            $bien = $em->find('AgenceBundle:Bien', $id);
        } else {
            $bien = new Bien();
        }

        // On crÃ©e un formulaire basÃ© sur le format BienType et l'objet bien
        $form = $this->createForm(BienType::class, $bien);

        // Si le formulaire est soumis et si les donnÃ©es sont valides
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
 

            //On enregistre notre objet acteur dans la base de donnÃ©es
            $em = $this->getDoctrine()->getManager();
            $em->persist($bien);
            $em->flush();
 
            $message = $this->get('translator')->trans('bien.ajouter.succes', array(
                '%nomBien%' => $bien->getNomBien()
            ));
            //On prÃ©pare un message pour informer du succÃ©s dans la page destination
            $request->getSession()->getFlashBag()->add('notice', $message);
 
            //on redirige vers la liste des clubs
            return $this->redirectToRoute('agence_bien_lister');
        }
 
        //on passe la mÃ©thode createView() du formulaire Ã  la vue 
        //afin qu'elle puisse afficher le formulaire toute seule
 
        return $this->render('@Agence/Bien/editer.html.twig', array('form' => $form->createView()));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $bien =  $em->find('AgenceBundle:Bien', $id);
        return $this->render('@Agence/Bien/voir.html.twig', array('bien'=>$bien));
    }


    public function supprimerAction($id) {
        $em = $this->getDoctrine() -> getManager();
        $bien = $em->find('AgenceBundle:Bien', $id);

        $message = $this->get('translator')->trans('bien.supprimer.echec');
        if(!$bien) { throw new NotFoundHttpException($message); }
        $em->remove($bien);
        $em->flush();
        return $this->redirectToRoute('agence_bien_lister');
    }

    public function topAction(Request $request, $max = 5) {
        $em = $this->getDoctrine() -> getManager();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder->select('a')
                ->from('AgenceBundle:Bien', 'a')
                ->orderBy('a.nomBien', 'ASC')
                ->setMaxResults($max);
        $query = $queryBuilder->getQuery();
        $biens = $query->getResult();

        
        $message = $this->get('translator')->trans('bien.liste.trouver', array(
            '%number%' => count($biens)
        ));        

        return $this->render('@Agence/Bien/liste.html.twig', array('biens'=>$biens, 'number_of_bien' => $message));

    } 

    public function rechercherAction(Request $request) {
        
        if($request->isXmlHttpRequest()) {
            $motcle = '';
            $motcle = $request->request->get('motcle');
            $em = $this->getDoctrine()->getManager();
            if($motcle != '') {
                $qb = $em->createQueryBuilder();
                $qb->select('a')
                    ->from('AgenceBundle:Bien', 'a')
                    ->where("a.nomBien LIKE :motcle OR a.dateConstruction LIKE :motcle OR a.prix LIKE :motcle")
                    ->orderBy('a.nomBien', 'ASC')
                    ->setParameter('motcle', '%'.$motcle.'%');
                $query = $qb->getQuery();   
                $biens = $query->getResult();
            } else { 
                $biens = $em->getRepository('AgenceBundle:Bien')->findAll(); 
            }
    
            $message = $this->get('translator')->trans('bien.liste.trouver', array(
                '%number%' => count($biens)
            ));
            return $this->render('@Agence/Bien/liste.html.twig', array('biens'=>$biens, 'number_of_bien' => $message));
        }
        else { return $this->listerAction($request); }
    }

}