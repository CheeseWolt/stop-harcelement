<?php

namespace App\Controller;

use App\Entity\ClassName;
use App\Form\ClassNameType;
use App\Repository\ClassNameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/class/name")
 */
class ClassNameController extends AbstractController
{
    /**
     * @Route("/", name="class_name_index", methods={"GET"})
     */
    public function index(ClassNameRepository $classNameRepository): Response
    {
        return $this->render('class_name/index.html.twig', [
            'class_names' => $classNameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="class_name_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $className = new ClassName();
        $form = $this->createForm(ClassNameType::class, $className);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($className);
            $entityManager->flush();

            return $this->redirectToRoute('class_name_index');
        }

        return $this->render('class_name/new.html.twig', [
            'class_name' => $className,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="class_name_show", methods={"GET"})
     */
    public function show(ClassName $className): Response
    {
        return $this->render('class_name/show.html.twig', [
            'class_name' => $className,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="class_name_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ClassName $className): Response
    {
        $form = $this->createForm(ClassNameType::class, $className);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('class_name_index');
        }

        return $this->render('class_name/edit.html.twig', [
            'class_name' => $className,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="class_name_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ClassName $className): Response
    {
        if ($this->isCsrfTokenValid('delete'.$className->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($className);
            $entityManager->flush();
        }

        return $this->redirectToRoute('class_name_index');
    }
}
