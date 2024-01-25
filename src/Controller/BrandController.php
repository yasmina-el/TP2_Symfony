<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class BrandController extends AbstractController
{
    #[Route('/brand', name: 'app_brand', methods:['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Retourne toutes les marques.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Brand::class, groups: ['pen:read']))
        )
    )]
    #[OA\Tag(name: 'Marque')]
    #[Security(name: 'Bearer')]
    public function index(BrandRepository $brandRepository): JsonResponse
    {

        $brand = $brandRepository->findAll();

        return $this->json([
            'brand' => $brand,
        ], context: [
            'groups' => ['brand:read', 'pen:read']
        ]);
    }


    #[Route('/brand/{id}', name: 'app_brand_get', methods: ['GET'])]
    #[OA\Tag(name: 'Marque')]
    public function get(Brand $brand): JsonResponse
    {
        return $this->json($brand, context: [
            'groups' => ['pen:read','brand:read'],
        ]);
    }


    #[Route('/brands', name: 'app_brand_add', methods: ['POST'])]
    #[OA\Tag(name: 'Marque')]
    public function add(
        Request $request,
        EntityManagerInterface $em,
    ): JsonResponse {
        try {
            // On recupère les données du corps de la requête
            // Que l'on transforme ensuite en tableau associatif
            $data = json_decode($request->getContent(), true);

            $brand = new Brand();
            $brand->setName($data['name']);
                      
            $em->persist($brand);
            $em->flush();

            return $this->json($brand, context: [
                'groups' => ['pen:read','brand:read'],
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    #[Route('/brands/{id}', name: 'app_brand_update', methods: ['PUT', 'PATCH'])]
    #[OA\Tag(name: 'Marque')]
    public function update(
        Brand $brand,
        Request $request,
        EntityManagerInterface $em,
    ): JsonResponse {
        try {
            // On recupère les données du corps de la requête
            // Que l'on transforme ensuite en tableau associatif
            $data = json_decode($request->getContent(), true);

            $brand->setName($data['name']);

            $em->persist($brand);
            $em->flush();

            return $this->json($brand, context: [
                'groups' => ['pen:read','brand:read'],
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    #[Route('/brand/{id}', name: 'app_brand_delete', methods: ['DELETE'])]
    #[OA\Tag(name: 'Marque')]
    public function delete( Brand $brand, EntityManagerInterface $em): JsonResponse {
     
            $em->remove($brand);
            $em->flush();
        return $this->json([
            'code'=>'200',
            'message'=>'marque supprimer'
        ]);

        }



}
