<?php

namespace GoMobility\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\Common\Util\Debug as Debug;

class MenuController extends Controller
{
    /**
     * 
     * @Route()
     * @Template("PublicBundle:CommonBlocks:breadcrumb.html.twig")
     */
    public function indexAction()
    {
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem("Projet", $this->get("router")->generate("public.project.index"));
        return array();
    }
}
