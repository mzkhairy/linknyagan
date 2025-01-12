<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    public function show($pageName)
    {
        $user = User::where('page_name', $pageName)->firstOrFail();
        return view('publicview', ['user' => $user]);
    }
}
