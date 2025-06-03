<?php

namespace App\Controllers;

class FaqController extends BaseController
{
    public function index(): string
    {
        return view('v_faq');
    }
}