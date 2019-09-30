<?php

namespace App\Controller;

use DateTime;
use App\Repository\AlertRepository;
use App\Entity\{Alert,PrivateMessage};
use App\Form\{AlertType,PrivateMessageType};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{Request,Response};
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/alert")
 */
class AlertController extends AbstractController
{
    /**
     * @Route("/", name="alert_index", methods={"GET"})
     * @IsGranted("ROLE_PROFESSEUR")
     */
    public function index(AlertRepository $alertRepository): Response
    {
        $user = $this->getUser();
        return $this->render('alert/index.html.twig', [
            'alerts' => $alertRepository->findAll(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/new", name="alert_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $alert = new Alert();
        $alert->setAlertSender($this->getUser());
        $form = $this->createForm(AlertType::class, $alert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $alert->setIpAddress($request->getClientIp());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($alert);
            $entityManager->flush();

            return $this->redirectToRoute('profil_index');
        }

        return $this->render('alert/new.html.twig', [
            'alert' => $alert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alert_show")
     */
    public function show(Alert $alert, Request $request): Response
    {
        $pms = $alert->getPrivateMessages();
        $pm = new PrivateMessage();
        $pm->setAlert($alert)->setUser($this->getUser());

        $form = $this->createForm(PrivateMessageType::class,$pm);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pm);
            $entityManager->flush();

            return $this->redirectToRoute('alert_show',['id'=>$alert->getId()]);
        }

        return $this->render('alert/show.html.twig', [
            'alert' => $alert,
            'private_messages' => $pms,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="alert_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Alert $alert): Response
    {
        $form = $this->createForm(AlertType::class, $alert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('alert_index');
        }

        return $this->render('alert/edit.html.twig', [
            'alert' => $alert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alert_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Alert $alert): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alert->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($alert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('alert_index');
    }


    /**
     * @Route("manage/{id}", name="alert_manage")
     * @IsGranted("ROLE_PROFESSEUR")
     */
    public function manage(Request $request, Alert $alert): Response
    {

        $alert->setAlertManager($this->getUser())->setStartSupportDate(new DateTime('now'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($alert);
        $em->flush();
        return $this->redirectToRoute('alert_show',['id'=>$alert->getId()]);
    }

    /**
     * @Route("close/{id}", name="alert_close")
     * @IsGranted("ROLE_PROFESSEUR")
     */
    public function close(Request $request, Alert $alert): Response
    {
        $alert->setEndSupportDate(new DateTime('now'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($alert);
        $em->flush();
        return $this->redirectToRoute('alert_show',['id'=>$alert->getId()]);
    }


}
