<?php

namespace Inn\App\Controllers;

use Inn\App\Attributes\Route;
use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController
{
    #[Route(path: "/", method: "GET")]
    public function index(RequestInterface $request): ResponseInterface
    {
        return new Response(200, [], "Welcome! It's a home page.");
    }

    #[Route(path: "/about", method: "GET")]
    public function about(RequestInterface $request): ResponseInterface
    {
        return new Response(200, [], "This about page is about home page.");
    }
}
