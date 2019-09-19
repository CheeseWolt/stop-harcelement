<?php

namespace App\Controller;

use App\Entity\PrivateMessage;
use App\Form\PrivateMessageType;
use App\Repository\PrivateMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/private/message")
 */
class PrivateMessageController extends AbstractController
{
    /**
     * @Route("/", name="private_message_index", methods={"GET"})
     */
    public function index(PrivateMessageRepository $privateMessageRepository): Response
    {
        return $this->render('private_message/index.html.twig', [
            'private_messages' => $privateMessageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="private_message_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $privateMessage = new PrivateMessage();
        $form = $this->createForm(PrivateMessageType::class, $privateMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($privateMessage);
            $entityManager->flush();

            return $this->redirectToRoute('private_message_index');
        }

        return $this->render('private_message/new.html.twig', [
            'private_message' => $privateMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="private_message_show", methods={"GET"})
     */
    public function show(PrivateMessage $privateMessage): Response
    {
        return $this->render('private_message/show.html.twig', [
            'private_message' => $privateMessage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="private_message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PrivateMessage $privateMessage): Response
    {
        $form = $this->createForm(PrivateMessageType::class, $privateMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('private_message_index');
        }

        return $this->render('private_message/edit.html.twig', [
            'private_message' => $privateMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="private_message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PrivateMessage $privateMessage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$privateMessage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($privateMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('private_message_index');
    }
}
