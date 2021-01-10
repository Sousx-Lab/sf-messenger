<?php

namespace App\Controller;

use App\Form\UserNotifierType;
use App\Messenger\Message\UserNotificationMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, MessageBusInterface $messageBus): Response
    {
        $form = $this->createForm(UserNotifierType::class, []);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $messageBus->dispatch(new UserNotificationMessage($data['user']->getId()));
            $this->addFlash('success', 'La notification a bien été envoyée');
            return $this->redirectToRoute('home');
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
