<?php

namespace App\Controller;


use App\Document\User;
use App\Form\UserLoginType;
use App\Form\UserType;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Utils\Auth\JsonWebToken;
use App\Utils\Auth\AuthenticationInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Service\Attribute\Required;


#[Route("/user")]
class UserController extends AbstractController
{
    private UserRepository $userRepository;
    private AuthenticationInterface $authentication;
    private UserPasswordHasherInterface $hasher;

    #[Required]
    public function setUserRepository(UserRepository $userRepository): void
    {
        $this->userRepository = $userRepository;
    }

    #[Required]
    public function setAuthentication(AuthenticationInterface $authentication): void
    {
        $this->authentication = $authentication;
    }

    #[Required]
    public function setHasher(UserPasswordHasherInterface $hasher): void
    {
        $this->hasher = $hasher;
    }

    #[Route('/', name: 'app_user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route("/store", name: "app-user-store", methods: ["POST"])]
    public function store(Request $request): JsonResponse
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if($form->isValid()){
                $user = $form->getData();
                $hashedPassword = $this->hasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);
                $this->userRepository->createUser($user);
                $token = $this->authentication::encrypt(["user" => $user->getEmail()]);

                return $this->json($token);
            }

            return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
        }

        return $this->json(["error" => "not submitted"],Response::HTTP_BAD_REQUEST);
    }

    #[Route('/login', name: 'app-user-login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $form = $this->createForm(UserLoginType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();
            $user = $this->userRepository->findUserByEmail($userData['email']);

            if ($this->hasher->isPasswordValid($user , $userData['password'])) {
                $token = $this->authentication::encrypt(['user' => $user->getEmail()]);

                return $this->json($token);
            }

            return $this->json(null, Response::HTTP_UNAUTHORIZED);
        }

        return $this->json(null, Response::HTTP_BAD_REQUEST);
    }
}
