<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PostController extends Controller
{

    public function index(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {

        // return $request->all();

        $request->validate([
            'title' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        foreach ($request->input('file_ids') as $fileId) {
            $temporaryFile = TemporaryFile::find($fileId);
            $post->addMedia(storage_path('app/' . $temporaryFile->path))->toMediaCollection();
            $temporaryFile->delete();
        }

        return redirect()->route('home')->with('msg', 'Saved');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $post->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        if ($request->input('file_ids')) {
            foreach ($request->input('file_ids') as $fileId) {
                $temporaryFile = TemporaryFile::find($fileId);
                $post->addMedia(storage_path('app/' . $temporaryFile->path))->toMediaCollection();
                $temporaryFile->delete();
            }
        }

        return redirect()->route('home')->with('msg', 'Saved');
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return redirect()->route('home')->with('msg', 'Deleted');
    }


    public function uploadImg(Request $request)
    {
        if ($request->hasFile('filepond')) {
            $file = $request->file('filepond');
            $temporaryFile = $file->store('temporary');
            $temporaryFileModel = new TemporaryFile(['path' => $temporaryFile]);
            $temporaryFileModel->save();

            return $temporaryFileModel->id;
        }
    }

    public function mediaDelete($id)
    {
        $media = Media::find($id);
        
        $count = $media->model->getMedia()->count();

        if ($count <= 1) {
            return redirect()->back()->withErrors(['error' => 'At least one image is required']);
        }

        $media->delete();
        return redirect()->back()->with('success', 'Media item deleted successfully');
    }
}
