<?php

namespace App\Controller;

use App\Entity\AlertStyle;
use App\Form\AlertStyleType;
use App\Repository\AlertStyleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request,Response};
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/alertstyle")
 * @IsGranted("ROLE_ADMIN")
 */
class AlertStyleController extends AbstractController
{
    /**
     * @Route("/", name="alert_style_index", methods={"GET"})
     */
    public function index(AlertStyleRepository $alertStyleRepository): Response
    {
        return $this->render('alert_style/index.html.twig', [
            'alert_styles' => $alertStyleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="alert_style_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $alertStyle = new AlertStyle();
        $form = $this->createForm(AlertStyleType::class, $alertStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($alertStyle);
            $entityManager->flush();

            return $this->redirectToRoute('alert_style_index');
        }

        return $this->render('alert_style/new.html.twig', [
            'alert_style' => $alertStyle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alert_style_show", methods={"GET"})
     */
    public function show(AlertStyle $alertStyle): Response
    {
        return $this->render('alert_style/show.html.twig', [
            'alert_style' => $alertStyle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="alert_style_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AlertStyle $alertStyle): Response
    {
        $form = $this->createForm(AlertStyleType::class, $alertStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('alert_style_index');
        }

        return $this->render('alert_style/edit.html.twig', [
            'alert_style' => $alertStyle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alert_style_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AlertStyle $alertStyle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alertStyle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($alertStyle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('alert_style_index');
    }
}
