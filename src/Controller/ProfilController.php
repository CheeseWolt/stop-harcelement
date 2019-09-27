<?php

namespace App\Controller;

use DateTime;
use App\Entity\Sex;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Alert;
use App\Entity\ClassName;
use App\Form\ProfilUpdateType;
use App\Form\UpdatePasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        if($user->getRole()->getName() == "ROLE_ELEVE")
        {
            $alerts = $user->getAlerts();
        }
        if($user->getRole()->getName() == "ROLE_PROFESSEUR" || "ROLE_ADMIN")
        {
            $alerts = $this->getDoctrine()->getRepository(Alert::class)->findBy(['alertManager'=>$user]);
        }
        // if($user->getRole()->getName() == "ROLE_ADMIN")
        // {
        //     $alerts = $this->getDoctrine()->getRepository(Alert::class)->findBy(['alertManager'=>$user]);
        // }
        // if($user->getRole()->getName() == "ROLE_SECRETARIAT")
        // {
        //     $alerts = null;
        // }

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'utilisateur' => $user,
            'alerts' => $alerts,
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

    /**
     * @Route("/newpassword", name="new_password", methods={"GET","POST"})
     */
    public function newPassword(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(UpdatePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($encoder->isPasswordValid($user, $form["password"]->getData())) {
                $newEncodedPassword = $encoder->encodePassword($user, $form['newpassword']->getData());
                $user->setPassword($newEncodedPassword);
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');
                return $this->redirectToRoute('profil_index');
            }else{
                $form->addError(new FormError('L\'ancien mot de passe est incorrect'));
            }
        }

        return $this->render('profil/updatepassword.html.twig', [
            'user'=>$user,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/alerthistory", name="alerthistory", methods={"GET"})
     */
    public function getAlertsHistoryByRole()
    {
        $user = $this->getUser();
        if($user->getRole()->getName() == "ROLE_ELEVE")
        {
            $alerts = $user->getAlerts();
        }
        if($user->getRole()->getName() == "ROLE_PROFESSEUR")
        {
            $alerts = $this->getDoctrine()->getRepository(Alert::class)->findBy(['alertManager'=>$user]);
        }
        if($user->getRole()->getName() == "ROLE_ADMIN")
        {
            $alerts = $this->getDoctrine()->getRepository(Alert::class)->findBy(['alertManager'=>$user]);
        }
        return $this->render('profil/alertHistory.html.twig', [
            'alerts'=>$alerts,
        ]);
    }

}
