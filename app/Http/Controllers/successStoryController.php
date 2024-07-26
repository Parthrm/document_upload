<?php

namespace App\Http\Controllers;

use App\Models\successStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;

class successStoryController extends Controller
{
    public function index(){
        return view('success_story.index',[
            'story_list'=>successStory::orderBy('updated_at','DESC')->get()
        ]);
    }

    public function create(){
        return view('success_story.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $formFields = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
        ]);
        
        // Get the text content
        $content = $request->validate([
            'content' => 'required|string'
        ]);

        $fileName = uniqid();

        $formFields['path'] = $fileName;
        
        // Define the file path and name
        $filePath = '//story_text_files//' . $fileName . '.txt';
        
        // dd($formFields);
        successStory::create($formFields);

        // Store the file securely in the storage/app directory
        if(Storage::put($filePath, $content['content']))
        return redirect('/')->with(['success' => 'File stored successfully']);
        return back()->with(['error' => 'File not stored successfully']);
        
    }

    /**
     * Retrieve the text content from a file.
     *
     * @param string $fileName
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $story = successStory::find($id);
        
        $filePath = '//story_text_files//' .$story->path.'.txt';

        // Define the file path
        // $filePath = 'secure-text-files/' . $fileName;

        // // Check if the file exists
        // if (!Storage::exists($filePath)) {
        //     return back()->with(['error' => 'File not found'], 404);
        // }

        // Get the file content
        // $content = Storage::get($filePath);

        // $content = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit illo reiciendis vel! Iure quod nemo explicabo mollitia dolorum maiores laboriosam!";
        $content = Storage::get($filePath);
        // return view('success_story.single_story',['story'=>$story, 'content' => $content]);
        return view('success_story.single_story',compact('content'),['story'=>$story]);
    }
}
