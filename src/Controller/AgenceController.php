<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Form\AgenceFormType;
use App\Repository\AgenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AgenceController extends AbstractController{
    #[Route('/agence/list', name: 'app_agence' , methods:['GET'])]
    public function index(AgenceRepository $agence, Request $request,PaginatorInterface $paginator): Response
    {
        $searchNumero = $request->query->get('search_numero', '');
        $searchTelephone = $request->query->get('search_telephone', '');
    
        $agencess = $agence->findBynumTel($searchNumero, $searchTelephone);
    
        $agences = $paginator->paginate(
            $agencess, 
            $request->query->getInt('page', 1), 
            2 /* limit per page */
        );
    
        return $this->render('agence/index.html.twig', [
            'controller_name' => 'AgenceController',
            'agences' => $agences,
        ]);
    }
    
       
    #[Route('/agence/add', name: 'app_agence_add', methods:['GET', 'POST'])]
    public function add(AgenceRepository $agence,Request $request ,EntityManagerInterface $manager): Response
    {


        $classe = new Agence();
        $form=$this->createForm(AgenceFormType::class, $classe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $classe= $form->getData();
            $manager->persist($classe);
            $manager->flush();
            $this->addFlash('success', 'Agence ajoutée avec succès');
            return $this->redirectToRoute("app_agence");
    
            
        }
        return $this->render('agence/add.html.twig', [
            'controller_name' => 'ClasseController',
            'form' => $form->createView(),
        ]);
       
    }


}
