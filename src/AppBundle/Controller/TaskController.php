<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Task;

/**
 * Class TaskController
 * @package AppBundle\Controller
 * @Route("/task")
 */
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
     * @Route("/viewTask/{taskId}", name="app_task_view_one")
     * @Template()
     */
    public function viewTaskAction($taskId)
    {
        $task = $this->getDoctrine()->getRepository("AppBundle:Task")->find($taskId);
        return array("task" => $task);
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
            ->add("categoryId", "hidden")
//            ->add("category", "entity", array(
//                                            "class" => "AppBundle:Category",
//                                            "choice_label" =>"name",
//                                            ))
            ->add("save", "submit", array("label" => "New Task"))
            ->getForm();



        $form->handleRequest($request);
        $task->setCategory($this->getDoctrine()->getRepository("AppBundle:Category")->find($task->getCategoryId()));

        $validator = $this->get("validator");
        $errors = $validator->validate($task);
        if (!$form->isValid()) {
            return $this->render("AppBundle:Task:add.html.twig",
                array("errors" => $errors, "form" =>$form->createView())
            );
        }
        $task->setUser($this->getUser());

//        echo ->getId(); exit;
        $task->setCategory($task->getCategory());
        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();
        return $this->redirectToRoute("app_task_view_all");
    }

    /**
     * @Route("/add/{categoryId}")
     * @Template()
     */
    public function addAction($categoryId)
    {
        $task = new Task();
        $form = $this->createFormBuilder($task)
            ->add("name", "text")
            ->add("description", "textarea")
            ->add("deadline", "date")
            ->add("priority", "number")
//            ->add("category", "entity", array(
//                "class" => "AppBundle:Category",
//                "choice_label" =>"name",
//            ))
            ->add("categoryId", "hidden", array("data" => $categoryId))
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
