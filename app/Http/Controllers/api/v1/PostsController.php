<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    //buat tampil data dri db
    public function index()
    {
        $posts = Post::latest()->get();
        return response([
            'success' => true,
            'message' => 'List semua post',
            'data' => $posts
        ], 200);
    }


    //buat post data ke db
    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ],
        [
            'title.required' => 'Masukan Title Post!',
            'content.required' => 'Masukan Content Post!',
        ]
        );

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan isi yang kosong',
                'data' => $validator->errors()
            ], 401);
        } else {
            $post = Post::create([
                'title' => $request->input('title'),
                'content' => $request->input('content')
            ]);
            
            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post data berhasil!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post gagal disimpan!',
                ], 401);
            }
        }
    }
}
