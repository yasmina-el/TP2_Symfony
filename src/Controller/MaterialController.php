<?php

namespace App\Controller;

use App\Entity\Material;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]

class MaterialController extends AbstractController
{
    #[Route('/material', name: 'app_material', methods:['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Retourne tous les matériaux.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Material::class, groups: ['pen:read','material:read']))
        )
    )]
    #[OA\Tag(name: 'Materiel')]
    #[Security(name: 'Bearer')]
    public function index(MaterialRepository $materialRepository): JsonResponse
    {

        $material = $materialRepository->findAll();

        return $this->json([
            'material' => $material,
        ], context: [
            'groups' => ['material:read', 'pen:read']
        ]);
    }


    #[Route('/material/{id}', name: 'app_material_get', methods: ['GET'])]
    #[OA\Tag(name: 'Materiel')]
    public function get(Material $material): JsonResponse
    {
        return $this->json($material, context: [
            'groups' => ['pen:read','material:read'],
        ]);
    }


    #[Route('/materials', name: 'app_material_add', methods: ['POST'])]
    #[OA\Tag(name: 'Materiel')]
    public function add(
        Request $request,
        EntityManagerInterface $em,
    ): JsonResponse {
        try {
            // On recupère les données du corps de la requête
            // Que l'on transforme ensuite en tableau associatif
            $data = json_decode($request->getContent(), true);

            $material = new Material();
            $material->setName($data['name']);
                      
            $em->persist($material);
            $em->flush();

            return $this->json($material, context: [
                'groups' => ['pen:read','material:read'],
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    #[Route('/materials/{id}', name: 'app_material_update', methods: ['PUT', 'PATCH'])]
    #[OA\Tag(name: 'Materiel')]
    public function update(
        Material $material,
        Request $request,
        EntityManagerInterface $em,
    ): JsonResponse {
        try {
            // On recupère les données du corps de la requête
            // Que l'on transforme ensuite en tableau associatif
            $data = json_decode($request->getContent(), true);

            $material->setName($data['name']);

            $em->persist($material);
            $em->flush();

            return $this->json($material, context: [
                'groups' => ['pen:read','material:read'],
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    #[Route('/material/{id}', name: 'app_material_delete', methods: ['DELETE'])]
    #[OA\Tag(name: 'Materiel')]
    public function delete( Material $material, EntityManagerInterface $em): JsonResponse {
     
            $em->remove($material);
            $em->flush();
        return $this->json([
            'code'=>'200',
            'message'=>'marque supprimer'
        ]);

        }



}
