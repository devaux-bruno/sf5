<?php


namespace App\Controller;


use App\Entity\Domaine;
use App\Form\DomaineType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DomaineController extends AbstractController
{

    /**
     * @Route("admin/domaine", name="domaine_index")
     */
    public function indexDomaine()
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Domaine::class);
        $resultatedit= $userRepository->findAll();

        return $this->render('admin/index_domaine.html.twig', ['resultatedit' => $resultatedit]);
    }

    /**
     * @Route("admin/domaine-add}", name="domaine_add")
     */
    public function adminDomaineAdd(Request $request)
    {
        $domaine= new Domaine();

        $form = $this->createForm(DomaineType::class, $domaine, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($domaine);
            $entityManager->flush();

            $this->addFlash('success', 'Le Domaine a bien été ajouté!');
            return $this->redirectToRoute('domaine_index',[]);
        }
        return $this->render('admin/domaine_add.html.twig',[
            'formDomaineEdit' => $form->createView(),
        ]);

    }

    /**
     * @Route("admin/domaine-edit/{domaineId}", name="domaine_admin_edit")
     */
    public function adminEditDomaine(Request $request, Domaine $domaineId)
    {
        $form = $this->createForm(DomaineType::class, $domaineId, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($domaineId);
            $entityManager->flush();

            $this->addFlash('success', 'Le Domaine a bien été modifié!');
            return $this->redirectToRoute('domaine_index',[]);
        }
        return $this->render('admin/domaine_admin_edit.html.twig',[
            'formDomaineEdit' => $form->createView(),
        ]);

    }

    /**
     * @Route("admin/domaine-delete/{domaineId}", name="domaine_admin_delete")
     */
    public function deleteDomaine(Domaine $domaineId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $domaine = $entityManager->getRepository(Domaine::class)->find($domaineId);

        if (!$domaine) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de membre avec l\'ID n°'.$domaineId.'!'
            );
        }

        $entityManager->remove($domaine);
        $entityManager->flush();

        $this->addFlash('success', 'Le domaine a bien été supprimé!');

        return $this->redirectToRoute('domaine_index',[]);
    }
    
}