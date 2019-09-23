<?php

namespace App\Controller;

use DateTime;
use App\Entity\Sex;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\ClassName;
use App\Form\ProfilUpdateType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/profil")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/", name="profil_index", methods={"GET"})
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'utilisateur' => $user,
        ]);
    }

    /**
     * @Route("/infospersos", name="infospersos", methods={"GET","POST"})
     */
    public function infosPersos(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(ProfilUpdateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profil_index');
        }

        return $this->render('profil/infospersos.html.twig', [
            'user'=>$user,
            'formProfilUpdate'=>$form->createView(),
        ]);
    }
}
