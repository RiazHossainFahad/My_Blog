<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Http\Resources\BlogResource;
use App\Http\Requests\BlogRequest;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BlogResource::collection(Blog::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        if($request->hasFile('url')){
            $file = $request->file('url');
            $fn = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();

            if($ext === 'jpg' || $ext === 'png' || $ext === 'jpeg'){
                $file->move('F:\create-blog\src\assets', $fn);
                $blog = new Blog;
                $blog->url = $fn;
                $blog->title = $request->title;
                $blog->body = $request->body;
                $blog->save();
                return response([
                    'data' => new BlogResource($blog)
                ], Response::HTTP_CREATED);
            }
            else {
                return response([
                    'Error' => 'File Not supported'
                ], 505);
            }
            return $ext;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return new BlogResource($blog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
