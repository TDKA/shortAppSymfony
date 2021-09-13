<?php

namespace App\Controller;

use App\Entity\Short;
use App\Repository\ShortRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * 
 * @Route("/api")
 */
class ShortController extends AbstractController
{
    /**
     * @Route("/short", name="short", methods={"GET"})
     */
    public function index(ShortRepository $repo): Response
    {
        $shorts = $repo->findAll();

        return $this->json(
            $shorts,
            200
        );
    }
    /**
     * @Route("/short/{id}", name="shortShow")
     */
    public function show(Short $short): Response
    {
        return $this->json($short);
    }
    /**
     * @Route("/create", name="shortCreate", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $manager, SerializerInterface $serializer): Response
    {
        $data = $request->getContent();

        $short = $serializer->deserialize($data, Short::class, 'json');

        $manager->persist($short);
        $manager->flush();

        return $this->json($short);
    }
    /**
     * @Route("/delete/{id}", name="shortDelete", methods={"DELETE"})
     */
    public function delete(Short $short, EntityManagerInterface $manager): Response
    {
        $manager->remove($short);
        $manager->flush();

        return $this->json("Delete was successfull");
    }
}
