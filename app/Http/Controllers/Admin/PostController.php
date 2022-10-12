<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.posts.create');
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

            'title'=>'required|max:255',
            'content'=>'required|max:65535'
        ]); 
        $data = $request->all();    
        $post = new Post();
        $post->fill($data);
        
        /*metodo di laravel per rtasformare una stringa in slug.
        $slug= Str::slug($post->title, '-');
        $checkPost = Post::where('slug',$slug)->first();
        $counter =1;
        while($checkPost){
            $slug = Str::slug($post->title . '-' . $counter, '-');
            $counter++;
            $chekPost = Post::where('slug',$slug)->first();

        }*/
        
        $slug = $this-> calcolaSlug($post->title);
        $post->slug= $slug;
        $post->save();
        return redirect()->route('admin.posts.index')->with('status', 'Post creato con sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
       return view('admin.posts.show',compact('post')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([

            'title'=>'required|max:255',
            'content'=>'required|max:65535'
        ]); 
        
        $data = $request->all();
        
        $data['slug']= $this->calcolaSlug($data['title']);

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('status','Post Aggiornato');

    }
    //metodo custom per calcolare lo slag
    protected function calcolaSlug($title){
        $slug= Str::slug($title, '-');
        
        $checkPost = Post::where('slug',$slug)->first();
        $counter =1;
        while($checkPost){
            $slug = Str::slug($title . '-' . $counter, '-');
            $counter++;
            $chekPost = Post::where('slug',$slug)->first();

        }
       
        return $slug;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
      $post->delete();
      return redirect()->route('admin.posts.index')->with('status','Post cancellato');
    }
}