<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package AppBundle\Controller
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/viewCategoriesList")
     * @Template()
     */
    public function viewCategoriesListAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/addCategory")
     * @Method("POST")
     */
    public function addCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createFormBuilder($category)
            ->add("name", "text", array("label" => "Name for category"))
            ->add("save", "submit", array("label" => "New Category"))
            ->getForm();
        $form->handleRequest($request);

        if (!$form->isValid()) {
            //throw error
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        return $this->redirectToRoute("app_category_viewcategorieslist");
    }

    /**
     * @Route("/add")
     * @Template()
     */
    public function addFormCategoryAction()
    {
        $category = new Category();
        $form = $this->createFormBuilder($category)
                    ->add("name", "text", array("label" => "Name for category"))
                    ->add("save", "submit", array("label" => "New Category"))
                    ->getForm();
        return array("form" => $form->createView());
    }

    /**
     * @Route("/delete")
     * @Template()
     */
    public function deleteAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/editCategory")
     * @Template()
     */
    public function editCategoryAction()
    {
        return array(// ...
        );
    }

}