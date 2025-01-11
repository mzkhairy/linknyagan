<?php
// app/Http/Controllers/PageNameController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PageNameController extends Controller
{
    public function checkAvailability($pageName)
    {
        // Add validation rules for page name
        if (strlen($pageName) < 3) {
            return response()->json([
                'available' => false,
                'message' => 'Page name must be at least 3 characters long'
            ]);
        }

        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $pageName)) {
            return response()->json([
                'available' => false,
                'message' => 'Page name can only contain letters, numbers, underscores and dashes'
            ]);
        }

        $exists = User::where('page_name', $pageName)->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'This page name is already taken' : 'This page name is available!'
        ]);
    }
}