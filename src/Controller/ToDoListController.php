<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ToDoListController extends AbstractController
{
    #[Route('/', name: 'to_do_list')]
    public function index()
    {
        return $this->render('index.html.twig');
    }

    #[Route('/create', name: 'create_task', methods:'POST')]
    public function create(Request $request)
    {
        exit('to do: create!');    
    }
}