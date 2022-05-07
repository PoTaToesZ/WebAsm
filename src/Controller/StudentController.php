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

    /** 
     * @Route("asc/", name="student_asc")
     */
    public function studentAsc(ManagerRegistry $registry){
        $students = $registry->getRepository(Student::class)->findBy([], ['age' => 'ASC']);
        $majors = $registry->getRepository(Major::class)->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'majors' => $majors,
        ]);
}
    
    /** 
     *@Route("desc/", name="student_desc")
     */
    public function studentDesc(ManagerRegistry $registry){
        $students = $registry->getRepository(Student::class)->findBy([], ['age' => 'DESC']);
        $majors = $registry->getRepository(Major::class)->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'majors' => $majors,
        ]);
    }

    /**
     * @Route("search/", name="student_search")
     */
    public function searchStudent(ManagerRegistry $registry, Request $request, StudentRepository $studentRepository){
        $students = $registry->getRepository(Major::class)->findAll();
        $keyword = $request->get('keyword');
        $students = $studentRepository->searchStudent($keyword);
        return $this->render('student/index.html.twig',[
            'students' => $students,
            'majors' => $students,
        ]);
    }
    /** 
     * @Route("filter/{id}", name="student_filter")
     */
    public function filterStudent(ManagerRegistry $registry, $id){
        $students = $registry->getRepository(Student::class)->findAll();
        $majors = $registry->getRepository(Major::class)->findAll();
        $students = $registry->getRepository(Student::class)->findBy(['major' => $id]);
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'majors' => $majors,
        ]);
    }
    /**
     * @Route("name/asc", name="student_name_asc")
     */
    public function studentNameAsc(ManagerRegistry $registry){
        $students = $registry->getRepository(Student::class)->findBy([], ['name' => 'ASC']);
        $majors = $registry->getRepository(Major::class)->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'majors' => $majors,
        ]);
    }
    /** 
     * @Route("name/desc", name="student_name_desc")
     */

    public function studentNameDesc(ManagerRegistry $registry){
        $students = $registry->getRepository(Student::class)->findBy([], ['name' => 'DESC']);
        $majors = $registry->getRepository(Major::class)->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'majors' => $majors,
        ]);
    }
    //Check if major quantity is enough for 3 student
    //If major quantity <3 cannot add more student
    /**
     * @Route("major/{id}", name="student_major")
     */
    public function studentMajor(ManagerRegistry $registry, $id){
        $students = $registry->getRepository(Student::class)->findAll();
        $majors = $registry->getRepository(Major::class)->findAll();
        $students = $registry->getRepository(Student::class)->findBy(['major' => $id]);
        $major = $registry->getRepository(Major::class)->find($id);
        if ($major->getQuantity() < 3){
            $this->addFlash('Error', 'Major quantity is not enough');
            return $this->redirectToRoute('student_index');
        }
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'majors' => $majors,
        ]);
    }
    
}