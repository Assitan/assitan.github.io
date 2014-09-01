<?php

namespace GoMobility\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GoMobility\PublicBundle\Entity\Comment;
use GoMobility\PublicBundle\Form\CommentType;

/**
 * Comment controller.
 *
 * @Route("/admin")
 */
class CommentController extends Controller
{

    /**
     * Lists all Comment entities.
     *
     * @Route("/commentaires", name="admin.comments.index")
     * @Method("GET")
     * @Template("AdminBundle:Comment:index.html.twig")
     */
    public function indexAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Commentaires", $this->get("router")->generate("admin.comments.index"));

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PublicBundle:Comment')->findAll();
        $publish = $em->getRepository('PublicBundle:Comment')->getPublish();
        $unpublish = $em->getRepository('PublicBundle:Comment')->getUnpublish();

        if (!$entities || !$publish || !$unpublish) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité.');
        }

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            5
        );

        $pagination_publish = $paginator->paginate(
            $publish,
            $this->get('request')->query->get('page', 1),
            5
        );

        $pagination_unpublish = $paginator->paginate(
            $unpublish,
            $this->get('request')->query->get('page', 1),
            5
        );

        return array(
            'entities' => $entities,
            'pagination_publish' => $pagination_publish,
            'pagination_unpublish' => $pagination_unpublish,
            'pagination' => $pagination
        );
    }
  

    /**
     * Finds and displays a Comment entity.
     *
     * @Route("/commentaires/{id}", name="admin.comments.show")
     * @Method("GET")
     * @Template("AdminBundle:Comment:show.html.twig")
     */
    public function showAction($id)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Commentaires", $this->get("router")->generate("admin.comments.index"));
        $breadcrumbs->addItem("Commentaire n° " . $id , $this->get("router")->generate("admin.comments.show", array('id' => $id)));

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicBundle:Comment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité Comment.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Comment entity.
     *
     * @Route("/commentaires/{id}/edit", name="admin.comments.edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicBundle:Comment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité Comment.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
    * Creates a form to edit a Comment entity.
    *
    * @param Comment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Comment $entity)
    {
        $form = $this->createForm(new CommentType(), $entity, array(
            'action' => $this->generateUrl('admin.comments.update', array('id' => $entity->getId())),
            'method' => 'PUT'
        ));
        $form->add('submit', 'submit', array('label' => 'Mettre à jour', 'attr' => array('class'=>'btn btn-info')));
        
        return $form;
    }
    /**
     * Edits an existing Comment entity.
     *
     * @Route("/commentaires/{id}", name="admin.comments.update")
     * @Method("PUT")
     * @Template("PublicBundle:Comment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Commentaires", $this->get("router")->generate("admin.comments.index"));
        $breadcrumbs->addItem("Modifier" . $id , $this->get("router")->generate("admin.comments.update", array('id' => $id)));

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicBundle:Comment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité Comment.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->set('notice','Le commentaire a été modifié');
            return $this->redirect($this->generateUrl('admin.comments.edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        );
    }
    /**
     * Deletes a Comment entity.
     *
     * @Route("/commentaires/{id}", name="admin.comments.delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PublicBundle:Comment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de trouver l\'entité Comment.');
            }

            $em->remove($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->set('notice','Le commentaire a été supprimé');
        }

        return $this->redirect($this->generateUrl('admin.comments.index'));
    }

    /**
     * Creates a form to delete a Comment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin.comments.delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer', 'attr' => array('class'=>'btn btn-danger')))
            ->getForm()
        ;
    }
}
