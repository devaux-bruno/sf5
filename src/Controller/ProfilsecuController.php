<?php


namespace App\Controller;


use App\Entity\Profilsecu;


use App\Form\newPasswordType;
use App\Form\ProfilsecuEditType;
use App\Form\ProfilsecuType;
use App\Form\StatusType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilsecuController extends AbstractController
{
    /**
     * @Route("admin/user", name="user_index")
     */
    public function index()
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Profilsecu::class);
        $resultatedit= $userRepository->findAll();

        return $this->render(
            'admin/index_user.html.twig',
            [
                'resultatedit' => $resultatedit
            ]);
    }


    /**
     * @Route("member/profil", name="mon_compte")
     */
    public function indexProfil()
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Profilsecu::class);
        $resultatedit= $userRepository->findAll();

        return $this->render(
            'profil/profil.html.twig',
            [
                'resultatedit' => $resultatedit
            ]);
    }

    /**
     * @Route("/member/passwordEdit/{userId}", name="password_edit")
     */
    public function editPassword(Request $request, Profilsecu $userId, UserPasswordEncoderInterface $encoder)
    {

        // require the user to log in during *this* session
        // if they were only logged in via a remember me cookie, they
        // will be redirected to the login page
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $idUser = $this->getUser()->getId();
        $numIdUser = $userId->getId();

        if($idUser != $numIdUser ) {
            $this->addFlash('error', 'Vous ne pouvez modifier que votre profil');
            return $this->redirectToRoute('home',[]);
        }

        $form = $this->createForm(newPasswordType::class, $userId, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $dataold = $form->get('passwordsecu')->getData();
            $datanew = $form->get('newPassword')->getData();
            $checkPassword = $encoder->isPasswordValid($userId, $dataold);

            if($checkPassword === true){

                $doctrine = $this->getDoctrine();
                $entityManager = $doctrine->getManager();

                $newPassword = $encoder->encodePassword($userId, $datanew);
                $userId->setPasswordsecu($newPassword);

                $entityManager->persist($userId);
                $entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a bien été modifié!');

                return $this->redirectToRoute('mon_compte',[]);
            }
            else{
                $this->addFlash('error', 'Désolé, votre ancien mot de passe n\'est pas correct');
                return $this->redirectToRoute('password_edit', ['userId' => $idUser]);
            }
        }

        return $this->render('profil/password_edit.html.twig',[
            'formUserEdit' => $form->createView(),
        ]);

    }

    /**
     * @Route("/member/userEdit/{userId}", name="user_edit")
     */
    public function edit(Request $request, Profilsecu $userId)
    {

        $idUser = $this->getUser()->getId();
        $numIdUser = $userId->getId();

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $userPicture = $entityManager->getRepository(Profilsecu::class)->find($userId)->getImageprofil();

        if($idUser != $numIdUser ) {
            $this->addFlash('error', 'Vous ne pouvez modifier que votre profil');
            return $this->redirectToRoute('home',[]);
        }

        $form = $this->createForm(ProfilsecuEditType::class, $userId, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {

            if( !empty($userPicture) ){

                $file = $form->get('imageprofil')->getData();

                if( !empty($file) ){
                    //suppression de l'ancienne photo
                    $fichierSupp = $this->getParameter('profil_pictures_directory');
                    unlink($fichierSupp.$userPicture);
                    $fs = new Filesystem();
                    $fs->remove($fichierSupp.$userId->getImageprofil());

                    //update de la nouvelle photo
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('profil_pictures_directory'),
                            $fileName
                        );
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Un problème est survenu sur votre photo lors de la modification!');

                        return $this->redirectToRoute('user_edit', []);
                    }
                }
            }
            else{
                $file = $form->get('imageprofil')->getData();
                if( !empty($file) ){
                    //ajout d'une photo
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('profil_pictures_directory'),
                            $fileName
                        );
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Un problème est survenu sur votre photo lors de l\'enregistrement!');

                        return $this->redirectToRoute('user_edit', []);
                    }
                }
            }

            $userId->setImageprofil($fileName);
            $entityManager->persist($userId);
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a bien été modifié!');

            return $this->redirectToRoute('mon_compte',[]);
        }
        return $this->render('profil/profilsecu_edit.html.twig',[
            'formUserEdit' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/user-edit/{userId}", name="user_admin_edit")
     */
    public function adminEditProfil(Request $request, Profilsecu $userId, UserPasswordEncoderInterface $encoder)
    {

        $adminUser= $this->getUser()->getId();
        $otherId= $userId->getId();
        $idStatut= $userId->getStatut();

        if ($otherId != $adminUser AND $idStatut == 1) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer ou modifier un autre admin!');
            return $this->redirectToRoute('user_index');
        }

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $userPicture = $entityManager->getRepository(Profilsecu::class)->find($userId)->getImageprofil();

        $form = $this->createForm(ProfilsecuType::class, $userId, []);
        $formadmin = $this->createForm(StatusType::class, $userId, []);
        $formadmin->handleRequest($request);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            if($userId->getImageprofil() != '' || $userId->getImageprofil() != null )
            {
                if( !empty($userPicture))
                {
                    $file = $form->get('imageprofil')->getData();
                    if( !empty($file) )
                    {

                        //suppression de l'ancienne photo
                        $fichierSupp = $this->getParameter('profil_pictures_directory');
                        unlink($fichierSupp . $userPicture);
                        $fs = new Filesystem();
                        $fs->remove($fichierSupp.$userId->getImageprofil());

                        //update de la nouvelle photo
                        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                        try {
                            $file->move(
                                $this->getParameter('profil_pictures_directory'),
                                $fileName
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Un problème est survenu sur votre photo lors de la modification!');

                            return $this->redirectToRoute('user_admin_edit', []);
                        }
                    }
                }
                else{
                    $file = $form->get('imageprofil')->getData();
                    if( !empty($file) ) {
                        //ajout d'une photo
                        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                        try {
                            $file->move(
                                $this->getParameter('profil_pictures_directory'),
                                $fileName
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Un problème est survenu sur votre photo lors de l\'enregistrement!');

                            return $this->redirectToRoute('admin_user_edit', []);
                        }
                    }
                }
            }
            else{
                $fileName='';
            }

            //Permet de rajouter un encodage au mdp
            $encrypted = $encoder->encodePassword($userId, $userId->getPasswordsecu());
            $userId->getPasswordsecu($encrypted);

            $userId->setImageprofil($fileName);
            $entityManager->persist($userId);
            $entityManager->flush();

            $this->addFlash('success', 'Le profil a bien été modifié!');
            return $this->redirectToRoute('user_index',[]);
        }
        return $this->render('admin/user_admin_edit.html.twig',[
            'formAdminEdit' => $form->createView(),
            'formAdminStatus' => $formadmin->createView()
        ]);

    }

    /**
     * @Route("admin/user-delete/{userId}", name="user_admin_delete")
     */
    public function delete(Profilsecu $userId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Profilsecu::class)->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de membre avec l\'ID n°'.$userId.'!'
            );
        }
        $adminUser= $this->getUser()->getId();
        $otherId= $userId->getId();
        $idStatut= $userId->getStatut();

        if ($otherId != $adminUser AND $idStatut == 1) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer ou modifier un autre admin!');
            return $this->redirectToRoute('user_index');
        }

        $userPicture = $entityManager->getRepository(Profilsecu::class)->find($userId)->getImageprofil();
        if( !empty($userPicture))
        {
            //suppression de l'ancienne photo
            $fichierSupp = $this->getParameter('profil_pictures_directory');
            unlink($fichierSupp . $userPicture);
            $fs = new Filesystem();
            $fs->remove($fichierSupp.$userId->getImageprofil());
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Le membre a bien été supprimé!');

        return $this->redirectToRoute('user_index',[]);
    }

    /**
     * @Route("admin/user_add", name="user_admin_add")
     */
    public function connexionInscription(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $user = new Profilsecu();

        $form = $this->createForm(ProfilsecuType::Class, $user, []);
        $form->handleRequest($request);

        $formStatut = $this->createForm(StatusType::Class, $user, []);
        $formStatut->handleRequest($request);

        if( $form->isSubmitted() && !$form->isEmpty() && $form->isValid()) {
            //Permet de rajouter un encodage au mdp
            $encrypted = $encoder->encodePassword($user, $user->getPasswordsecu());
            $user->setPasswordsecu($encrypted);

            if ($user->getImageprofil() != '' || $user->getImageprofil() != null) {
                //ajout d'une photo
                $file = $form->get('imageprofil')->getData();

                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('profil_pictures_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Un problème est survenu sur votre photo lors de l\'enregistrement!');

                    return $this->redirectToRoute('home', []);
                }


            } else {
                $fileName = '';
            }
            $statut = $formStatut->get('statut')->getData();

            $user->setImageprofil($fileName);
            $user->setStatut($statut);

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Le compte a bien été enregistré!');
            return $this->redirectToRoute('home',[]);
        }

        return $this->render('admin/user_admin_add.html.twig', [
            'formAjoutstatut' => $formStatut->createView(),
            'formAjout' => $form->createView(),
        ]);

    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}