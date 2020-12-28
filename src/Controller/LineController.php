<?php

namespace App\Controller;

use App\Entity\Line;
use App\Form\LineType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LineController extends AbstractController
{
    /**
     * @Route("/line/new", name="line_new", methods={"GET","POST"})
     */
    public function new(): Response
    {
        $line = new Line();
        
        $form = $this->createForm(LineType::class, $line);
        
        return $this->render('line/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
