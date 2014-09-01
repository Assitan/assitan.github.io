<?php

namespace GoMobility\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GoMobility\PublicBundle\Entity\Actualite;
use GoMobility\PublicBundle\Form\ActualiteType;
use Doctrine\Common\Util\Debug as Debug;

/**
 * Actualite controller.
 *
 * @Route("/admin")
 */
class ActualiteController extends Controller
{

    /**
     * Lists all Actualite entities.
     *
     * @Route("/actualites", name="admin.actualites.index")
     * @Method("GET")
     * @Template("AdminBundle:Actualite:index.html.twig")
     */
    public function indexAction()
    {
       
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Actualités", $this->get("router")->generate("admin.actualites.index"));

        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PublicBundle:Actualite')->findAll();
        
        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            10
        );
        
        
        return array(
            'entities' => $entities,
            'pagination' => $pagination
        );
    }
    /**
     * Creates a new Actualite entity.
     *
     * @Route("/", name="admin.actualites.create")
     * @Method("POST")
     * @Template("AdminBundle:Actualite:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Actualite();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('actualite_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Actualite entity.
     *
     * @param Actualite $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Actualite $entity)
    {
        $form = $this->createForm(new ActualiteType(), $entity, array(
            'action' => $this->generateUrl('admin.actualites.create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Actualite entity.
     *
     * @Route("/nouveau", name="admin.actualites.new")
     * @Template()
     */
    public function newAction(Request $request)
    {
    
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Nouveau", $this->get("router")->generate("admin.contact.new"));
        
        $entity = new Actualite();
        $form   = $this->createCreateForm($entity)
         ->add('valider','submit', array('attr' => array('class' => 'btn btn-info' )));
         $form->handleRequest($request);
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        
        if($form->isValid()){
            $data = $form->getData();

            $em->persist($data); 
            $em->flush();
            $request->getSession()->getFlashBag()->set('notice','Nouvelle actualité ajouté');
           
            $url = $this->generateUrl('admin.actualites.new');
            return $this->redirect($url);
        }
  
        return array(
        
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Actualite entity.
     *
     * @Route("/{id}", name="admin.actualites.show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Actualités", $this->get("router")->generate("admin.actualites.index"));
        $breadcrumbs->addItem("Nouveau", $this->get("router")->generate("admin.actualites.show", array('id' => $id)));
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicBundle:Actualite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité Actualité.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Actualite entity.
     *
     * @Route("/{id}/edit", name="admin.actualites.edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicBundle:Actualite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actualite entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Actualite entity.
    *
    * @param Actualite $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Actualite $entity)
    {
        $form = $this->createForm(new ActualiteType(), $entity, array(
            'action' => $this->generateUrl('admin.actualites.update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour', 'attr' => array('class'=>'btn btn-info')));
        
        return $form;
    }
    /**
     * Edits an existing Actualite entity.
     *
     * @Route("/{id}", name="admin.actualites.update")
     * @Method("PUT")
     * @Template("PublicBundle:Actualite:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Actualités", $this->get("router")->generate("admin.actualites.index"));
        $breadcrumbs->addItem("Modifier" . $id , $this->get("router")->generate("admin.actualites.update", array('id' => $id)));

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicBundle:Actualite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité Actualité.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashBag()->set('notice','L\'actualité a été modifiée');
            return $this->redirect($this->generateUrl('admin.actualites.edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Actualite entity.
     *
     * @Route("/{id}", name="admin.actualites.delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PublicBundle:Actualite')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Actualite entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin.actualites.index'));
    }

    /**
     * Creates a form to delete a Actualite entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin.actualites.delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer', 'attr' => array('class'=>'btn btn-danger')))
            ->getForm()
        ;
    }
}
