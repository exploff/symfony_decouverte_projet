<?php

namespace AgenceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AgenceBundle\Entity\Achat;
use Symfony\Component\HttpFoundation\Request;
use AgenceBundle\Form\AchatType;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AchatController extends Controller {

    public function listerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $achats = $em->getRepository('AgenceBundle:Achat')->findBy(array(), array('dateAchat' => 'DESC'));
        $form = $this->createForm(AchatType::class);

        $message = $this->get('translator')->trans('achat.liste.trouver', array(
            '%number%' => count($achats)
        ));

        return $this->render('@Agence/Achat/lister.html.twig', array('achats'=>$achats, 'number_of_achat' => $message, 'formRchAchat' => $form->createView()));
    }

    public function editerAction(Request $request, $id=null) {
       
        $em = $this->getDoctrine()->getManager();

        if(isset($id)){
            $achat = $em->find('AgenceBundle:Achat', $id);
        } else {
            $achat = new Achat();
        }

        $form = $this->createForm(AchatType::class, $achat);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
 

            $em = $this->getDoctrine()->getManager();
            $em->persist($achat);
            $em->flush();
 
            $message = $this->get('translator')->trans('achat.ajouter.succes', array(
                '%id%' => $achat->getId()
            ));
            $request->getSession()->getFlashBag()->add('notice', $message);
 
            return $this->redirectToRoute('agence_achat_lister');
        }
 
        return $this->render('@Agence/Achat/editer.html.twig', array('form' => $form->createView()));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $achat =  $em->find('AgenceBundle:Achat', $id);
        return $this->render('@Agence/Achat/voir.html.twig', array('achat'=>$achat));
    }


    public function supprimerAction($id) {
        $em = $this->getDoctrine() -> getManager();
        $achat = $em->find('AgenceBundle:Achat', $id);

        $message = $this->get('translator')->trans('achat.supprimer.echec');
        if(!$achat) { throw new NotFoundHttpException($message); }
        $em->remove($achat);
        $em->flush();
        return $this->redirectToRoute('agence_achat_lister');
    }


}