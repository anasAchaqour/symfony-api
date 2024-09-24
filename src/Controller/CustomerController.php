<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CustomerController extends AbstractController
{

    public function index(EntityManagerInterface $entityManager): Response
    {
        $customers = $entityManager->getRepository(Customer::class)->findAll();
        return $this->json($customers);
    }

    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        /*$data = json_decode($request->getContent(), true);
        $customer = new Customer();
        $customer->setName($data['name']);
        $customer->setEmail($data['email']);

        $entityManager->persist($customer);
        $entityManager->flush();

        return $this->json($customer, Response::HTTP_CREATED);*/
        


        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->json($customer, Response::HTTP_CREATED);
        }
        // If the form is not valid, return validation errors
        return $this->json($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }
}
