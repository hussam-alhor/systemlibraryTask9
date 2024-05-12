<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // عرض جميع الكتب مع فلترة اختياري


        $query = Book::with('authors');
        if($request->has('genre'))
        
        if($request->has('genre'))
        {
            $query->whereHas('genre', 
                function($q) use ($request)
                {
                    $q->where('name', $request->genere);
                }
            );
        }
        if($request->has('author'))
        {
            $query->whereHas('authors', 
                function($q) use ($request)
                {
                    $q->where('name', $request->author);
                }
            );
        }
        if($request->has('avilable'))
        {
            $query->whereHas('avilable', 
                function($q) use ($request)
                {
                    $q->where('avilable', $request->avilable);
                }
            );
        }
        return response()->json($query->get());
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::check() || !Auth::user()->is_admin){
            return response()->json([
                'message'=> 'Unauthorized'
            ], 401);
        }
        $book = Book::create($request->all());
        $book->authors()->attach($request->authors) ;
        return response()->json($book , 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book , $id)
    {
        $book = Book::wiht('authors')->find($id);
        if(!$book)
        {
            return response()->json([
                'message'=>'Not found'
            ], 404);
        }
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book , $id)
    {
        $book = Book::find($id);
        if (!$book)
        {
            return response()->json([
                'message'=>'not found'
            ], 404);
        }
        //تحديث كتاب
        $book->fill($request->except(['authors']));
        $book->save();

        //تحديث علاقة المؤلفين
        if($request->has('authors'))
        {
            $book->authors()->sync($request->input('authors'));
        }
        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book , $id)
    {
        $book = BOOK::find($id);
        if (!$book)
        {
            return response()->json([
                'message'=>'not found'
            ], 404);
        }
        $book->authors()->detach();
        $book->delete();
        return response()->json([
            'message'=>'Deleted successfully'
        ],200);
    }
}
