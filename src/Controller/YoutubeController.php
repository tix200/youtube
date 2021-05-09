<?php

namespace App\Controller;

use App\Entity\Youtube;
use App\Form\YoutubeType;
use App\Repository\YoutubeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class YoutubeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request , EntityManagerInterface $em , YoutubeRepository $youtubeRepository): Response
    {

        $youtube= new Youtube ;
        $form = $this->createForm(YoutubeType::class,$youtube );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $youtube = $form->getData();
 
            $em->persist($youtube);
            $em->flush();
 
            return $this->redirectToRoute('app_home');
        }

        return $this->render('youtube/index.html.twig', [
            'form' =>  $form->createView(),
            'youtubes' => $youtubeRepository->findAll(),
        ]);
    }
}
