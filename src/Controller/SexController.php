<?php

namespace App\Controller;

use App\Entity\Sex;
use App\Form\SexType;
use App\Repository\SexRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request,Response};
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/sex")
 * @IsGranted("ROLE_ADMIN")
 */
class SexController extends AbstractController
{
    /**
     * @Route("/", name="sex_index", methods={"GET"})
     */
    public function index(SexRepository $sexRepository): Response
    {
        return $this->render('sex/index.html.twig', [
            'sexes' => $sexRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sex_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sex = new Sex();
        $form = $this->createForm(SexType::class, $sex);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sex);
            $entityManager->flush();

            return $this->redirectToRoute('sex_index');
        }

        return $this->render('sex/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sex_show", methods={"GET"})
     */
    public function show(Sex $sex): Response
    {
        return $this->render('sex/show.html.twig', [
            'sex' => $sex,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sex_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sex $sex): Response
    {
        $form = $this->createForm(SexType::class, $sex);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sex_index');
        }

        return $this->render('sex/edit.html.twig', [
            'sex' => $sex,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sex_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sex $sex): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sex->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sex);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sex_index');
    }
}
