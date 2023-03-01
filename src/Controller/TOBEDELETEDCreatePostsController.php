<?php
//
//namespace Project4\Controller;
//
//use Cocur\Slugify\Slugify;
//use DI\Container;
//use DI\DependencyException;
//use DI\NotFoundException;
//use Laminas\Diactoros\Response\JsonResponse;
//use OpenApi\Annotations as OA;
//use Project4\Entity\Posts;
//use Project4\Repository\PostsRepository;
//use Project4\Validator\PostValidator;
//use Ramsey\Uuid\Uuid;
//use Slim\Psr7\Request;
//use Slim\Psr7\Response;
//
//class TOBEDELETEDCreatePostsController
//{
//    private PostsRepository $postsRepository;
//    private string $base;
//
//    /**
//     * @throws DependencyException
//     * @throws NotFoundException
//     */
//    public function __construct(Container $container)
//    {
//        $this->postsRepository = $container->get(PostsRepository::class);
//        $this->base = $container->get('settings')['app']['domain'];
//    }
//
//    /**
//     * @OA\Post(
//     *     path="/posts/create",
//     *     description="Create a new post",
//     *     tags={"Posts"},
//     * @OA\RequestBody(
//     *         description="Post to be created",
//     *         required=true,
//     * @OA\MediaType(
//     *              mediaType="application/json",
//     * @OA\Schema(
//     * @OA\Property(property="title",     type="string", example="Excellent work"),
//     * @OA\Property(property="content",   type="string", example="Look Here"),
//     * @OA\Property(property="thumbnail", type="string", example="photo from Base64Encoder"),
//     * @OA\Property(property="author",    type="string", example="Giorgio Selmi"),
//     * @OA\Property(property="posted_at", type="string", example="2023-02-03"),
//     *      )
//     *    )
//     * ),
//     * @OA\Response(
//     *     response="200",
//     *     description="The ID of the post",
//     * @OA\MediaType(
//     *           mediaType="application/json",
//     * @OA\Schema(
//     * @OA\Property(property="id",        type="string", example="115ec074-2a37-40ba-a51c-33d2efab684c"),
//     *       )
//     *     )
//     *   )
//     * )
//     */
//    public function __invoke(Request $request, Response $response, $args): JsonResponse
//    {
//        $inputs = json_decode($request->getBody()->getContents(), true);
//
//        PostValidator::validate($inputs);
//        $slugify = new Slugify();
//        $slug = $slugify->slugify($inputs['title']);
//
//        $id = uniqid();
//        $b64 = $inputs['thumbnail'];
//        file_put_contents('images/'. $id . '.jpg', base64_decode($b64));
//
//        $post = new Posts(
//            Uuid::uuid4(), $inputs['title'], $slug, $inputs['content'],
//            $this->base . '/images/' . $id . '.jpg', $inputs['author']
//        );
//        $this->postsRepository->storePost($post);
//
//        $output = [
//            ...$inputs,
//        ];
//
//        return new JsonResponse($output);
//    }
//}