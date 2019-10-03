<?php

namespace App\Controller;

use App\Entity\{Role,User,ClassLevel};
use App\Form\ClassLevelType;
use App\Repository\ClassLevelRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{Request, Response};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/class/level")
 * @IsGranted("ROLE_ADMIN")
 */
class ClassLevelController extends AbstractController
{
    /**
     * @Route("/", name="class_level_index", methods={"GET"})
     */
    public function index(ClassLevelRepository $classLevelRepository): Response
    {
        return $this->render('class_level/index.html.twig', [
            'class_levels' => $classLevelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="class_level_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $classLevel = new ClassLevel();
        $form = $this->createForm(ClassLevelType::class, $classLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classLevel);
            $entityManager->flush();

            return $this->redirectToRoute('class_level_index');
        }

        return $this->render('class_level/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="class_level_show", methods={"GET"})
     */
    public function show(ClassLevel $classLevel): Response
    {
        return $this->render('class_level/show.html.twig', [
            'class_level' => $classLevel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="class_level_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ClassLevel $classLevel): Response
    {
        $role = $this->getDoctrine()->getRepository(Role::class)->findOneBy(['name' => "ROLE_PROFESSEUR"]);
        $profs = $this->getDoctrine()->getRepository(User::class)->findBy(['role' => $role]);
        $form = $this->createForm(ClassLevelType::class, $classLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('class_level_index');
        }

        return $this->render('class_level/edit.html.twig', [
            'class_level' => $classLevel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="class_level_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ClassLevel $classLevel): Response
    {
        if ($this->isCsrfTokenValid('delete' . $classLevel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($classLevel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('class_level_index');
    }
}
