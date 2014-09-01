<?php

namespace GoMobility\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\Common\Util\Debug as Debug;

	/**
     * 
     * @Route("/admin")
     */
class HomePageController extends Controller
{
    /**
     * 
     * @Route("/", name="admin.homepage.index")
     * @Template("AdminBundle:HomePage:index.html.twig")
     */
    public function indexAction()
    {
    	$breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('PublicBundle:Ecoactor')->findAll();
        $messages = $em->getRepository('PublicBundle:Contact')->getReceived();
        $bestEcoactors = $em->getRepository('PublicBundle:Ecoactor')->getTheBestEcoactor();

        return array(
            'entities' =>  $entities,
            'bestEcoactors' =>  $bestEcoactors,
            'messages' => $messages
        );
    }
}