<?php

namespace Tms\Bundle\RecipeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tms\Bundle\RecipeBundle\Entity\Ingredient;
use Tms\Bundle\RecipeBundle\Form\IngredientType;

/**
 * Ingredient controller.
 *
 * @Route("/ingredient")
 */
class IngredientController extends Controller
{

    /**
     * Lists all Ingredient entities.
     *
     * @Route("/", name="ingredient")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('recipe');

        $entities = $em->getRepository('TmsRecipeBundle:Ingredient')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Ingredient entity.
     *
     * @Route("/", name="ingredient_create")
     * @Method("POST")
     * @Template("TmsRecipeBundle:Ingredient:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Ingredient();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('recipe');
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ingredient_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Ingredient entity.
     *
     * @param Ingredient $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ingredient $entity)
    {
        $form = $this->createForm(new IngredientType(), $entity, array(
            'action' => $this->generateUrl('ingredient_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Ingredient entity.
     *
     * @Route("/new", name="ingredient_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ingredient();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Ingredient entity.
     *
     * @Route("/{id}", name="ingredient_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager('recipe');

        $entity = $em->getRepository('TmsRecipeBundle:Ingredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingredient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ingredient entity.
     *
     * @Route("/{id}/edit", name="ingredient_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager('recipe');

        $entity = $em->getRepository('TmsRecipeBundle:Ingredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingredient entity.');
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
    * Creates a form to edit a Ingredient entity.
    *
    * @param Ingredient $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ingredient $entity)
    {
        $form = $this->createForm(new IngredientType(), $entity, array(
            'action' => $this->generateUrl('ingredient_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Ingredient entity.
     *
     * @Route("/{id}", name="ingredient_update")
     * @Method("PUT")
     * @Template("TmsRecipeBundle:Ingredient:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager('recipe');

        $entity = $em->getRepository('TmsRecipeBundle:Ingredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingredient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ingredient_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Ingredient entity.
     *
     * @Route("/{id}", name="ingredient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('recipe');
            $entity = $em->getRepository('TmsRecipeBundle:Ingredient')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ingredient entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ingredient'));
    }

    /**
     * Creates a form to delete a Ingredient entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ingredient_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
