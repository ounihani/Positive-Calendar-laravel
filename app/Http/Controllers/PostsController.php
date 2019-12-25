<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::with('user')->paginate(18);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->source = $request->source;
        $post->description = $request->description;
        $post->user_id = $request->user()->id;
        $post->save();

        return response()->json([
            'message' => 'Successfully created post!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post=post::find($id);
        if(!$post){
            return response()->json([
                'message' => 'Post does not exist'
            ], 201);
        }
        if($post->user_id==$request->user()->id){
            $post->delete();
            return response()->json([
                'message' => 'Successfully deleted post!'
            ], 201);
        }else{
            return response()->json([
                'message' => 'Not authorized'
            ], 201);
        }
    }

    public function userPosts(Request $request){
        return Post::where('user_id','=',$request->user()->id)->with('user')->paginate(18);
    }

}
