<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    
use App\Models\pageSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class pageSettingsController extends Controller
{
    use AuthorizesRequests;

    public function updatePgDescription(Request $request)
    {
        $pageDescription = pageSettings::where('user_id', Auth::id())->firstOrFail();
    
        $this->authorize('updatePgDescription', $pageDescription);
    
        $validated = $request->validate([
            'page_description' => 'nullable|string',
        ]);
    
        $pageDescription->update($validated);
    
        return redirect()->route('dashboard')->with('success', 'Page description updated successfully!');
    }
}
