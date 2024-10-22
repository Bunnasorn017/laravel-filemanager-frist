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
        $filescount = auth()->user()->files->count();
        return view('dashboard', compact('files', 'filescount'));
    }

    public function indexsearch()
    {
        $files = auth()->user()->files;
        return view('search', compact('files'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|mimes:png,jpg,pdf,doc,docx,gif,bmp,jpeg,xls,pptx,mp4,mp3,avif,css,ico,jar,js,mpeg,ppt,rar,svg,txt,weba,webm,webp,xlsx,zip,php,html,exe,sql|max:30720',
        ]);
        $fileCount = count($request->file('files'));

        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $path = $file->store('user_files/' . auth()->id());

            $uploadedFile = auth()->user()->files()->create([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize()
            ]);

            $uploadedFiles[] = $uploadedFile;

            $totalSize = 0;
            foreach ($request->file('files') as $file) {
                $totalSize += $file->getSize();
            }

            if ($totalSize > 30 * 1024 * 1024) { // 30 MB in bytes
                return redirect()->back()->with('error', 'Total file size exceeds 30 MB limit.');
            }
        }
        return redirect()->back()->with('upload_success', $fileCount);
        return redirect()->back()->with('success', count($uploadedFiles) . ' file(s) uploaded successfully.');
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

        return redirect()->back()->with('success', 'File Has Been Deleted.');
    }

    public function download(File $file)
    {
        $this->authorize('view', $file);

        if (!Storage::exists($file->path)) {
            abort(404, 'File not found');
        }

        return Storage::download($file->path, $file->name);
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        $folderPath = 'user_files/' . auth()->id() . '/' . $request->folder_name;

        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
        }

        return redirect()->back()->with('success', 'Folder created successfully.');
    }
}