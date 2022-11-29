<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;

class AuthController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function login(): void
    {
        // $this->render('auth/login', [], false);
        $this->render('auth/login', navbar: false); // apenas a partir do PHP8
    }

    public function logout(): void
    {

    }
}