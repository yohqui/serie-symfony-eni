<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use ContainerDhh30DI\get_Maker_AutoCommand_MakeVoter_LazyService;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/series", name="serie_")
 */

class SerieController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function list(SerieRepository $serieRepository): Response
    {
        $series = $serieRepository->findBestSeries();
        //$series = $serieRepository->findBy([], ['popularity'=> 'DESC', 'vote' => 'DESC'], 30);
                        // findBy[] equivalent a findAll() mais ici on peut faire un tri

        return $this->render('serie/list.html.twig', [
            "series" => $series
        ]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        if (!$serie )
        {throw $this->createNotFoundException('la série que vous demandez n\'éxiste pas ou plus');}

        return $this->render('serie/details.html.twig', [
            "serie" => $serie
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
        ): Response
    {
        //creation du formulaire :
        $serie = new Serie();
        // ajout de la sate de creation aussitot la série créer car spécifié en en non null dans BDD mais pas présente dans le formulaire
        $serie->setDateCreated(new \DateTime());
        $serieform = $this->createForm(SerieType::class, $serie);

            // dump($serie);
        $serieform->handleRequest($request);
            // dump($serie);

        if ($serieform->isSubmitted() && $serieform->isValid()){
            $entityManager->persist($serie);
            $entityManager->flush();

            //ajout message flash
            $this->addFlash('success', 'Serie successfull added !');
            // redirection
            return $this->redirectToRoute('serie_details',['id'=> $serie->getId()]);
        }

        return $this->render('serie/create.html.twig', ['serieForm'=> $serieform->createView()]);
    }

    /**
     * @Route("/demo", name="em-demo")
     */
    public function demo(EntityManagerInterface $entityManager): Response
    {
        // créer un instance de mon entité
        $serie = new Serie();

        //hydrate toutes les propriétés
        $serie->setName('pif');
        $serie->setBackdrop('dajgj');
        $serie->setPoster('bbbnbn');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstAirDate(new \DateTime("-1 year"));
        $serie->setLastAirDate(new \DateTime("-6 month"));
        $serie->setGenres('drama');
        $serie->setOverview('jjl lklk kjl');
        $serie->setPopularity(123.00);
        $serie->setVote(8.2);
        $serie->setStatus('Canceled');
        $serie->setTmdbId(329432);

        dump($serie);

        //enregister dans la base de données > est appélé dans demo au dessu
        $entityManager->persist($serie);
        $entityManager->flush();

        dump($serie);

        //retirer de la base de données
          //$entityManager->remove($serie);
          //$entityManager->flush();

        //modification d'une entity
        $serie->setGenres('comedy');
        $entityManager->flush();

        return $this->render('serie/create.html.twig');
    }

    /**
     * @Route ("/delete/{id}", name="delete")
     */

    public function delete ($id, SerieRepository $serieRepository, EntityManagerInterface $entityManager)
    {
        $serie = $serieRepository->find($id);
        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->redirectToRoute('main_home');

    }





}
