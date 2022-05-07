<?php

namespace App\Controller;

use App\Entity\Major;
use App\Form\MajorType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/major")
 */ 
class MajorController extends AbstractController
{
    /**
     * @Route("/", name="major_index")
     */
    public function majorIndex(ManagerRegistry $registry)
    {
        $majors = $registry->getRepository(Major::class)->findAll();
        return $this->render('major/index.html.twig', [
            'majors' => $majors,
        ]);
    }

    /**
     * @Route("add", name="major_add")
     */
    public function majorAdd(ManagerRegistry $registry, Request $request){
        $major = new major();
        $form = $this->createForm(MajorType::class, $major);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            $manager->persist($major);
            $manager->flush();
            $this->addFlash('Success', 'Major added successfully');
            return $this->redirectToRoute('major_index');
        }
        return $this->renderForm('major/add.html.twig', [
            'majorForm' => $form,
        ]);
    }

    /**
     * @Route("detail/{id}", name="major_detail")
     */
    public function majorDetail(ManagerRegistry $registry, $id){
        $major = $registry->getRepository(Major::class)->find($id);
        if ($major == null){
            $this ->addFlash('Error', 'Major not found');
            return $this->redirectToRoute('major_index');
        }
        return $this->render('major/detail.html.twig', [
            'major' => $major,
        ]);
    }

    /**
     * @Route("edit/{id}", name="major_edit")
     */
    public function majorEdit(ManagerRegistry $registry, Request $request, $id){
        $major = $registry->getRepository(Major::class)->find($id);
        $form = $this->createForm(MajorType::class, $major);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $registry->getManager();
            $manager->persist($major);
            $manager->flush();
            $this->addFlash('Success', 'Major edited successfully');
            return $this->redirectToRoute('major_index');
        }
        return $this->renderForm('major/edit.html.twig', [
            'majorForm' => $form
        ]);
    } 

    /**
     * @Route("delete/{id}", name="major_delete")
     */
    public function majorDelete (ManagerRegistry $registry, $id) {
        $major = $registry->getRepository(Major::class)->find($id);
        if ($major == null) {
            $this->addFlash("Error", "Major not found !");
        }
        else if (count($major->getStudents()) >= 1) {
            $this->addFlash("Error", "Can not delete this major !");
        }
        else {
            $manager = $registry->getManager();
            $manager->remove($major);
            $manager->flush();
            $this->addFlash("Success", "Delete major succeed !");
        }
        return $this->redirectToRoute("major_index");
    }
}