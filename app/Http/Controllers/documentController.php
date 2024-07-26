<?php

namespace App\Http\Controllers;

use App\Models\document;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Storage;

class documentController extends Controller
{
    public function show_all(){
        // way 1
        /*
        $document_list = DB::select('SELECT * FROM document ORDER BY `created_at` DESC');
        return view('documents', [
                'document_list'=>$document_list
            ]);

        */
        /*
        // way 2
        return view('documents', [
                'document_list'=>Document::orderBy('created_at', 'DESC')->paginate(10)
            ]);
            */
        return view('document.documents', [
                'document_list'=>Document::orderBy('created_at', 'DESC')->get()
            ]);

    }
    public function upload()
    {
        return view('document.form');
    }

    public function store(Request $request)
    {
        dd($request);
        $form_fields = $request->validate([
            // 'title' => ['required',Rule::unique('document','title')],
            'title' => 'required',
            'description' => 'required',
            'tags' => 'required|ascii',
            'path' => 'required',
        ]);
        
        
        if($request->hasFile('path')){
            $form_fields['path'] = $request->file('path')->store('documents','public');
        }
        // dd($form_fields);
        // Additional logic (e.g., storing file information in the database)
        document::create($form_fields);
        return redirect('document.success');
    }
    public function success(){
        return view('document.success');
    }

    public function show(String $id){
        // $path = asset("public/storage/documents/".$url);
        // $path = "127.0.0.1:8000\\document_upload\\public\\storage\\".$url;

        // retrieve the document using ID
        $result =  DB::table('document')->where('id',$id)->first();

        // generate the file path
        $path = public_path("storage\\".$result->path);

        // check if the file exists
        if(file_exists($path))
        return response()->download($path,$result->title.'.pdf');
        else
        dd($path);
    }

    public function destroy($id)
    {
        $document = document::find($id);

        if (!$document) {
            return back()->with(['error' => 'Action not done ❌'], 404);
        }
        
        $document->delete();
        return back()->with(['success' => 'Document deleted successfully ✅'], 200);
    }


}
