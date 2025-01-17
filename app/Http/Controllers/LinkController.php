<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LinkController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required|url|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
        ]);
    
        $validated['user_id'] = Auth::user()->id;
    
        $link = Link::create($validated);
    
        return redirect()->route('dashboard')->with('success', 'Link added successfully!');
    }


    public function update(Request $request, Link $link)
    {
        $this->authorize('update', $link);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required|url|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
        ]);

        $link->update($validated);

        return redirect()->route('dashboard')->with('success', 'Link updated successfully!');
    }

    public function destroy(Link $link)
    {
        $this->authorize('delete', $link);
        
        $link->delete();
        
        return redirect()->route('dashboard')->with('success', 'Link deleted successfully!');
    }
}