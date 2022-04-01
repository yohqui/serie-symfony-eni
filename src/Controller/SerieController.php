<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route("/series", name="serie_list")
     */
    public function list(): Response
    {
        //todo: aller chercher les series en bdd
        return $this->render('serie/list.html.twig', [

        ]);
    }

    /**
    * @Route("/series/details/{id}", name="serie_details")
    */
    public function details(int $id): Response
    {
        //todo: aller chercher la serie en bdd
        return $this->render('serie/details.html.twig', [

        ]);



    }
}
