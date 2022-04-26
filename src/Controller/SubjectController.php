<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/subject")
 */ 
class SubjectController extends AbstractController
{
    /**
     * @Route("/", name="subject_index")
     */
    public function subjectIndex(ManagerRegistry $registry)
    {
        $subjects = $registry->getRepository(Subject::class)->findAll();
        return $this->render('subject/index.html.twig', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * @Route("detail/{id}", name="subject_detail")
     */
    public function subjectDetail(ManagerRegistry $registry, $id){
        $subject = $registry->getRepository(Subject::class)->find($id);
        if ($subject == null){
            $this ->addFlash('Error', 'Subject not found');
            return $this->redirectToRoute('subject_index');
        }
        return $this->render('subject/detail.html.twig', [
            'subject' => $subject,
        ]);
    }

    /**
     * @Route("add", name="subject_add")
     */
    public function subjectAdd(ManagerRegistry $registry, Request $request){
        $subject = new subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            $manager->persist($subject);
            $manager->flush();
            $this->addFlash('Success', 'Subject added successfully');
            return $this->redirectToRoute('subject_index');
        }
        return $this->renderForm('subject/add.html.twig', [
            'subjectForm' => $form,
        ]);
    }
    /**
     * @Route("delete/{id}", name="subject_delete")
     */
    public function subjectDelete(ManagerRegistry $registry, $id){
        $subject = $registry->getRepository(Subject::class)->find($id);
        if ($subject == null){
            $this ->addFlash('Error', 'Subject not found');
        }else if (count($subject->getStudent()) >= 1){
            $this ->addFlash('Error', 'Can not delete!');
        }
        {
            $manager = $registry->getManager();
            $manager->remove($subject);
            $manager->flush();
            $this->addFlash('Success', 'Subject deleted successfully');
        }
        return $this->redirectToRoute('subject_index');
    }

    /**
     * @Route("edit/{id}", name="subject_edit")
     */
    public function subjectEdit(ManagerRegistry $registry, Request $request, $id){
        $subject = $registry->getRepository(Subject::class)->find($id);
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            $manager->persist($subject);
            $manager->flush();
            $this->addFlash('Success', 'Subject edited successfully');
            return $this->redirectToRoute('subject_index');
        }
        return $this->renderForm('subject/edit.html.twig', [
            'subjectForm' => $form
        ]);
    }  
}
