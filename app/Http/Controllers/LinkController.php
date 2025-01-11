<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
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
        $validated['order'] = Auth::user()->links()->count();
    
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

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'links' => 'required|array',
            'links.*' => 'exists:links,id'
        ]);

        foreach ($validated['links'] as $index => $id) {
            Link::where('id', $id)
                ->where('user_id', Auth::id())
                ->update(['order' => $index]);
        }

        return redirect()->route('dashboard')->with('success', 'Link reordered successfully!');
    }
}