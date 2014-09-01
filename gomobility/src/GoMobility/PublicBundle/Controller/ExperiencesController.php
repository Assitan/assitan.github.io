<?php

namespace GoMobility\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request as Request;
use GoMobility\PublicBundle\Entity\Comment;
use GoMobility\PublicBundle\Entity\Ecoactor;
use GoMobility\PublicBundle\Form\CommentType;
use Doctrine\Common\Util\Debug as Debug;

class ExperiencesController extends Controller
{
    /**
     * 
     * @Route("/experiences", name="public.experiences.list", options={"expose"=true})
     * @Template("PublicBundle:Experiences:list.html.twig")
     */
    public function listAction()
    {
    	$breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem("Expériences", $this->get("router")->generate("public.experiences.list"));
        
        $doctrine = $this->getDoctrine();

        $total_experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->getExperiences();
        $actus = $doctrine->getRepository('PublicBundle:Actualite')->getLast3Actualites();

        if (!$total_experiences || !$actus) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité.');
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $total_experiences,
            $this->get('request')->query->get('page', 1),
            4
        );

        return array(
            'pagination' => $pagination,
            'total_experiences' => $total_experiences,
            'actus' => $actus
        );
    }

    /**
     * 
     * @Route("/experiences/classement", name="public.experiences.ranking")
     * @Template("PublicBundle:Experiences:ranking.html.twig")
     */
    public function rankingAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem("Expériences", $this->get("router")->generate("public.experiences.ranking"));
        
        $doctrine = $this->getDoctrine();

        $total_experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->getExperiences();
        $actus = $doctrine->getRepository('PublicBundle:Actualite')->getLast3Actualites();

        if (!$total_experiences || !$actus) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité Ecoactor.');
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $total_experiences,
            $this->get('request')->query->get('page', 1),
            10
        );

        return array(
            'pagination' => $pagination,
            'total_experiences' => $total_experiences,
            'actus' => $actus
        );
    }

    /**
     * 
     * @Route("/experience/{id}", name="public.experience.show", options={"expose"=true})
     * @Template("PublicBundle:Experiences:experience.html.twig")
     */
    public function showAction($id, Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem("Expériences", $this->get("router")->generate("public.experiences.list"));
        $breadcrumbs->addItem('Expérience ' . $id, $this->get("router")->generate("public.experience.show", array('id' => $id)));
        
        $doctrine = $this->getDoctrine();
        
        $experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->find($id);
        $total_experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->getExperiences();
        $actus = $doctrine->getRepository('PublicBundle:Actualite')->getLast3Actualites();
        
        if (!$experiences || !$experiences || !$total_experiences) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité.');
        }

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $comments = new Comment();
        
        $form = $this->createForm(new CommentType(), $comments)
            ->add('captcha', 'captcha', array(
                'as_url' => true,
                'invalid_message' => 'Mauvaise valeur',
                'attr' => array(
                    'class' => 'form-control captcha_input'
                )))
            ->add('valider','submit', array('attr' => array('class' => 'btn btn-info' )));
        $form->handleRequest($request);

        if($form->isValid()){      
            
            $comments = $form->getData();
            $comments->setEcoactor($experiences);
            $em->persist($comments);
            $em->flush();

            $request->getSession()->getFlashBag()->set('notice','Votre commentaire a été ajouté');
            $url = $this->generateUrl('public.experience.show', array('id' => $id));
            return $this->redirect($url);
        }

        $comms = $doctrine->getRepository('PublicBundle:Comment')->getComment($id);

        return array(
            'total_experiences' => $total_experiences,
            'experiences' => $experiences,
            'comments' => $comments,
            'comms' => $comms,
            'form' => $form->createView(),
            'actus' => $actus
        );
    }
}
