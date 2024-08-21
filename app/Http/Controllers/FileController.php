<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = auth()->user()->files;
        return view('dashboard', compact('files'));
    }

    public function upload(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:png,jpg,pdf,doc,docx,gif,bmp,jpeg,xls,pptx,mp4,mp3,avif,css,ico,jar,js,mpeg,ppt,rar,svg,txt,weba,webm,webp,xlsx,zip,php,html,exe,sql|max:30720',
        ]);

        $file = $req->file('file');
        $path = $file->store('user_files/' . auth()->id());

        auth()->user()->files()->create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize()
        ]);
        return redirect()->back()->with('success', 'File upload successfully.');
    }

    public function rename(Request $request, File $file)
    {
        $this->authorize('update', $file);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $extension = pathinfo($file->name, PATHINFO_EXTENSION);
        $newName = pathinfo($request->name, PATHINFO_FILENAME) . '.' . $extension;

        $file->update(['name' => $newName]);

        return redirect()->back()->with('success', 'File renamed successfully.');
    }

    public function delete(File $file)
    {
        $this->authorize('delete', $file);

        Storage::delete($file->path);
        $file->delete();

        return redirect()->back()->with('success', 'File Has Been Delete.');
    }

    public function download(File $file)
    {
        $this->authorize('view', $file);

        if (!Storage::exists($file->path)) {
            abort(404, 'File not found');
        }

        return Storage::download($file->path, $file->name);
    }
}