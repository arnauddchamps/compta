<?php

namespace App\Controller;

use App\Entity\Line;
use App\Form\LineType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LineController extends AbstractController
{
    /**
     * @Route("/line/new", name="line_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $line = new Line();

        $form = $this->createForm(LineType::class, $line);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($line);
            $manager->flush();

           return $this->redirectToRoute('line_list');
        }

        return $this->render('line/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/lines", name="lines", methods={"GET"})
     */
    public function list(): Response
    {
        $lines = $this->getDoctrine()->getRepository(Line::class)->findAll();

        return $this->render('line/list.html.twig', [
            'lines' => $lines,
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     * 
     * @Route("/line/{id}/edit", name="line_edit")
     *
     */
    public function edit(Line $line, Request $request)
    {
        $form = $this->createForm(LineType::class, $line);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($line);
            $manager->flush();


            $this->addFlash(
                'success',
                "Nouvelle entrée bancaire !"
            );

            return $this->redirectToRoute('line_list');
        }

        return $this->render('line/edit.html.twig', [
            'form' => $form->createView(),
            'line' => $line
        ]);
    }

    /**
     * 
     * @Route("/line/{id}/delete", name="line_delete")
     * 
     */
    public function delete(Line $line) {

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($line);
        $manager->flush();

        $this->addFlash(
            'success', "L'entrée bancaire <strong>{$line->getTitle()}</strong> a bien été supprimée"
        );

        return $this->redirectToRoute("line_list");
    }

}
