<?php

namespace App\Controller;

use App\Document\Order;
use App\Form\OrderType;
use App\Message\UserNotification;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Service\Attribute\Required;

#[Route('/order')]
class OrderController extends AbstractController
{
    private UserRepository $userRepository;
    private OrderRepository $orderRepository;
    //private ProductRepository $productRepository;

    #[Required]
    public function setUserRepository(UserRepository $userRepository): void
    {
        $this->userRepository = $userRepository;
    }

    #[Required]
    public function setOrderRepository(OrderRepository $orderRepository): void
    {
        $this->orderRepository = $orderRepository;
    }

//    #[Required]
//    public function setProductRepository(ProductRepository $productRepository): void
//    {
//        $this->productRepository = $productRepository;
//    }

    #[Route('/list')]
    public function list(Request $request): JsonResponse
    {
        $token = $request->headers->get('token');

        if (!$token) {
            return $this->json(null, Response::HTTP_BAD_REQUEST);
        }

        return $this->json($this->orderRepository->findBy(['token' => $token]));
    }

    #[Route('/', name: 'app-order-create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $token = $request->headers->get('token');
        $user = $this->userRepository->findOneBy(['token' => $token]);

        if (!$user) {
            return $this->json(null, Response::HTTP_UNAUTHORIZED);
        }

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setOwner($user);
            $this->orderRepository->add($order);
            //$bus->dispatch(new UserNotification($user->getEmail(), 'Compra realizada con exito '.$order->__toString()));

            return $this->json($order);
        }

        return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
    }
}
