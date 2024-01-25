<?php

namespace App\Controller;

use App\Entity\Color;

use App\Repository\ColorRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ColorController extends AbstractController
{
    #[Route('/color', name: 'app_color', methods:['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Retourne toutes les couleurs.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Color::class, groups: ['pen:read','color:read']))
        )
    )]
    #[OA\Tag(name: 'Couleur')]
    #[Security(name: 'Bearer')]
    public function index( ColorRepository $colorRepository): JsonResponse
    {

        $color = $colorRepository->findAll();

        return $this->json([
            'color' => $color,
        ], context: [
            'groups' => ['pen:read','color:read'],
        ]);
    }


    #[Route('/color/{id}', name: 'app_color_get', methods: ['GET'])]
    #[OA\Tag(name: 'Couleur')]
    public function get(Color $color): JsonResponse
    {
        return $this->json($color, context: [
            'groups' => ['pen:read','color:read'],
        ]);
    }


    #[Route('/colors', name: 'app_color_add', methods: ['POST'])]
    #[OA\Tag(name: 'Couleur')]
    public function add(
        Request $request,
        EntityManagerInterface $em,
    ): JsonResponse {
        try {
            // On recupère les données du corps de la requête
            // Que l'on transforme ensuite en tableau associatif
            $data = json_decode($request->getContent(), true);

            $color = new Color();
            $color->setName($data['name']);
                      
            $em->persist($color);
            $em->flush();

            return $this->json($color, context: [
                'groups' => ['pen:read','color:read'],
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    #[Route('/colors/{id}', name: 'app_color_update', methods: ['PUT', 'PATCH'])]
    #[OA\Tag(name: 'Couleur')]
    public function update(
        Color $color,
        Request $request,
        EntityManagerInterface $em,
    ): JsonResponse {
        try {
            // On recupère les données du corps de la requête
            // Que l'on transforme ensuite en tableau associatif
            $data = json_decode($request->getContent(), true);

            $color->setName($data['name']);

            $em->persist($color);
            $em->flush();

            return $this->json($color, context: [
                'groups' => ['pen:read','color:read'],
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    #[Route('/color/{id}', name: 'app_color_delete', methods: ['DELETE'])]
    #[OA\Tag(name: 'Couleur')]
    public function delete( Color $color, EntityManagerInterface $em): JsonResponse {
     
            $em->remove($color);
            $em->flush();
        return $this->json([
            'code'=>'200',
            'message'=>'couleur supprimer'
        ]);

        }



}
