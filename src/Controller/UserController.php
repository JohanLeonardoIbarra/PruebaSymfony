<?php

namespace App\Controller;


use App\Document\User;
use App\Form\UserLoginType;
use App\Form\UserType;
use App\Message\UserRegisterNotification;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Service\Attribute\Required;


#[Route("/user")]
class UserController extends AbstractController
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $hasher;

    #[Required]
    public function setUserRepository(UserRepository $userRepository): void
    {
        $this->userRepository = $userRepository;
    }

    #[Required]
    public function setHasher(UserPasswordHasherInterface $hasher): void
    {
        $this->hasher = $hasher;
    }

    #[Route("/", name: "app-user-create", methods: ["POST"])]
    public function create(Request $request, MessageBusInterface $bus): JsonResponse
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $hashedPassword = $this->hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            $this->userRepository->createUser($user);
            $bus->dispatch(new UserRegisterNotification(email: $user->getEmail()));

            return $this->json(null, Response::HTTP_NO_CONTENT);
        }

        return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
    }

    #[Route('/login', name: 'app-user-login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $form = $this->createForm(UserLoginType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();
            $user = $this->userRepository->findUserByEmail($userData['email']);

            if ($user === null) {
                return $this->json(['errors' => [['message' => 'User or password invalid']]], Response::HTTP_NOT_FOUND);
            }

            if ($this->hasher->isPasswordValid($user , $userData['password'])) {
                return $this->json(['token' => $user->getToken()]);
            }

            return $this->json(['errors' => [['message' => 'User or password invalid']]], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
    }
}
