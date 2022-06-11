<?php

namespace AgenceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AgenceBundle\Entity\TypeBien;
use AgenceBundle\Form\TypeBienType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TypeBienController extends Controller {
    
    public function listerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $typebiens = $em->getRepository('AgenceBundle:TypeBien')->findAll();

        $message = $this->get('translator')->trans('typebien.liste.trouver', array(
            '%number%' => count($typebiens)
        ));

        return $this->render('@Agence/TypeBien/lister.html.twig', array('typebiens'=>$typebiens, 'number_of_typebien' => $message));
    }

    public function editerAction(Request $request, $id=null) {
       
        $em = $this->getDoctrine()->getManager();

        if(isset($id)){
            $typebien = $em->find('AgenceBundle:TypeBien', $id);
        } else {
            $typebien = new TypeBien();
        }

        $form = $this->createForm(TypeBienType::class, $typebien);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
 
            $em = $this->getDoctrine()->getManager();
            $em->persist($typebien);
            $em->flush();
 
            $message = $this->get('translator')->trans('typebien.ajouter.succes', array(
                '%nomType%' => $typebien->getNomType()
            ));
            $request->getSession()->getFlashBag()->add('notice', $message);
 
            return $this->redirectToRoute('agence_typebien_lister');
        }
  
        return $this->render('@Agence/TypeBien/editer.html.twig', array('form' => $form->createView()));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $typebien =  $em->find('AgenceBundle:TypeBien', $id);
        return $this->render('@Agence/TypeBien/voir.html.twig', array('typebien'=>$typebien));
    }


    public function supprimerAction($id) {
        $em = $this->getDoctrine() -> getManager();
        $typebien = $em->find('AgenceBundle:TypeBien', $id);

        $message = $this->get('translator')->trans('typebien.supprimer.echec');
        if(!$typebien) { throw new NotFoundHttpException($message); }
        $em->remove($typebien);
        $em->flush();
        return $this->redirectToRoute('agence_typebien_lister');
    }

    public function topAction(Request $request, $max = 5) {
        $em = $this->getDoctrine() -> getManager();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder->select('v')
                ->from('AgenceBundle:TypeBien', 't')
                ->orderBy('t.nomType', 'ASC')
                ->setMaxResults($max);
        $query = $queryBuilder->getQuery();
        $typebiens = $query->getResult();

        
        $message = $this->get('translator')->trans('typebien.liste.trouver', array(
            '%number%' => count($typebiens)
        ));        

        return $this->render('@Agence/TypeBien/liste.html.twig', array('typebiens'=>$typebiens, 'number_of_typebien' => $message));

    } 

}