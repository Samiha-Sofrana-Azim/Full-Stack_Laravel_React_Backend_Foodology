<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Comment;
use DB;

class PostController extends Controller
{

    public function addPost(Request $req)
    {
        $post = new Post;
        $post->name = $req->input('name');
        $post->description = $req->input('description');
        if ($req->hasFile('file')) {
            $image = $req->file('file');
            $imagename = time() . '.' . $image->extension();
            $image->move(public_path('public/posts'), $imagename);
            $post->file_path = $imagename;
        } else {
            $post->file_path = 'default1.jpg';
        }


        $post->save();
        $healthy = $req->input('healthy');
        $junk = $req->input('junk');
        $village = $req->input('village');
        $drinks = $req->input('drinks');
        $other = $req->input('other');

        if ($req->input('healthy') === 'true') {
            $data = array();
            $data['post_id'] = $post->id;
            $data['category_id'] = 1;
            DB::table('category_post')->insert($data);
        }

        if ($req->input('junk') === 'true') {
            $data = array();
            $data['post_id'] = $post->id;
            $data['category_id'] = 2;
            DB::table('category_post')->insert($data);
        }

        if ($req->input('village') === 'true') {
            $data = array();
            $data['post_id'] = $post->id;
            $data['category_id'] = 3;
            DB::table('category_post')->insert($data);
        }

        if ($req->input('drinks') === 'true') {
            $data = array();
            $data['post_id'] = $post->id;
            $data['category_id'] = 4;
            DB::table('category_post')->insert($data);
        }

        if ($req->input('other') === 'true') {
            $data = array();
            $data['post_id'] = $post->id;
            $data['category_id'] = 5;
            DB::table('category_post')->insert($data);
        }

        return $post;
    }

    public function postlist()
    {
        return Post::all();
    }
    public function delete($id)
    {

        $result = Post::where('id', $id)->delete();
        $catgory_post = DB::table('category_post')->where('post_id', $id)->delete();
    }


    public function getPost($id)
    {
        $post = Post::find($id);
        $post = DB::table('posts')->where('id', $id)->first();
        return response()->json(['post' => $post]);
    }

    public function updatePost($id, Request $req)
    {

        $update = DB::table('posts')->where('id', $id)->update(['name' => $req->name, 'description' => $req->description]);
        $post = DB::table('posts')->where('id', $id)->first();
        return response()->json($post);
    }

    public function addComment(Request $req)
    {

        $post = new Comment;
        $post->comment = $req->input('comment');
        $post->save();

        return $post;
    }
}
