<?php

namespace App\Controller;

use App\DTO\ClientSearch; // Importez votre DTO
use App\Entity\Client;
use App\Form\ClientSearchType;
use App\Form\ClientType; // Assurez-vous que cette ligne est présente
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_client')]
public function index(Request $request): Response
{
    $clientSearch = new ClientSearch();
    $form = $this->createForm(ClientSearchType::class, $clientSearch);
    $form->handleRequest($request);
    
    // Récupérer tous les clients de la base de données
    $clients = $this->entityManager->getRepository(Client::class)->findAll();
    
    // Déboguer : Vérifiez si des clients sont récupérés
    
    return $this->render('client/index.html.twig', [
        'controller_name' => 'ClientController',
        'clients' => $clients,
        'form' => $form->createView(),
    ]);
}
}
