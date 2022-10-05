<?php

namespace App\Controller;

use App\Document\Order;
use App\Form\OrderType;
use App\Message\UserOrderNotification;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Service\Attribute\Required;

#[Route('/order')]
class OrderController extends AbstractController
{
    private UserRepository $userRepository;
    private OrderRepository $orderRepository;

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

    #[Route('/', name: 'app-order-create', methods: ['POST'])]
    public function create(Request $request, MessageBusInterface $bus): JsonResponse
    {
        $token = $request->headers->get('token');
        $user = $this->userRepository->findOneBy(['token' => $token]);

        if (!$user) {
            return $this->json(null, Response::HTTP_FORBIDDEN);
        }

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setOwner($user);
            $this->orderRepository->add($order);
            $this->orderRepository->getDocumentManager()->persist($order);
            $bus->dispatch(new UserOrderNotification($user->getEmail(), $order));

            return $this->json(['order' => $order->getId()]);
        }

        return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
    }
}
