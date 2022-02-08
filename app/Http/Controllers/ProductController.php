<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Product', [
            'products' => [
                [
                    'id' => 1,
                    'name' => 'Metro QR Ticket',
                    'description' => 'QR ticket for one-way or return journey',
                    'url' => '/ticket/dashboard'
                ]
            ]
        ]);
    }
}
