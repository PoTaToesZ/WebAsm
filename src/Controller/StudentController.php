<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Major;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/student")
 */ 
class StudentController extends AbstractController
{
    /**
     * @Route("/", name="student_index")
     */
    public function studentIndex(ManagerRegistry $registry)
    {
        $students = $registry->getRepository(Student::class)->findAll();
        $majors = $registry->getRepository(Major::class)->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'majors' => $majors,
        ]);
    }

    /**
     * @Route("add", name="student_add")
     */
    public function studentAdd(ManagerRegistry $registry, Request $request){
        $majors = $registry->getRepository(Major::class)->findAll();
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash('Success', 'Student added successfully');
            return $this->redirectToRoute('student_index');
        }
        return $this->renderForm('student/add.html.twig', [
            'studentForm' => $form,
            'majors' => $majors
        ]);
    }

    /**
     * @Route("detail/{id}", name="student_detail")
     */
    public function studentDetail(ManagerRegistry $registry, $id){
        $student = $registry->getRepository(Student::class)->find($id);
        $majors = $registry->getRepository(Major::class)->findAll();
        if ($student == null){
            $this ->addFlash('Error', 'Student not found');
            return $this->redirectToRoute('student_index');
        }
        return $this->render('student/detail.html.twig', [
            'student' => $student,
            'majors' => $majors,
        ]);
    }

    /**
     * @Route("edit/{id}", name="student_edit")
     */
    public function studentEdit(ManagerRegistry $registry, Request $request, $id){
        $student = $registry->getRepository(Student::class)->find($id);
        $majors = $registry->getRepository(Major::class)->findAll();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash('Success', 'Student edited successfully');
            return $this->redirectToRoute('student_index');
        }
        return $this->renderForm('student/edit.html.twig', [
            'studentForm' => $form,
            'majors' => $majors
        ]);
    } 

    /**
     * @Route("delete/{id}", name="student_delete")
     */
    public function studentDelete(ManagerRegistry $registry, $id){
        $student = $registry->getRepository(Student::class)->find($id);
        $majors = $registry->getRepository(Major::class)->findAll();
        if ($student == null){
            $this ->addFlash('Error', 'Student not found');
        }else{
            $manager = $registry->getManager();
            $manager->remove($student);
            $manager->flush();
            $this->addFlash('Success', 'Student deleted successfully');
        }
        return $this->redirectToRoute('student_index', [
            'majors' => $majors,
        ]);
    }
}
