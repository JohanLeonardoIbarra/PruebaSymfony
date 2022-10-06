<?php

namespace App\Controller;

use App\Document\Product;
use App\Form\ListType;
use App\Form\ProductType;
use App\Repository\ProductRepository;
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

    #[Route('/', name: 'app-product-list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $defaultData = [];
        $form = $this->createForm(ListType::class, $defaultData);
        $request->request->replace(['q' => $request->get('q'), 'limit' => (int) $request->get('limit')]);
        $request->setMethod('POST');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->json($this->productRepository->paginateProducts($data['q'], $data['limit']));
        }

        return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
    }

    #[Route('/', name: 'app-product-create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $this->productRepository->add($product);

            return $this->json($product);
        }

        return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
    }
}
