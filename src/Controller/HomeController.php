<?php

namespace App\Controller;

use App\Entity\Domaine;


use App\Entity\Profilsecu;
use App\Entity\Solution;
use App\Entity\Virus;
use App\Entity\Interruptions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $doctrine = $this->getDoctrine();

        $domaineRepository = $doctrine->getRepository(Domaine::class);
        $resultatDomaine= $domaineRepository->findAll();

        $solutionRepository = $doctrine->getRepository(Solution::class);
        $resultatSolution= $solutionRepository->findAll();

        $profilsecuRepository = $doctrine->getRepository(Profilsecu::class);
        $resultatsProfilsecu= $profilsecuRepository->findAll();

        $interRepository = $doctrine->getRepository(Interruptions::class)->findHowManyActive();

        $virusRepository = $doctrine->getRepository(Virus::class);
        $resultatsvirus= $virusRepository->findAll();


        return $this->render('home/index.html.twig',[
            'resultatsVirus' => $resultatsvirus,
            'resultatprofilsecu' => $resultatsProfilsecu,
            'resultatsinterruption' => $interRepository,
            'resultatdomaine' => $resultatDomaine,
            'resultatsolution' => $resultatSolution,
        ]);
    }
}