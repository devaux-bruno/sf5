<?php


namespace App\Controller;


use App\Entity\Interruptions;
use App\Entity\Solution;
use App\Form\SolutionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SolutionController extends AbstractController
{
    /**
     * @Route("admin/solution", name="solution_index")
     */
    public function indexSolution()
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Solution::class);
        $resultatedit= $userRepository->findAll();

        return $this->render('admin/index_solution.html.twig', ['resultatedit' => $resultatedit]);
    }

    /**
     * @Route("admin/solutions/{solutionId}", name="solution_add")
     */
    public function indexAddSolution(Interruptions $solutionId, Request $request)
    {
        $solution = new Solution();

        $form = $this->createForm(SolutionType::class, $solution ,[]);
        $form->handleRequest($request);

        $idinter = $solutionId->getId();

        if( $form->isSubmitted() && $form->isValid())
        {

            $solution->setIdInter($idinter);
            $solutionId->setActive('0');
            $solutionId->setStampMaj(new \DateTime());
            $solutionId->setStampEnd(new \DateTime());
            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($solutionId);
            $entityManager->persist($solution);
            $entityManager->flush();

            $this->addFlash('success', 'Votre solution a bien été envoyée!');
            return $this->redirectToRoute('home',[]);
        }

        return $this->render(
            'solution/index.html.twig',
            [
                'formInterruptions' => $form->createView(),
            ]);
    }


    /**
     * @Route("admin/solution-edit/{solutionId}", name="solution_admin_edit")
     */
    public function adminEditsolution(Request $request, Solution $solutionId)
    {
        $form = $this->createForm(SolutionType::class, $solutionId, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($solutionId);
            $entityManager->flush();

            $this->addFlash('success', 'La solution a bien été modifiée!');
            return $this->redirectToRoute('domaine_index',[]);
        }
        return $this->render('admin/domaine_admin_edit.html.twig',[
            'formDomaineEdit' => $form->createView(),
        ]);

    }

    /**
     * @Route("admin/solution-delete/{solutionId}", name="solution_admin_delete")
     */
    public function deletesolution(Solution $solutionId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $solution = $entityManager->getRepository(Solution::class)->find($solutionId);

        if (!$solution) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de membre avec l\'ID n°'.$solutionId.'!'
            );
        }

        $entityManager->remove($solution);
        $entityManager->flush();

        $this->addFlash('success', 'La solution a bien été supprimé!');

        return $this->redirectToRoute('solution_index',[]);
    }


}