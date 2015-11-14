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
use AppBundle\Form\DataTransformer\TaskToNumberTransformer;


class CommentType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    public function getName() {
        return "comment";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'textarea')
            ->add("task", "hidden")
        ;
        $builder->get('task')
            ->addModelTransformer(new TaskToNumberTransformer($this->manager));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Comments'
        ));
    }
}