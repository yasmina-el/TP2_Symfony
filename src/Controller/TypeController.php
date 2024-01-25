<?php

namespace App\Controller;

use App\Entity\Type;

use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class TypeController extends AbstractController
{
    #[Route('/type', name: 'app_type', methods:['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Retourne tous les types.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Type::class, groups: ['pen:read','type:read']))
        )
    )]
    #[OA\Tag(name: 'Type')]
    #[Security(name: 'Bearer')]
    public function index( TypeRepository $typeRepository): JsonResponse
    {

        $type = $typeRepository->findAll();

        return $this->json([
            'type' => $type,
        ], context: [
            'groups' => ['pen:read','type:read'],
        ]);
    }


    #[Route('/type/{id}', name: 'app_type_get', methods: ['GET'])]
    #[OA\Tag(name: 'Type')]
    public function get(Type $type): JsonResponse
    {
        return $this->json($type, context: [
            'groups' => ['pen:read','type:read'],
        ]);
    }


    #[Route('/types', name: 'app_type_add', methods: ['POST'])]
    #[OA\Tag(name: 'Type')]
    public function add(
        Request $request,
        EntityManagerInterface $em,
    ): JsonResponse {
        try {

            $data = json_decode($request->getContent(), true);

            $type = new Type();
            $type->setName($data['name']);
                      
            $em->persist($type);
            $em->flush();

            return $this->json($type, context: [
                'groups' => ['pen:read','type:read'],
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    #[Route('/types/{id}', name: 'app_type_update', methods: ['PUT', 'PATCH'])]
    #[OA\Tag(name: 'Type')]
    public function update(
        Type $type,
        Request $request,
        EntityManagerInterface $em,
    ): JsonResponse {
        try {

            $data = json_decode($request->getContent(), true);

            $type->setName($data['name']);

            $em->persist($type);
            $em->flush();

            return $this->json($type, context: [
                'groups' => ['pen:read','type:read'],
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    #[Route('/type/{id}', name: 'app_type_delete', methods: ['DELETE'])]
    #[OA\Tag(name: 'Type')]
    public function delete(Type $type, EntityManagerInterface $em): JsonResponse {
     
            $em->remove($type);
            $em->flush();
        return $this->json([
            'code'=>'200',
            'message'=>'Type supprimer'
        ]);

        }



}
