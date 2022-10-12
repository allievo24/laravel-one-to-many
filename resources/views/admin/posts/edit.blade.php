@extends('layouts.app')

@section('content')
 <div class="container">
    <form action="{{route('admin.posts.update',['post' => $post->id])}}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror " id="title" name="title" value="{{old('content',$post->content)}}">
            @error('title')
           <div class='invalid-feedbak'>
            {{$message}}
           </div>
           @enderror
          </div>
          <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" cols="30" rows="10" class="form-control @error('title') is-invalid @enderror">{{old('content',$post->content)}}
            </textarea>
             @error('title')
           <div class='invalid-feedbak'>
            {{$message}}
           </div>
           @enderror
          </div>
          
          <button type="submit" class="btn btn-primary">Update</button> 
      </form>

 </div>
  

    
@endsection