<?php

namespace App\Controller;

use DateTime;
use App\Entity\Alert;
use App\Form\AlertType;
use App\Repository\AlertRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/alert")
 */
class AlertController extends AbstractController
{
    /**
     * @Route("/", name="alert_index", methods={"GET"})
     */
    public function index(AlertRepository $alertRepository): Response
    {
        return $this->render('alert/index.html.twig', [
            'alerts' => $alertRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="alert_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $alert = new Alert();
        $form = $this->createForm(AlertType::class, $alert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($alert);
            $entityManager->flush();

            return $this->redirectToRoute('alert_index');
        }

        return $this->render('alert/new.html.twig', [
            'alert' => $alert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alert_show", methods={"GET"})
     */
    public function show(Alert $alert): Response
    {
        return $this->render('alert/show.html.twig', [
            'alert' => $alert,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="alert_edit", methods={"GET","POST"})
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
     * @IsGranted("ROLE_USER")
     */
    public function manage(Request $request, Alert $alert): Response
    {

        $alert->setAlertManager($this->getUser())->setStartSupportDate(new DateTime('now'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($alert);
        $em->flush();
        return $this->render('alert/show.html.twig', [
            'alert' => $alert,
        ]);
    }


}
