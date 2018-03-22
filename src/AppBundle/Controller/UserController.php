<?php

namespace AppBundle\Controller;

use App\Form\EditProfileType;
use AppBundle\Entity\User;
use AppBundle\Form\EditUserProfileType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * Affiche la lste des utilisateurs du site
     * @Route("user/list", name="user_list")
     */
    public function listAction(Request $request, EntityManagerInterface $entityManager)
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        return $this->render('user/user-list.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Affiche les détails d'un utilisateur
     *
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("user/show/{user}", name="user_show")
     */
    public function showAction(User $user)
    {
     return $this->render('user/show.html.twig', [
         'user' => $user
     ]);
    }

    /**
     * Modifier les informations de l'utilisateur
     *
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("user/edit/{user}", name="user_edit")
     */
    public function editAction(User $user, EntityManagerInterface $entityManager, Request $request)
    {
        $form = $this->createForm(EditUserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted())
        {
            $entityManager->flush();
            $this->addFlash('success','L\'utilisateur a été modifié avec succès');
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * Supprimer un utilisateur
     * @param User $user
     * @param EntityManagerInterface $entityManager
     *
     * @Route("user/delete/{user}", name="user_delete")
     */
    public function deleteAction(User $user, EntityManagerInterface $entityManager)
    {
        $deletedUser = $entityManager->getRepository(User::class)->find($user->getId());
        $entityManager->remove($deletedUser);
        $entityManager->flush();

        $this->addFlash('success','L\'utilisateur a été supprimé avec succès');

        return $this->redirectToRoute('user_list');
    }

    /**
     * @param User $user
     *
     * @Route("user/dashboard/{user}", name="dashboard")
     */
    public function dashboardUser(User $user)
    {
        return $this->render('dashboard/dashboard.html.twig', [
            'user' => $user
        ]);
    }

}
