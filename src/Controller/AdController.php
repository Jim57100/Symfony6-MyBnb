<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    #[Route('/ads', name: 'ads_index')]
    public function index(AdRepository $repo): Response
    {
        $ads = $repo->findAll();
        return $this->render('ad/ads.html.twig', [
            'ads' => $ads,
        ]);
    }
    
    #[Route('/ads/create', name:'ads_create')]
    public function create(Request $request, EntityManagerInterface $manager) :Response
    {
        $ad = new Ad();
        
        $form = $this->createForm(AdType::class, $ad);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            
            //persister les images en relation avec les Ad
            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }
            
            $manager->persist($ad);
            $manager->flush();
            
            //Message flash
            $this->addFlash('success', "Ad {$ad->getTitle()} created successfully");
            
            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/create.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }
    
    
    //Avec injection de dépendance
    // #[Route('/ads/{slug}', name:'ads_show')]
    // public function show($slug, AdRepository $repo) : Response
    // {
    //     $ad = $repo->findOneBySlug($slug);

    //     return $this->render('ad/show.html.twig', [
    //         'ad' => $ad,
    //     ]);
    // }
        
    //Avec parameter converter
    #[Route('/ads/{slug}', name:'ads_show')]
    public function show(Ad $ad) :Response
    {
        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
        ]);
    }
    
    #[Route('/ads/{slug}/edit', name:'ads_edit')]
    public function edit(Ad $ad, Request $request, EntityManagerInterface $manager) {

        $form = $this->createForm(AdType::class, $ad);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }
            
            $manager->persist($ad);
            $manager->flush();
            
            //Message flash
            $this->addFlash('success', "Ad {$ad->getTitle()} created successfully");
        } 
        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
