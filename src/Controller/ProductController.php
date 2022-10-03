<?php

namespace App\Controller;

use App\Document\Product;
use App\Form\ProductType;
use App\Repositories\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Service\Attribute\Required;

#[Route('/product')]
class ProductController extends AbstractController
{
    private ProductRepository $productRepository;

    #[Required]
    public function setProductRepository(ProductRepository $productRepository): void
    {
        $this->productRepository = $productRepository;
    }

    #[Route('/list', name: 'app-product-list', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $limit = $request->get('limit') ?: 0;
        $offset = $request->get('offset') ?: 0;
        $query = $request->get('q') ?: '';
        return $this->json($this->productRepository->paginateProducts($query, $limit, $offset));
    }

    #[Route('/find/{id}', name: 'app-product-find', methods: ['GET'])]
    public function find(string $id): JsonResponse
    {
        $product = $this->productRepository->find($id);

        if ($product === null) {
            return $this->json(null, Response::HTTP_NOT_FOUND);
        }

        return $this->json($product);
    }

    #[Route('/new', name: 'app-product-create', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $this->productRepository->add($product);

            return $this->json($product);
        }

        return $this->json(null, Response::HTTP_BAD_REQUEST);
    }
}
