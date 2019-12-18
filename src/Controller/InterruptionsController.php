<?php


namespace App\Controller;


use App\Entity\Interruptions;
use App\Form\InterruptionsType;
use App\Form\newPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InterruptionsController extends AbstractController
{

    /**
 * @Route("admin/interruptions", name="interruption_index")
 */
    public function index()
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Interruptions::class);
        $resultatedit= $userRepository->findAll();

        return $this->render(
            'admin/index_interruptions.html.twig',
            [
                'resultatedit' => $resultatedit
            ]);
    }

    /**
 * @Route("interruptions/add", name="interruption_add")
 */
    public function indexAdd(Request $request)
    {

        $incident = new Interruptions();

        $form = $this->createForm(InterruptionsType::class, $incident ,[]);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $incident->setStampMaj(new \DateTime());
            $incident->setStampBegin(new \DateTime());
            $incident->setStampEnd(new \DateTime());
            $incident->setActive('1');

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($incident);
            $entityManager->flush();

            $this->addFlash('success', 'Votre incident a bien été enregistré!');
            return $this->redirectToRoute('home',[]);
        }


        return $this->render(
            'interruptions/interruption_add.html.twig',
            [
                'formInterruptions' => $form->createView(),
            ]);
    }

    /**
     * @Route("admin/interruptions/edit/{id}", name="interruption_edit")
     */
    public function indexEdit(Request $request, Interruptions $id)
    {


        $form = $this->createForm(InterruptionsType::class, $id ,[]);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $id->setStampMaj(new \DateTime());;
            $id->setStampEnd(new \DateTime());
            $id->setActive('1');

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($id);
            $entityManager->flush();

            $this->addFlash('success', 'L\'incident a bien été modifié!');
            return $this->redirectToRoute('home',[]);
        }

        return $this->render(
            'interruptions/interruptions_edit.html.twig',
            [
                'formInterruptions' => $form->createView(),
            ]);
    }

}