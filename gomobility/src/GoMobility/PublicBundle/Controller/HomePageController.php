<?php

namespace GoMobility\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GoMobility\PublicBundle\Entity\Actualite;
use Doctrine\Common\Util\Debug as Debug;

class HomePageController extends Controller
{
    /**
     * 
     * @Route("/accueil", name="public.homepage.index", options={"expose"=true})
     * @Template("PublicBundle:HomePage:index.html.twig")
     */
    public function indexAction()
    {

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));

        $doctrine = $this->getDoctrine();
        
        $last_experience = $doctrine->getRepository('PublicBundle:Ecoactor')->getLastExperience();
        $total_experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->getExperiences();
        $last10_experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->getTenExperience();
        $actus = $doctrine->getRepository('PublicBundle:Actualite')->getLast3Actualites();

        if (!$last_experience || !$total_experiences || !$actus) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité.');
        }
        
        return array(
            'last_experience' => $last_experience,
            'total_experiences' => $total_experiences,
            'last10_experiences' => $last10_experiences,
            'actus' => $actus
        );
    }
}
