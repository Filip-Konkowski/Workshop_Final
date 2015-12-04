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
     * @Route("/viewCategory/{id}")
     * @Template()
     */
    public function viewCategoryAction($id)
    {
        $category = $this->getDoctrine()->getRepository("AppBundle:Category")->find($id);
//        $tasks = $category->getTasks();
//
//        $em = $this->getDoctrine()->getManager();
//        $commentList = $em->getRepository("AppBundle:Comments")->findCommentsList(1);


        return array("category" => $category,
        );
    }

    /**
     * @Route("/viewCategoriesList")
     * @Template()
     */
    public function viewCategoriesListAction()
    {
        $categoriesList = $this->getDoctrine()->getRepository("AppBundle:Category")->findByUser($this->getUser());
        return array("categories" => $categoriesList);
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
        $validator = $this->get("validator");
        $errors = $validator->validate($category);
        if (!$form->isValid()) {
            return $this->render("AppBundle:Category:addFormCategory.html.twig",
                array("errors" => $errors, "form" => $form->createView())
            );
        }
        $category->setUser($this->getUser());
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
