<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/new", name="category_new", methods={"GET","POST"})
     */
    public function new(): Response
    {
        $category = new Category();
        
        $form = $this->createForm(CategoryType::class, $category);
        
        return $this->render('category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
