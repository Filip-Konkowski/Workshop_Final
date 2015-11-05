<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Task;

class TaskController extends Controller
{
    /**
     * @Route("/viewTaskList", name="app_task_view_all")
     * @Template()
     */
    public function viewTaskListAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/addTask")
     * @Method("POST")
     */
    public function addTaskAction(Request $request)
    {
        $task = new Task();
        $form = $this->createFormBuilder($task)
            ->add("name", "text")
            ->add("description", "textarea")
            ->add("deadline", "date")
            ->add("priority", "number")
            ->add("save", "submit", array("label" => "New Task"))
            ->getForm();

        $form->handleRequest($request);
        if (!$form->isValid()) {
            // throw error
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();
        return $this->redirectToRoute("app_task_view_all");
    }

    /**
     * @Route("/addFormTask")
     * @Template()
     */
    public function addFormTaskAction()
    {
        $task = new Task();
        $form = $this->createFormBuilder($task)
            ->add("name", "text")
            ->add("description", "textarea")
            ->add("deadline", "date")
            ->add("priority", "number")
            ->add("save", "submit", array("label" => "New Task"))
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
     * @Route("/editTask")
     * @Template()
     */
    public function editTaskAction()
    {
        return array(// ...
        );
    }

}
