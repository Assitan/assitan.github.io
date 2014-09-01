<?php

namespace GoMobility\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request as Request;
use GoMobility\PublicBundle\Entity\Contact;
use GoMobility\PublicBundle\Form\ContactType;
use Doctrine\Common\Util\Debug as Debug;

class ContactController extends Controller
{

    /**
     * 
     * @Route("/contact", name="public.contact.index")
     * @Template("PublicBundle:Contact:index.html.twig")
     */
    public function indexAction(Request $request)
    {   

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("public.homepage.index"));
        $breadcrumbs->addItem("Contact", $this->get("router")->generate("public.contact.index"));
        
        $type = new ContactType();
        $form = $this->createForm($type)
                ->add('type', 'hidden', array(
                    'data' => 'reçu'
                ))
                ->add('captcha', 'captcha', array(
                'as_url' => true,
                'invalid_message' => 'Mauvaise valeur',
                'attr' => array(
                    'class' => 'form-control captcha_input'
                )))
                ->add('valider','submit', array('attr' => array('class' => 'btn btn-info' )));
        $form->handleRequest($request);
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        
        if($form->isValid()){
            $data = $form->getData();
            $mail = $form->get('email')->getData();
            $nom = $form->get('nom')->getData();
            $message = $form->get('message')->getData();
            $sujet = $form->get('sujet')->getData();

            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($data); 
            $em->flush();
            
            //Envoi de mail   
            $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl' )
            ->setUsername('gomobility07')
            ->setPassword('projetdev07');   
            $mailer = \Swift_Mailer::newInstance($transport);
            $message = \Swift_Message::newInstance()
            ->setSubject('Gomobility message :'.$sujet)
            ->setFrom(array($mail => $nom))
            ->setTo('saifi.boinali@gmail.com')
            ->setBody($this->renderView('PublicBundle:Contact:mail.html.twig', array('nom' => $nom, 'mail'=>$mail, 'message'=>$message)))
            ->setContentType('text/html');
            $mailer->send($message);  

            $request->getSession()->getFlashBag()->set('notice','Votre message a été envoyé. Nous vous répondrons dans les plus bref délais');
            $url = $this->generateUrl('public.contact.index');
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
