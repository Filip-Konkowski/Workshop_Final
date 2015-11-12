<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\Type\TaskType;
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
     * @Route("/viewTask/{taskId}", name="app_task_view_one")
     * @Template()
     */
    public function viewTaskAction($taskId)
    {
        $task = $this->getDoctrine()->getRepository("AppBundle:Task")->find($taskId);
        return array("task" => $task);
    }

    /**
     * @Route("/addTask/{categoryId}")
     * @Method("POST")
     */
    public function addTaskAction(Request $request, $categoryId)
    {
        $task = new Task();
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(new TaskType($manager), $task)
                    ->add("save", "submit", array("label" => "New Task"));

        $form->handleRequest($request);


        $validator = $this->get("validator");
        $errors = $validator->validate($task);
        if (!$form->isValid()) {
            return $this->render("AppBundle:Task:add.html.twig",
                array("errors" => $errors, "form" =>$form->createView())
            );
        }
        $task->setUser($this->getUser());
        $task->setCategory($task->getCategory());
        $task->setStatus(Task::STATUS_TODO);
        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();
//        return $this->redirectToRoute("app_category_viewcategorieslist");
        return $this->redirectToRoute("app_category_viewcategory", array("id" => $categoryId));
    }

    /**
     * @Route("/add/{categoryId}")
     * @Template()
     */
    public function addAction($categoryId)
    {
        $task = new Task();
        $category =  $this->getDoctrine()->getRepository("AppBundle:Category")->find($categoryId);
        $task->setCategory($category);
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(new TaskType($manager), $task)
                    ->add("save", "submit", array("label" => "New Task"));

        return array("form" => $form->createView(), "categoryId" => $categoryId );
    }

    /**
     * @Route("/delete/{taskId}")
     * @Template()
     */
    public function deleteAction($taskId)
    {
        $delTask = $this->getDoctrine()->getRepository("AppBundle:Task")->find($taskId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($delTask);
        $em->flush();
        return $this->redirectToRoute("app_category_viewcategorieslist");
    }

    /**
     * @Route("/editFormTask/{categoryId}/{taskId}")
     *
     */
    public function editFormTaskAction(Request $request, $categoryId, $taskId)
    {
        $editTask = $this->getDoctrine()->getRepository("AppBundle:Task")->find($taskId);
        $category =  $this->getDoctrine()->getRepository("AppBundle:Category")->find($categoryId);

        $editTask->setCategory($category);
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(new TaskType($manager), $editTask)
                    ->add("save", "submit", array("label" => "Edit"));

        return $this->render("AppBundle:Task:editFormTask.html.twig",
                                array("form" => $form->createView(),
                                    "taskId" => $taskId,
                                    "category" => $category,
                                    ));
    }

    /**
     * @Route("/updateTask/{categoryId}/{taskId}")
     * @Method("POST")
     */
    public function updateTaskAction(Request $request, $categoryId, $taskId)
    {
        $editTask = $this->getDoctrine()->getRepository("AppBundle:Task")->find($taskId);
        $category =  $this->getDoctrine()->getRepository("AppBundle:Category")->find($categoryId);
        $editTask->setCategory($category);
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(new TaskType($manager), $editTask)
                    ->add("save", "submit", array("label" => "Edit"));

        $form->handleRequest($request);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("app_category_viewcategory", array("id" => $categoryId));
    }

    /**
     * @Route("/done/{taskId}", name="app_task_donetask")
     * @Method("GET")
     */

    public function doneTask($taskId) {

        $task = $this->getDoctrine()->getRepository("AppBundle:Task")->find($taskId);

        $task->setStatus(Task::STATUS_DONE);
        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();
        return $this->redirectToRoute("app_category_viewcategorieslist");
    }

    /**
     * @Route("/todo/{taskId}", name="app_task_todotask")
     * @Method("GET")
     */

    public function todoTask($taskId) {

        $task = $this->getDoctrine()->getRepository("AppBundle:Task")->find($taskId);

        $task->setStatus(Task::STATUS_TODO);

        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();
        return $this->redirectToRoute("app_category_viewcategorieslist");
    }
}
