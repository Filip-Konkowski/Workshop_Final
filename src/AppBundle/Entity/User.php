<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 04.11.15
 * Time: 14:24
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="user")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="user")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     */
    private $tasks;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        parent::__construct();
        // your own logic
    }

    /**
     * Set categories
     *
     * @param \AppBundle\Entity\Category $categories
     *
     * @return User
     */
    public function setCategories(\AppBundle\Entity\Category $categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return User
     */
    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Add task
     *
     * @param \AppBundle\Entity\Task $task
     *
     * @return User
     */
    public function addTask(\AppBundle\Entity\Task $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Remove task
     *
     * @param \AppBundle\Entity\Task $task
     */
    public function removeTask(\AppBundle\Entity\Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
