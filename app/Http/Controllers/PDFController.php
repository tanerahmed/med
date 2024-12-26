<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PDF;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    public function upload($articleId)
    {
        $article = Article::findOrFail($articleId);
        return view('pdfs.upload', compact('article'));
    }

    public function store(Request $request, $articleId)
    {

        // $validated = $request->validate([
        //     'file' => 'required|file|mimes:pdf|max:2048',
        // ]);

        $article = Article::findOrFail($articleId);

        $file = $request->file('pdf_file');
        $filePath = $file->storeAs('pdfs/' . $articleId, $file->getClientOriginalName(), 'public');

        PDF::create([
            'file_path' => $filePath,
            'article_id' => $article->id,
        ]);
        $notification = [
            'message' => 'PDF uploaded successfully.',
            'alert-type' => 'success'
        ];
        return redirect()->route('article.list')->with($notification);
    }
}