<?php


namespace App\Controller;

use App\Entity\Solution;
use App\Entity\Virus;
use App\Form\VirusType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VirusController extends AbstractController
{

    /**
     * @Route("admin/virus/add", name="virus_add")
     */
    public function indexVirusAdd(Request $request)
    {
        $virus = new Virus();

        $form = $this->createForm(VirusType::class, $virus ,[]);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {


            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($virus);
            $entityManager->flush();

            $this->addFlash('success', 'Ce virus a bien été enregistré!');
            return $this->redirectToRoute('home',[]);
        }

        return $this->render(
            'virus/virus_add.html.twig',
            [
                'formInterruptions' => $form->createView(),
            ]);
    }

    /**
     * @Route("admin/virus", name="virus_index")
     */
    public function indexVirus()
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Virus::class);
        $resultatedit= $userRepository->findAll();

        return $this->render('admin/index_virus.html.twig', ['resultatedit' => $resultatedit]);
    }


    /**
     * @Route("admin/virus-edit/{virusId}", name="virus_admin_edit")
     */
    public function adminEditvirus(Request $request, Virus $virusId)
    {
        $form = $this->createForm(VirusType::class, $virusId, []);
        $form->handleRequest($request);

        $doctrine = $this->getDoctrine();

        $solutionRepository = $doctrine->getRepository(Solution::class);
        $resultatedit= $solutionRepository->findBy(['id' =>$virusId]);

        if( $form->isSubmitted() && $form->isValid())
        {

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($virusId);
            $entityManager->flush();

            $this->addFlash('success', 'Le virus a bien été modifié!');
            return $this->redirectToRoute('user_index',[]);
        }
        return $this->render('admin/virus_admin_edit.html.twig',[
            'formVirusEdit' => $form->createView(),
            'resultatedit' => $resultatedit,
        ]);

    }

    /**
     * @Route("admin/virus-delete/{virusId}", name="virus_admin_delete")
     */
    public function delete(Virus $virusId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $virus = $entityManager->getRepository(virus::class)->find($virusId);

        if (!$virus) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de membre avec l\'ID n°'.$virusId.'!'
            );
        }

        $entityManager->remove($virus);
        $entityManager->flush();

        $this->addFlash('success', 'Le virus a bien été supprimé!');

        return $this->redirectToRoute('virus_index',[]);
    }

}