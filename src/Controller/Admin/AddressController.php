<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route("/admin/address", name: 'admin.address.')]
#[IsGranted('ROLE_ADMIN')]
class AddressController extends AbstractController {

    
    #[Route(name: 'index')]
    public function index(AddressRepository $repository){
        return $this->render('admin/address/index.html.twig', [
            'addresses' => $repository->findAll()
        ]);
    }

    #[Route("/create", name: 'create')]
    public function create(Request $request, EntityManagerInterface $em){
        $Address = new Address();
        $form = $this->createForm(AddressType::class,$Address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($Address);
            $em->flush();
            $this->addFlash('success', "L'adresse a bien été  créée");
            return $this->redirectToRoute('admin.address.index');
          
        }

        return $this->render('admin/address/create.html.twig', [
            'form'=>$form
        ]);

    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Address $address, Request $request, EntityManagerInterface $em){

        $form = $this->createForm(AddressType::class,$address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', "L' adresse a bien été modifiée");
            return $this->redirectToRoute('admin.address.index');
         
        }

        return $this->render('admin/address/edit.html.twig', [
            'address'=>$address,
            'form'=>$form
        ]);
        
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Address $address, EntityManagerInterface $em)
    {
        $em->remove($address);
        $em->flush();
        $this->addFlash('success', "L' adresse bien été  suppriméée");
        return $this->redirectToRoute('admin.address.index');
       
       }  
      
    }

