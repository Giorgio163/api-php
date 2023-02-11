<?php

namespace Project4\Controller;

use DI\Container;
use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Annotations as OA;
use Project4\Repository\CategoriesRepository;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DeleteCategoriesController
{
    private CategoriesRepository $categoriesRepository;

    public function __construct(Container $container)
    {
        $this->categoriesRepository = $container->get(CategoriesRepository::class);
    }
    /**
     * @OA\Delete(
     *     path="/categories/delete/{id}",
     *     description="Delete a category by ID.",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         description="ID of category to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="The ID of the category"
     *     )
     * )
     */
    public function __invoke(Request $request, Response $response, $args): JsonResponse
    {
        $id = $this->categoriesRepository->deleteCategory(Uuid::fromString($args['id']));

        $res = [
            'status' => 'success',
            'data' => [ 'id' => $id ]
        ];

        return new JsonResponse($res, 200);
    }
}