<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comments;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CommentController
 * @package AppBundle\Controller
 * @Route("/comment")
 */
class CommentController extends Controller
{
    /**
     * @Route("/viewComment")
     * @Template()
     */
    public function viewCommentAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/add")
     * @Template()
     */
    public function addAction()
    {
        $comment = new Comments();
        $form = $this->createFormBuilder($comment)
                        ->add("content", "text", array("label" => "Add your comment"))
                        ->add("save", "submit", array("label" => "comment"))
                        ->getForm();
        return array("form" => $form->createView());
    }

    /**
     * @Route("/addComment")
     * @Method("POST")
     */
    public function addCommentAction(Request $request)
    {
        $comment = new Comments();
        $form = $this->createFormBuilder($comment)
            ->add("content", "text", array("label" => "Add your comment"))
            ->add("save", "submit", array("label" => "comment"))
            ->getForm();
        $form->handleRequest($request);
        $validator = $this->get("validator");
        $errors = $validator->validate($comment);
        if (!$form->isValid()) {
            return $this->render("AppBundle:Comment:add.html.twig",
                array("errors" => $errors, "form" =>$form->createView())
            );
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();
        return $this->redirectToRoute("app_comment_viewcomment");
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

