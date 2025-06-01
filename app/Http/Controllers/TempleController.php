<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TempleController extends Controller
{
    public function index()
    {

        $images = [
            'images/1.png',
            'images/2.jpg',
            'images/3.png',
            'images/4.jpg',
            'images/5.jpg'
        ];
        $regionNames = ['ภาคเหนือ', 'ภาคใต้', 'ภาคตะวันออก', 'ภาคตะวันตก', 'ภาคกลาง'];


        return view('tasks.uxuitester.ux-uiTester', compact('images', 'regionNames'));
    }
}
