<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
    public function addCategoryAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/addFormCategory")
     * @Template()
     */
    public function addFormCategoryAction()
    {
        return array(// ...
        );
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
