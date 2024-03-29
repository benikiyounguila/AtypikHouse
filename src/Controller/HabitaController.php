<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Form\HabitatType;
use App\Repository\HabitatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class HabitaController extends AbstractController
{

    

    #[Route('/habitat', name: 'habitat.index')]
    //A public function index(Request $request, EntityManagerInterface $em): Response
      public function index(Request $request, HabitatRepository $repository): Response
     {

        $habitats = $repository->findWithPriceLowerThan(3000); 
        //dd($em->getRepository(Habitat::class));
        //dd($repository->findTotalPrice()); 
       //A $habitats = $em->getRepository(Habitat::class)->findWithPriceLowerThan(150); 


       /*  $em->remove($habitats[3]);
        $em->flush(); */
        
       
     /* 
        $habitat = new Habitat();
        $habitat->setTitle('Cabane flottante')
                ->setCapacity(8.00)
                ->setEnVente(0)
                ->setFile('')
                ->setNombreDeCouchage(2)
                ->setSlug('Cabane-flottante')
                ->setContent('Surplombant un lac paisible, cette cabane flottante offre calme et sérénité.')
                ->setPrice(150.00)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

         $em->persist($habitat);
         $em->flush(); */

                 return $this->render('habita/index.html.twig', [
            'habitats'=>$habitats
        ]);
    }
    
    #[Route('/habitat/{slug}-{id}', name: 'habitat.show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+' ])]
    public function show(Request $request, string $slug, int $id, HabitatRepository $repository): Response
     {
        $habitat=$repository->find($id);

        if ($habitat->getSlug() != $slug) {

            return $this->redirectToRoute('habitat.show', [ 'slug' => $habitat->getSlug(),'id' => $habitat->getId()]);
        }
        //dd($habitat);

        return $this->render('habita/show.html.twig', [
            'habitat' => $habitat
        ]);
       
    }

    #[Route('/habitats/{id}/edit', name: 'habitat.edit', methods: ['GET', 'POST'])]
    public function edit(Habitat $habitat, Request $request, EntityManagerInterface $em){

       $form = $this->createForm(HabitatType::class, $habitat);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()) {
       // $habitat->setUpdatedAt(new \DateTimeImmutable());
        $em->flush();
        $this->addFlash('success', "L' habitat a été bien modifiée");
        return $this->redirectToRoute('habitat.index');
       }

        return $this->render('habita/edit.html.twig', [
            'habitat'=>$habitat,
            'form'=>$form
        ]);
    }

    #[Route('/habitats/create', name: 'habitat.create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
       $habitat = new Habitat(); 
       $form = $this->createForm(HabitatType::class, $habitat);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()) {
        //$habitat->setCreatedAt(new \DateTimeImmutable());
       // $habitat->setUpdatedAt(new \DateTimeImmutable());
        $em->persist($habitat);
        $em->flush();
        $this->addFlash('success', "L' habitat a été bien créée");
        return $this->redirectToRoute('habitat.index'); 
       }
        return $this->render('habita/create.html.twig', [
            'form'=>$form
        ]);
    }


    #[Route('/habitats/{id}/delete', name: 'habitat.delete', methods:['DELETE'])]
    public function remove(Habitat $habitat, EntityManagerInterface $em)
    {
        $em->remove($habitat);
       // $em->persist($habitat);
        $em->flush();
        $this->addFlash('success', "L' habitat a été bien suppriméée");
        return $this->redirectToRoute('habitat.index');
       }
      
    }

