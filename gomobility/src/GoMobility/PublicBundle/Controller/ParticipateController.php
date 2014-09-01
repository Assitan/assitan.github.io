<?php

namespace GoMobility\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request as Request;
use GoMobility\PublicBundle\Form\EcoactorType;
use Doctrine\Common\Util\Debug as Debug;

class ParticipateController extends Controller
{
    /**
     * 
     * @Route("/participer/confirmation", name="public.participate.confirm", options={"expose"=true})
     * @Template("PublicBundle:Participate:confirm.html.twig")
     */
    public function indexAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem("Participer", $this->get("router")->generate("public.participate.post"));
        
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
     * @Route("/participer", name="public.participate.post")
     * @Template("PublicBundle:Participate:post.html.twig")
     */
    public function postAction(Request $request)
    {   

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem("Participer", $this->get("router")->generate("public.participate.post"));
        
        $type = new EcoactorType();
        $form = $this->createForm($type)
            ->add('captcha', 'captcha', array(
                'as_url' => true,
                'invalid_message' => 'Mauvaise valeur',
                'attr' => array(
                    'class' => 'form-control captcha_input'
                )))
            ->add('valider', 'submit', array('label' => 'Valider', 'attr' => array('class'=>'btn btn-info')));
        $form->handleRequest($request);
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        if($form->isValid()){
            $data = $form->getData();
            $em->persist($data);
            $em->flush();
            $nom = $form->get('nom')->getData();
            $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl' )
            ->setUsername('gomobility07')
            ->setPassword('projetdev07');
            $mailer = \Swift_Mailer::newInstance($transport);
            $message = \Swift_Message::newInstance();
            $message->setSubject("Nouvelle expérience de ".$nom);
            $message->setFrom('saifi@gmail.com');
            $message->setTo('gomobility07@gmail.com');
            $message->setBody('<p>Bonjour admin, une nouvelle experience vient d\'etre proposée à la publication par '.$nom.'</p>','text/html'); 
            $mailer->send($message);
            
            $url = $this->generateUrl('public.participate.confirm');
            return $this->redirect($url);
        }

        $doctrine = $this->getDoctrine();

        $total_experiences = $doctrine->getRepository('PublicBundle:Ecoactor')->getExperiences();
        $actus = $doctrine->getRepository('PublicBundle:Actualite')->getLast3Actualites();
        
        if (!$total_experiences || !$actus) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité.');
        }

        return array(
            'form' => $form->createView(),
            'total_experiences' => $total_experiences,
            'actus' => $actus
        );
    }

}
