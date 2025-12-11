<?php

namespace Inn\App\Controllers;

use Inn\App\Attributes\Route;

class HomeController
{
    #[Route(path: "/", method: "GET")]
    public function index(): string
    {
        return "Welcome! It's a home page.";
    }

    #[Route(path: "/about", method: "GET")]
    public function about(): string
    {
        return "This about page is about home page.";
    }
}
