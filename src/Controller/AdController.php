<?php

namespace App\Controller;


use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $adrepository)
    {
        // affichage de tous annonces
        $ads = $adrepository->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }



    /**
     * Permet de creer une annonce
     *
     * @Route("/ads/new",name="ads_create")
     */
    public function create(Request $request,EntityManagerInterface $manager){

        $ad = new Ad();

        $image = new Image();
        $image->setUrl('https://placeimg.com/640/480/arch')
              ->setCaption('Titre 1');

        $ad->addImage($image);

        $form = $this->createForm(AdType::class,$ad);


        // récupération des données et des gestion du formulaire de création d'annonce
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enrégistrée"
            );

            return $this->redirectToRoute('ads_show',[
                'slug'=>$ad->getSlug()
            ]);
        }

        return $this->render('ad/new.html.twig',['form'=>$form->createView()]);
    }


    /**
     * Afficher une annonce
     *
     * @Route("/ads/{slug}", name="ads_show")
     *
     * @return Response
     */
    public function show(Ad $ad){
        // Recuperation de l'annonce grâce au slug
        //$ad = $repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig',['ad'=>$ad]);
    }

}
