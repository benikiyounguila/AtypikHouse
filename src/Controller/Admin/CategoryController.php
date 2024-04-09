<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route("/admin/category", name: 'admin.category.')]
#[IsGranted('ROLE_USER')]
class CategoryController extends AbstractController {

    
    #[Route(name: 'index')]
    public function index(CategoryRepository $repository){
        return $this->render('admin/category/index.html.twig', [
            'categories' => $repository->findAll()
        ]);
    }

    #[Route("/create", name: 'create')]
    public function create(Request $request, EntityManagerInterface $em){
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', "La catégorie a bien été  créée");
            return $this->redirectToRoute('admin.category.index');
          
        }

        return $this->render('admin/category/create.html.twig', [
            'form'=>$form
        ]);

    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em){

        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', "La catégorie a bien été modifiée");
            return $this->redirectToRoute('admin.category.index');
         
        }

        return $this->render('admin/category/edit.html.twig', [
            'category'=>$category,
            'form'=>$form
        ]);
        
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Category $category, EntityManagerInterface $em)
    {
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', "La catégorie bien été  suppriméée");
        return $this->redirectToRoute('admin.category.index');
        // if ($request->isMethod('DELETE')) {
        //     $em->remove($category);
        //     $em->flush();
        //     $this->addFlash('success', "La catégorie a bien été supprimée");
        //     return $this->redirectToRoute('admin.category.index');
        // }
       }

    
    
      
    }

