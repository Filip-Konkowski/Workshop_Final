<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 09.11.15
 * Time: 09:48
 */

namespace AppBundle\Form\Type;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\DataTransformer\CategoryToNumberTransformer;


class TaskType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    public function getName()
    {
        return "task";
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", "text")
            ->add("description", "textarea")
            ->add("deadline", "date")
            ->add("priority", "number")
            ->add("category", "hidden")
            ->add("save", "submit", array("label" => "New Task"))
        ;
        $builder->get('category')
            ->addModelTransformer(new CategoryToNumberTransformer($this->manager));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Task'
        ));
    }
}