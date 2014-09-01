<?php

namespace GoMobility\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GoMobility\PublicBundle\Entity\Ecoactor;
use GoMobility\PublicBundle\Form\EcoactorType;
use Doctrine\Common\Util\Debug as Debug;

/**
 * Ecoactor controller.
 *
 * @Route("/admin/ecoacteurs")
 */
class EcoactorController extends Controller
{

    /**
     * Lists all Ecoactor entities.
     *
     * @Route("/", name="admin.ecoactors.index")
     * @Method("GET")
     * @Template("AdminBundle:Ecoactor:index.html.twig")
     */
    public function indexAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Ecoacteurs", $this->get("router")->generate("admin.ecoactors.index"));

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PublicBundle:Ecoactor')->getEcoactor();
        $publish = $em->getRepository('PublicBundle:Ecoactor')->getExperiences();
        $unpublish = $em->getRepository('PublicBundle:Ecoactor')->getUnpublish();

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
            'pagination_publish' => $pagination_publish,
            'pagination_unpublish' => $pagination_unpublish,
            'pagination' => $pagination
        );
    }
    /**
     * Creates a new Ecoactor entity.
     *
     * @Route("/", name="admin.ecoactors.create")
     * @Method("POST")
     * @Template("PublicBundle:Ecoactor:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Ecoactor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->set('notice','L\'expérience a été ajoutée');

            return $this->redirect($this->generateUrl('admin.ecoactors.show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Finds and displays a Ecoactor entity.
     *
     * @Route("/{id}", name="admin.ecoactors.show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Ecoacteurs", $this->get("router")->generate("admin.ecoactors.index"));
        $breadcrumbs->addItem("Ecoacteurs " . $id, $this->get("router")->generate("admin.ecoactors.show", array('id' => $id)));

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicBundle:Ecoactor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité Ecoactor.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
     * Displays a form to edit an existing Ecoactor entity.
     *
     * @Route("/{id}/editer", name="admin.ecoactors.edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Ecoacteurs", $this->get("router")->generate("admin.ecoactors.index"));
        $breadcrumbs->addItem("Modifier", $this->get("router")->generate("admin.ecoactors.update", array('id' => $id)));

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicBundle:Ecoactor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité Ecoactor.');
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
    * Creates a form to edit a Ecoactor entity.
    *
    * @param Ecoactor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ecoactor $entity)
    {
        $form = $this->createForm(new EcoactorType(), $entity, array(
            'action' => $this->generateUrl('admin.ecoactors.update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour', 'attr' => array('class'=>'btn btn-info')));

        return $form;
    }

    /**
     * Edits an existing Ecoactor entity.
     *
     * @Route("/{id}", name="admin.ecoactors.update")
     * @Method("PUT")
     * @Template("AdminBundle:Ecoactor:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Ecoacteurs", $this->get("router")->generate("admin.ecoactors.index"));
        $breadcrumbs->addItem("Modifier", $this->get("router")->generate("admin.ecoactors.update", array('id' => $id)));

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicBundle:Ecoactor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité Ecoactor.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->set('notice','L\'expérience a été mise à jour');

            return $this->redirect($this->generateUrl('admin.ecoactors.edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        );
    }
    /**
     * Deletes a Ecoactor entity.
     *
     * @Route("/{id}", name="admin.ecoactors.delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PublicBundle:Ecoactor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de trouver l\'entité Ecoactor.');
            }

            $em->remove($entity);
            $em->flush();
            $request->getSession()->getFlashBag()->set('notice','L\'expérience a été supprimée');
        }

        return $this->redirect($this->generateUrl('admin.ecoactors.index'));
    }

    /**
     * Creates a form to delete a Ecoactor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */ 
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin.ecoactors.delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer', 'attr' => array(
                'class'=>'btn btn-danger'
                )))
            ->getForm()
        ;
    }

    /**
     * 
     * @Route("/ecoacteurs/classement", name="admin.ecoactors.ranking")
     * @Template("AdminBundle:Ecoactor:ranking.html.twig")
     */
    public function rankingAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("admin.homepage.index"));
        $breadcrumbs->addItem("Classement", $this->get("router")->generate("admin.ecoactors.ranking"));

        $em = $this->getDoctrine()->getManager();
        $ranking = $em->getRepository('PublicBundle:Ecoactor')->getBestEcoactor();

        if (!$ranking) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité.');
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $ranking,
            $this->get('request')->query->get('page', 1),
            10
        );

        return array(
            'pagination' => $pagination
        );
    }
}

