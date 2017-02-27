<?php

namespace Inani\Larapoll\Http\Controllers;

use App\Http\Controllers\Controller;

class PollManagerController extends Controller
{

    public function index()
    {
        return view('larapoll::dashboard.index');
    }
}