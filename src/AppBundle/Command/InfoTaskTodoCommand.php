<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 09.11.15
 * Time: 16:46
 */

namespace AppBundle\Command;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class InfoTaskTodoCommand extends ContainerAwareCommand
{
    protected function configure() {
        $this->setName("emailTasks:emailTodo")
             ->setDescription("sending information for all users about tasks to do from all categories")
             ;
    }

    protected  function  execute(InputInterface  $input,  OutputInterface  $output)  {
        $output->writeln("");
        $users = $this->getContainer()->get("doctrine")->getRepository("AppBundle:User")->findAll();
        /**
         * @var User $user
         */
        foreach ($users as $user) {
            $output->writeln("checking if user {$user->getUsername()} has tasks with deadline missed");
            $tasks = $user->getTasks();
//            $tasks = $user->getTasks()->filter(array("status" => Task::STATUS_TODO));
            /**
             * @var Task[] $tasks
             */
            foreach ($tasks as $task) {
                if ($task->getDeadline() < new \DateTime() && $task->getStatus() == Task::STATUS_TODO) {
                    $output->writeln("sending email to user {$user->getUsername()} with task {$task->getName()} ");
                    $this->sendEmail($task);
                    break; //nie chce wysyłać więej niż jednego maila na użytowknika
                }
            }
        }
    }

//    private function sendEmail($task) {
//
//        $transport = \Swift_SmtpTransport::newInstance("localhost", 25);
//
//        $mailer = \Swift_Mailer::newInstance($transport);
//        $email = \Swift_Message::newInstance()
//                ->setSubject("Remainder - Tasks")
//                ->setFrom("fk@gmail.com")
//                ->setTo("planner890123@gmail.com")
//                ->setBody("you have to do... ");
//        $sent = $mailer->send($email);
//
//    }

    private function sendEmail($task) {
        $emailUser = $task->getUser()->getEmail();
        $message = new \Swift_Message();
        $message->setSubject("TO DO list")
                ->setTo($emailUser)
                ->setFrom("fkonkowski@mail.com")
                ->setBody("lalala to jest mail");


        $container = $this->getContainer();
        $mailer = $container->get("mailer");
        $mailer->send($message);

        $spool = $mailer->getTransport()->getSpool();
        $transport = $container->get("swiftmailer.transport.real");
        $spool->flushQueue($transport);
    }
}