<?php

namespace App\Controller;


use App\Document\User;
use App\Form\UserLoginType;
use App\Form\UserType;
use App\Utils\Auth\JsonWebToken;
use App\Utils\Auth\AuthenticationInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route("/user")]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route("/store", name: "app-user-store", methods: ["POST"])]
    public function store(Request $request, DocumentManager $documentManager, UserPasswordHasherInterface $hasher, AuthenticationInterface $authentication): JsonResponse
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $form->submit($request->toArray());
        if ($form->isSubmitted() || true) {
            if($form->isValid() || true){
                $user = $form->getData();
                $hashedPassword = $hasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);
                //$documentManager->persist($user);
                //$documentManager->flush();
                $token = $authentication::encrypt(["user" => $user->getEmail()]);

                return $this->json($token);
            }
            return $this->json(["error" => "not valid"], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(["error" => "not submitted"],Response::HTTP_BAD_REQUEST);
    }

    #[Route("/login", name: "app-user-login", methods: ["POST"])]
    public function login(Request $request)
    {
        $form = $this->createForm(UserLoginType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

        }
    }
}
