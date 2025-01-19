<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function createFromEncoded($encoded)
    {
        try {
            // Decode the URL
            $decodedUrl = base64_decode($encoded);
            
            if ($decodedUrl === false) {
                throw new \Exception('Invalid URL encoding');
            }
    
            // Parse the decoded URL to get the page_name parameter
            $parsedUrl = parse_url($decodedUrl);
            parse_str($parsedUrl['query'] ?? '', $queryParams);
            
            $pageName = $queryParams['page_name'] ?? null;
    
            if (!$pageName) {
                throw new \Exception('Missing page name parameter');
            }
    
            // Pass the page_name to the view with flash data
            return view('auth.register')->with('page_name', $pageName);
    
        } catch (\Exception $e) {
            return redirect()->route('register');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'page_name' => ['required', 'string', 'min:3', 'max:255', 'unique:'.User::class, 'regex:/^[a-zA-Z0-9_-]+$/'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'page_name' => $request->page_name,
        ]);

        event(new Registered($user));


        return redirect(RouteServiceProvider::HOME)->with('success', 'New user registered successfully!');
        
    }
}