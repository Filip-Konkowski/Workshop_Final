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
use AppBundle\Entity\Category;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CategoryToNumberTransformer implements DataTransformerInterface
{
    private $manager;
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * Transforms an object (category) to a string (number).
     *
     * @param  Category|null $category
     * @return string
     */
    public function transform($category)
    {
        if (null === $category) {
            return '';
        }
        return $category->getId();
    }
    /**
     * Transforms a string (number) to an object (Category).
     *
     * @param  string $category
     * @return Category|null
     * @throws TransformationFailedException if object (Category) is not found.
     */
    public function reverseTransform($category)
    {
        // no category number? It's optional, so that's ok
        if (!$category) {
            return;
        }
        $category = $this->manager
            ->getRepository('AppBundle:Category')
            // query for the issue with this id
            ->find($category)
        ;
        if (null === $category) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $category
            ));
        }
        return $category;
    }
}