<?php

namespace App\Http\Controllers;

use App\Models\Book;
use DataTables;
use Illuminate\Http\Request;

class BookController extends Controller
{
    
    public function index(Request $request)
    {
   
        $books = Book::latest()->get();
        
        if ($request->ajax()) {
            $data = Book::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBook">Edit</a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('book',compact('books'));
    }
     
   
    public function store(Request $request)
    {
        Book::updateOrCreate(['id' => $request->book_id],
                ['title' => $request->title, 'author' => $request->author]);        
   
        return response()->json(['success'=>'Data Buku Berhasil Disimpan.']);
    }
   
    public function edit($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }
  
   
    public function destroy($id)
    {
        Book::find($id)->delete();
     
        return response()->json(['success'=>'Data Buku Berhasil di Delete.']);
    }
}
