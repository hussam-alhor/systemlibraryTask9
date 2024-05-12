<?php
// app/Http/Controllers/AuthorController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    // List all authors
    public function index()
    {
        $authors = Author::all();
        return response()->json($authors);
    }

    // Add a new author (admin only)
    public function store(Request $request)
    {
        if (Auth::user()->is_admin) {
            $author = Author::create($request->all());
            return response()->json($author, 201);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    // Get detailed information about a specific author
    public function show($id)
    {
        $author = Author::find($id);
        if ($author) {
            return response()->json($author);
        } else {
            return response()->json(['error' => 'Author not found'], 404);
        }
    }

    // Update author information (admin only)
    public function update(Request $request, $id)
    {
        if (Auth::user()->is_admin) {
            $author = Author::find($id);
            if ($author) {
                $author->update($request->all());
                return response()->json($author);
            } else {
                return response()->json(['error' => 'Author not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    // Delete an author (admin only)
    public function destroy($id)
    {
        if (Auth::user()->is_admin) {
            $author = Author::find($id);
            if ($author) {
                $author->delete();
                return response()->json(['message' => 'Author deleted successfully']);
            } else {
                return response()->json(['error' => 'Author not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}