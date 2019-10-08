<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\{User, Role};
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 * @IsGranted("ROLE_SECRETARIAT")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder, RoleRepository $roleRepository): Response
    {
        $user = new User();
        $Admin = new Role();
        $Prof = new Role();
        $Eleve = new Role();
        $Secretariat = new Role();
        $roles['Professeur'] = $Prof->setName('ROLE_PROFESSEUR');
        $roles['Élève'] = $Eleve->setName('ROLE_ELEVE');
        if ($this->getUser()->getRoles()[0] == 'ROLE_ADMIN') {
            $roles['Admin'] = $Admin->setName('ROLE_ADMIN');
            $roles['Secrétariat'] = $Secretariat->setName('ROLE_SECRETARIAT');
        }
        $form = $this->createForm(UserType::class, $user)
            ->add('role', ChoiceType::class, [
                'choices' => $roles,
                'label' => 'name'
            ])
            ->add('plainPassword', TextType::class, [
                'mapped' => false,
                "required" => true,
                'constraints' => [new Length([
                    'min' => 5, 'max' => 255,
                    'minMessage' => "Le mot de passe doit faire plus de 5 caractères",
                    'maxMessage' => "Le mot de passe ne doit pas dépasser 255 caractères"
                ])]
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $role = $form['role']->getData();
            $role = $roleRepository->findBy(['name' => $role->getName()]);
            $user->setRole($role[0]);
            $hash = $encoder->encodePassword($user, $form['plainPassword']->getData());
            $user->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user,  UserPasswordEncoderInterface $encoder, RoleRepository $roleRepository): Response
    {
        // $Admin = new Role();
        // $Prof = new Role();
        // $Eleve = new Role();
        // $Secretariat = new Role();
        // $roles['Professeur'] = $Prof->setName('ROLE_PROFESSEUR');
        // $roles['Élève'] = $Eleve->setName('ROLE_ELEVE');
        // if ($this->getUser()->getRoles()[0] == 'ROLE_ADMIN') {
        //     $roles['Admin'] = $Admin->setName('ROLE_ADMIN');
        //     $roles['Secrétariat'] = $Secretariat->setName('ROLE_SECRETARIAT');
        // }
        $form = $this->createForm(UserType::class, $user)
            ->add('role', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'name',
            ])

            // ->add('role', ChoiceType::class, [
            //     'choices' => $roles,
            //     'label' => 'name'
            // ])
            ->add('plainPassword', TextType::class, [
                'mapped' => false,
                "required" => false
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $role = $form['role']->getData();
            $plainPassword = $form['plainPassword']->getData();
            if ($plainPassword) {
                $hash = $encoder->encodePassword($user, $plainPassword);
                $user->setPassword($hash);
            }
            $role = $roleRepository->findBy(['name' => $role->getName()]);
            $user->setRole($role[0]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
