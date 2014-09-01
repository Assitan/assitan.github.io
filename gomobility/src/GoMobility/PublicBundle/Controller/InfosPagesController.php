<?php

namespace GoMobility\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GoMobility\PublicBundle\Entity\Ecoactor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request as Request;
use Doctrine\Common\Util\Debug as Debug;

class InfosPagesController extends Controller
{

    /**
     * 
     * @Route("/meilleur-eco-acteur", name="public.infospages.meilleur")
     * @Template("PublicBundle:InfosPages:meilleurEco.html.twig")
     */
    public function meilleurEcoAction()
    {   

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem("Meilleur éco-acteur", $this->get("router")->generate("public.infospages.meilleur"));
        
        $doctrine = $this->getDoctrine();
        
        $ecoActeur = $doctrine->getRepository('PublicBundle:Ecoactor')->getTheBestEcoactor();
        $total_experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->getExperiences();
        $actus = $doctrine->getRepository('PublicBundle:Actualite')->getLast3Actualites();
        
        if (!$ecoActeur || !$total_experiences || !$actus) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité.');
        }

        return array(
            'bestEA' => $ecoActeur,
            'total_experiences' => $total_experiences,
            'actus' => $actus
        );
    }
    
    /**
     * 
     * @Route("/application-mobile", name="public.infospages.appli-mobile")
     * @Template("PublicBundle:InfosPages:appli-mobile.html.twig")
     */
    public function applicationAction()
    {   
   
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem("Meilleur éco-acteur", $this->get("router")->generate("public.infospages.appli-mobile"));
        
        $doctrine = $this->getDoctrine();
        $total_experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->getExperiences();
        $actus = $doctrine->getRepository('PublicBundle:Actualite')->getLast3Actualites();

        if (!$total_experiences || !$actus) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité.');
        }

        return array(
            'total_experiences' => $total_experiences,
            'actus' => $actus
        );
    }
    
    /**
     * 
     * @Route("/mentions-légales", name="public.infospages.mentions")
     * @Template("PublicBundle:InfosPages:mentions.html.twig")
     */
    public function mentionsAction(Request $request)
    {   

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem("Mentions légales", $this->get("router")->generate("public.infospages.mentions"));
 
         $doctrine = $this->getDoctrine();

        $total_experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->getExperiences();
        $actus = $doctrine->getRepository('PublicBundle:Actualite')->getLast3Actualites();
        
        if (!$total_experiences || !$actus) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité.');
        }
       
        return array(
            'total_experiences' => $total_experiences,

            'actus' => $actus
        );

    }
       
    /**
     * 
     * @Route("/actualité/{id}", name="public.infospages.actualite")
     * @Template("PublicBundle:InfosPages:actualite.html.twig")
     */
    public function actualiteAction($id, Request $request)
    {   

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem('Actualité ' . $id, $this->get("router")->generate("public.infospages.actualite", array('id' => $id)));
 
        $doctrine = $this->getDoctrine();
        
        $theActu = $doctrine->getRepository('PublicBundle:Actualite')->find($id);

        $total_experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->getExperiences();
        $actus = $doctrine->getRepository('PublicBundle:Actualite')->getLast3Actualites();
             
        if (!$total_experiences || !$actus) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité.');
        }
        
        return array(
            'total_experiences' => $total_experiences,
            'actus' => $actus,         
            'theActu' => $theActu
        );
    }
    
}
