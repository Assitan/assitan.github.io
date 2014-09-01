<?php

namespace GoMobility\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request as Request;
use GoMobility\PublicBundle\Entity\Contact;
use GoMobility\PublicBundle\Form\ContactType;
use Doctrine\Common\Util\Debug as Debug;

/**
 * Contact controller.
 *
 * @Route("/admin/contact")
 */
class ContactController extends Controller
{

    /**
     * Lists all Contact entities.
     *
     * @Route("/", name="admin.contact.index")
     * @Method("GET")
     * @Template("AdminBundle:Contact:index.html.twig")
     */
    public function indexAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Messages", $this->get("router")->generate("admin.contact.index"));

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PublicBundle:Contact')->getAllMessages();
        $received = $em->getRepository('PublicBundle:Contact')->getReceived();
        $sent = $em->getRepository('PublicBundle:Contact')->getSent();

        if (!$entities || !$received || !$sent) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité.');
        }

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            10
        );

        $pagination_received = $paginator->paginate(
            $received,
            $this->get('request')->query->get('page', 1),
            10
        );

        $pagination_sent = $paginator->paginate(
            $sent,
            $this->get('request')->query->get('page', 1),
            10
        );

        return array(
            'pagination_received' => $pagination_received,
            'pagination_sent' => $pagination_sent,
            'pagination' => $pagination
        );
    }
    /**
     * Creates a new Contact entity.
     *
     * @Route("/", name="admin.contact.create")
     * @Method("POST")
     * @Template("PublicBundle:Contact:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Contact();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->set('notice','Le message a été envoyé');

            return $this->redirect($this->generateUrl('admin.contact.show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a form to create a Contact entity.
     *
     * @param Contact $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Contact $entity)
    {
        $form = $this->createForm(new ContactType(), $entity, array(
            'action' => $this->generateUrl('admin.contact.create'),
            'method' => 'POST'
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Contact entity.
     *
     * @Route("/message", name="admin.contact.new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Nouveau", $this->get("router")->generate("admin.contact.new"));

        $type = new ContactType();
        $form = $this->createForm($type)
            ->add('type', 'hidden', array(
                    'data' => 'envoyé'
                ))
           ->add('valider','submit', array('attr' => array('class' => 'btn btn-info' )));
        $form->handleRequest($request);
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        
        if($form->isValid()){
            $data = $form->getData();
            //var_dump($data); exit();
            $mail = $form->get('email')->getData();
            $nom = $form->get('nom')->getData();
            $message = $form->get('message')->getData();
            $sujet = $form->get('sujet')->getData();

            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($data); 
            $em->flush();
            $request->getSession()->getFlashBag()->set('notice','Le message a été envoyé');
            
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

            $request->getSession()->getFlashBag()->set('notice','Le message a été envoyé');
            $url = $this->generateUrl('admin.contact.index');
            return $this->redirect($url);
        }

        return array(      
            'form'   => $form->createView()
        );
    }

    /**
     * Finds and displays a Contact entity.
     *
     * @Route("/{id}", name="admin.contact.show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Messages", $this->get("router")->generate("admin.contact.index"));
        $breadcrumbs->addItem("Message", $this->get("router")->generate("admin.contact.show", array('id' => $id)));

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité Contact.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Contact entity.
     *
     * @Route("/{id}", name="admin.contact.delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PublicBundle:Contact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de trouver l\'entité Contact.');
            }

            $em->remove($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->set('notice','Le message a été supprimé');
        }

        return $this->redirect($this->generateUrl('contact'));
    }

    /**
     * Creates a form to delete a Contact entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin.contact.delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer', 'attr' => array(
                'class'=>'btn btn-danger'
                )))
            ->getForm()
        ;
    }
}
