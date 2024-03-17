<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ToDoListController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'to_do_list')]
    public function index(EntityManagerInterface $em)
    {
        $tasks = $em->getRepository(Task::class)->findBy([], ['id' => 'DESC']);
        return $this->render('index.html.twig', ['tasks' => $tasks]);
    }

    #[Route('/create', name: 'create_task', methods: 'POST')]
    public function create(Request $request)
    {
        $title = trim($request->request->get('title'));
        if (empty($title))
            return $this->redirectToRoute('to_do_list');

        $task = new Task();
        $task->setTitle($title);

        $this->em->persist($task);
        $this->em->flush();

        return $this->redirectToRoute('to_do_list');
    }

    #[Route('/switch-status/{id}', name: 'switch_status')]
    public function switchStatus(Task $task)
    {
        $task->setStatus(!$task->isStatus());
        $this->em->flush();

        return $this->redirectToRoute('to_do_list');
    }

    #[Route('/delete/{id}', name: 'task_delete')]
    public function delete(Task $task): RedirectResponse
    {
        $this->em->remove($task);
        $this->em->flush();

        return $this->redirectToRoute('to_do_list');
    }
}
