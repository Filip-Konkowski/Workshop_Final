<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 09.11.15
 * Time: 10:11
 */

namespace AppBundle\Form\DataTransformer;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use AppBundle\Entity\Task;
use Symfony\Component\Form\Exception\TransformationFailedException;


class TaskToNumberTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (task) to a string (number).
     *
     * @param  Task|null $task
     * @return string
     */
    public function transform($task)
    {
        if (null === $task) {
            return '';
        }

        return $task->getId();
    }

    /**
     * Transforms a string (number) to an object (Task).
     *
     * @param  string $comments
     * @return Task|null
     * @throws TransformationFailedException if object (Task) is not found.
     */
    public function reverseTransform($comments)
    {
        // no category number? It's optional, so that's ok
        if (!$comments) {
            return;
        }

        $comments = $this->manager
            ->getRepository('AppBundle:Task')
            // query for the issue with this id
            ->find($comments)
        ;

        if (null === $comments) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $comments
            ));
        }

        return $comments;
    }
}