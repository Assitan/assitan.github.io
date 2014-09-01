<?php

namespace GoMobility\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\Common\Util\Debug as Debug;

class ProjectPageController extends Controller
{
    /**
     * 
     * @Route("/projet", name="public.project.index")
     * @Template("PublicBundle:Project:index.html.twig")
     */
    public function indexAction()
    {
    	$breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem("Projet", $this->get("router")->generate("public.project.index"));

        $doctrine = $this->getDoctrine();

        $total_experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->getExperiences();
        $actus = $doctrine->getRepository('PublicBundle:Actualite')->getLast3Actualites();

        if (!$total_experiences || !$actus) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité Ecoactor.');
        }

        return array(
            'total_experiences' => $total_experiences,
            'actus' => $actus
        );
    }
}
