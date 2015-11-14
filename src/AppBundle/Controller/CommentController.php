<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comments;
use AppBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Task;

/**
 * Class CommentController
 * @package AppBundle\Controller
 * @Route("/comment")
 */
class CommentController extends Controller
{
    /**
     * @Route("/viewComments")
     * @Template()
     */
    public function viewCommentsAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/add/{taskId}")
     * @Template()
     */
    public function addAction($taskId)
    {
        $comment = new Comments();
        $task = $this->getDoctrine()->getRepository("AppBundle:Task")->find($taskId);
        $comment->setTask($task);
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(new CommentType($manager), $comment)
            ->add("save", "submit", array("label" => "New Comment"));

        return array("form" => $form->createView(), "task" => $task);
    }

    /**
     * @Route("/addComment")
     * @Method("POST")
     */
    public function addCommentAction(Request $request)
    {
        $comment = new Comments();
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(new CommentType($manager), $comment)
            ->add("save", "submit", array("label" => "New Comment"));

        $form->handleRequest($request);
        $validator = $this->get("validator");
        $errors = $validator->validate($comment);
        if (!$form->isValid()) {
            return $this->render("AppBundle:Comment:add.html.twig",
                array("errors" => $errors, "form" =>$form->createView())
            );
        }
        $comment->setTask($comment->getTask());
//        var_dump($comment->getTask());
//        exit;
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();
        return $this->redirectToRoute("app_category_viewcategorieslist");
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
     * @Route("/editComment")
     * @Template()
     */
    public function editCommentAction()
    {
        return array(// ...
        );
    }
}

