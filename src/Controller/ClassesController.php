<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Form\ClassesType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/classes")
 */ 
class ClassesController extends AbstractController
{
    /**
     * @Route("/", name="classes_index")
     */
    public function classesIndex(ManagerRegistry $registry)
    {
        $classess = $registry->getRepository(Classes::class)->findAll();
        return $this->render('classes/index.html.twig', [
            'classess' => $classess,
        ]);
    }

    /**
     * @Route("add", name="classes_add")
     */
    public function classesAdd(ManagerRegistry $registry, Request $request){
        $classes = new Classes();
        $form = $this->createForm(ClassesType::class, $classes);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            $manager->persist($classes);
            $manager->flush();
            $this->addFlash('Success', 'classes added successfully');
            return $this->redirectToRoute('classes_index');
        }
        return $this->renderForm('classes/add.html.twig', [
            'classesForm' => $form,
        ]);
    }

    /**
     * @Route("detail/{id}", name="classes_detail")
     */
    public function classesDetail(ManagerRegistry $registry, $id){
        $classes = $registry->getRepository(Classes::class)->find($id);
        if ($classes == null){
            $this ->addFlash('Error', 'Classes not found');
            return $this->redirectToRoute('classes_index');
        }
        return $this->render('classes/detail.html.twig', [
            'classes' => $classes,
        ]);
    }

    /**
     * @Route("edit/{id}", name="classes_edit")
     */
    public function classesEdit(ManagerRegistry $registry, Request $request, $id){
        $classes = $registry->getRepository(Classes::class)->find($id);
        $form = $this->createForm(ClassesType::class, $classes);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            $manager->persist($classes);
            $manager->flush();
            $this->addFlash('Success', 'classes edited successfully');
            return $this->redirectToRoute('classes_index');
        }
        return $this->renderForm('classes/edit.html.twig', [
            'classesForm' => $form
        ]);
    } 

    /** 
     * @Route("delete/{id}", name="classes_delete")
    */
    public function classesDelete(ManagerRegistry $registry, $id){
        $classes = $registry->getRepository(Classes::class)->find($id);
        if ($classes == null){
            $this ->addFlash('Error', 'classes not found');
            return $this->redirectToRoute('classes_index');
        }
        $manager = $registry->getManager();
        $manager->remove($classes);
        $manager->flush();
        $this->addFlash('Success', 'classes deleted successfully');
        return $this->redirectToRoute('classes_index');
    }
}
