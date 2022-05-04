<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Entity\Classes;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/teacher")
 */ 
class TeacherController extends AbstractController
{
    /**
     * @Route("/", name="teacher_index")
     */
    public function teacherIndex(ManagerRegistry $registry)
    {
        $teachers = $registry->getRepository(Teacher::class)->findAll();
        $classess = $registry->getRepository(Classes::class)->findAll();
        return $this->render('teacher/index.html.twig', [
            'teachers' => $teachers,
            'classess' => $classess,
        ]);
    }

    /**
     * @Route("add", name="teacher_add")
     */
    public function teacherAdd(ManagerRegistry $registry, Request $request){
        $classess = $registry->getRepository(Classes::class)->findAll();
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            $manager->persist($teacher);
            $manager->flush();
            $this->addFlash('Success', 'teacher added successfully');
            return $this->redirectToRoute('teacher_index');
        }
        return $this->renderForm('teacher/add.html.twig', [
            'teacherForm' => $form,
            'classes' => $classess,
        ]);
    }

    /**
     * @Route("detail/{id}", name="teacher_detail")
     */
    public function teacherDetail(ManagerRegistry $registry, $id){
        $teacher = $registry->getRepository(Teacher::class)->find($id);
        $classess = $registry->getRepository(Classes::class)->findAll();
        if ($teacher == null){
            $this ->addFlash('Error', 'teacher not found');
            return $this->redirectToRoute('teacher_index');
        }
        return $this->render('teacher/detail.html.twig', [
            'teacher' => $teacher,
            'classess' => $classess,
        ]);
    }

    /**
     * @Route("edit/{id}", name="teacher_edit")
     */
    public function teacherEdit(ManagerRegistry $registry, Request $request, $id){
        $teacher = $registry->getRepository(Teacher::class)->find($id);
        $classess = $registry->getRepository(Classes::class)->findAll();
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            $manager->persist($teacher);
            $manager->flush();
            $this->addFlash('Success', 'teacher edited successfully');
            return $this->redirectToRoute('teacher_index');
        }
        return $this->renderForm('teacher/edit.html.twig', [
            'teacherForm' => $form,
            'classess' => $classess
        ]);
    } 

    /**
     * @Route("delete/{id}", name="teacher_delete")
     */
    public function teacherDelete(ManagerRegistry $registry, $id){
        $teacher = $registry->getRepository(Teacher::class)->find($id);
        $classess = $registry->getRepository(Classes::class)->findAll();
        if ($teacher == null){
            $this ->addFlash('Error', 'teacher not found');
        }else{
            $manager = $registry->getManager();
            $manager->remove($teacher);
            $manager->flush();
            $this->addFlash('Success', 'teacher deleted successfully');
        }
        return $this->redirectToRoute('teacher_index', [
            'classess' => $classess,
        ]);
    }
}
