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
        // PARTIE A REMPLACER PROCHAINEMENT :
        // Creation d'un utilisateur (normalement récuperé via la connexion)
        $role = $this->getDoctrine()->getRepository(Role::class)->find(1); // Retirer le use "use App\Entity\Role;" si suppression.
        $sex = $this->getDoctrine()->getRepository(Sex::class)->find(2); // Retirer le use "use App\Entity\Sex;" si suppression.
        $studentClassName = $this->getDoctrine()->getRepository(ClassName::class)->find(1); // Retirer le use "use App\Entity\ClassName;" si suppression.
        $utilisateur = new User(); // Retirer le use "use App\Entity\User;" si suppression.
        $utilisateur->setUserName('Vanilla')
            ->setLastName('Ysondre')
            ->setFirstName('Kagurazaka')
            ->setPassword('1234')
            ->setBirthDate(new DateTime()) // Retirer le use "use App\Entity\User;" si suppression.
            ->setPhone('0123456789')
            ->setAddress("147 sentier de l'église 59320 hallennes lez haubourdin")
            ->setRole($role)
            ->setSex($sex)
            ->setStudentClassName($studentClassName)
            ->setEmail('abc@abc.fr');
        // FIN DE PARTIE A SUPPRIMER

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'utilisateur' => $utilisateur,
        ]);
    }

    /**
     * @Route("/infospersos", name="infospersos", methods={"GET","POST"})
     */
    public function infosPersos(Request $request)
    {
        // PARTIE A REMPLACER PROCHAINEMENT :
        // Creation d'un utilisateur (normalement récuperé via la connexion)
        $role = $this->getDoctrine()->getRepository(Role::class)->find(1); // Retirer le use "use App\Entity\Role;" si suppression.
        $sex = $this->getDoctrine()->getRepository(Sex::class)->find(2); // Retirer le use "use App\Entity\Sex;" si suppression.
        $studentClassName = $this->getDoctrine()->getRepository(ClassName::class)->find(1); // Retirer le use "use App\Entity\ClassName;" si suppression.
        $user = new User(); // Retirer le use "use App\Entity\User;" si suppression.
        $user->setUserName('Vanilla')
            ->setLastName('Ysondre')
            ->setFirstName('Kagurazaka')
            ->setPassword('1234')
            ->setBirthDate(new DateTime()) // Retirer le use "use App\Entity\User;" si suppression.
            ->setPhone('0123456789')
            ->setAddress("147 sentier de l'église 59320 hallennes lez haubourdin")
            ->setRole($role)
            ->setSex($sex)
            ->setStudentClassName($studentClassName)
            ->setEmail('abc@abc.fr');
        // FIN DE PARTIE A SUPPRIMER

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
