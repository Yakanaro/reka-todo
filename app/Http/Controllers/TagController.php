<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags',
        ]);

        $tag = new Tag([
            'name' => $request->get('name'),
        ]);

        $tag->save();

        return back()->with('success', 'Тег успешно добавлен!');
    }
}
