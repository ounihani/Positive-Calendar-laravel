<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Vote;
use Carbon\Carbon;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'posts_date' => 'nullable|date_format:Y-m-d',
        ]);

        if($request->posts_date){
            $posts_date = $request->posts_date; 
        }else{
            $posts_date = Carbon::now()->toDateString();
        }

        return Post::with('user')->withCount(array('votes',
        'votes as voted'  => function($query)
            {
                $query->where('votes.user_id', auth()->user()->id);
            
            }))->withCount('votes')->orderBy('votes_count', 'desc')->paginate(18); 


        if($request->sort_type == 'sort_by_votes'){
            $posts = Post::with('user')->whereDate('created_at',$posts_date)->withCount(array('votes' => function($query)
            {
                $query->where('votes.user_id', auth()->user()->id);
            
            }))->withCount('votes')->orderBy('votes_count', 'desc')->paginate(18);    
        }else{
            $posts = Post::with('user')->whereDate('created_at',$posts_date)->withCount('votes')->orderBy('created_at', 'desc')->paginate(18);
        }
        return $posts;
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
        
        $request->validate([
            'description' => 'required|string',
            'image' => 'image|max:5999'
        ]);
        // Handle File Upload
        if($request->hasFile('image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
        } else {
            return response()->json([
                'message' => 'no image!'
            ], 201);
        }
        $post = new Post();
        $post->source = $request->source;
        $post->description = $request->description;
        $post->user_id = $request->user()->id;
        $post->source = $fileNameToStore;
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

    public function votePost(Request $request){
        $request->validate([
            'post_id' => 'required|integer'
        ]);
        $vote= Vote::where('post_id', '=', $request->post_id)
        ->where('user_id', '=', $request->user()->id)->first();
        //return $vote;
        if(!$vote){
        $vote = new Vote();
        $vote->user_id = $request->user()->id;
        $vote->post_id = $request->post_id;
        $vote->save();
        return response()->json([
            'message' => 'Successfully voted!'
        ], 201);
        }else{
            $vote->delete();
            return response()->json([
                'message' => 'Successfully unvoted!'
            ], 202);
        }    
    }

   
}
