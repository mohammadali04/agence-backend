<?php

namespace Modules\Blog\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Blog\Http\Resources\BlogResource;
use Modules\Blog\Models\Blog;
use Modules\Shared\Http\Controllers\Api\BaseResponderController;

class BlogController extends BaseResponderController
{
    public function getBlogs()
    {
        $features = Blog::all();
        return $this->sendResponse(BlogResource::collection($features), 'features');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'slug' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'body' => 'required|string',
            'published_at' => 'required|date'
        ];

        $messages = [
            'title.required' => 'this item must be filled !',
            'title.string' => 'this must be string',
            'slug.required' => 'this item must be filled',
            'slug.string' => 'this item must be string',
            'slug.unique' => 'this item must be unique',
            'image.required' => 'this item must be filled !',
            'image.image' => 'this item must be image',
            'image.mimes' => 'this item must be jpeg,png,jpg,gif,svg',
            'image.max' => 'image size must be less than 2MB',
            'thumbnail.required' => 'this item must be filled !',
            'thumbnail.image' => 'this item must be image',
            'thumbnail.mimes' => 'this item must be jpeg,png,jpg,gif,svg',
            'thumbnail.max' => 'image size must be less than 2MB',
            'body.required' => 'this item must be filled !',
            'body.string' => 'this item must be string',
            'published_at.required' => 'this item must be filled !',
            'published_at.date' => 'this item must be date',
        ];

        $validation_data = Validator::make($request->all(), $rules, $messages);

        if ($validation_data->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid data',
                'errors' => $validation_data->errors()
            ], 422);
        }

        // 1. Create blog record first (without images)
        $blog = Blog::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'image' => '',
            'thumbnail' => '',
            'body' => $request->body,
            'published_at' => $request->published_at,
        ]);

        // 2. Save image using blog ID as filename
        if ($request->hasFile('image')) {
            $image_name = $blog->id . '.' . $request->file('image')->getClientOriginalExtension();
            $image_path = $request->file('image')->storeAs('blogs/images', $image_name, 'public');
            $blog->image = $image_name;
        }

        // 3. Save thumbnail using blog ID as filename
        if ($request->hasFile('thumbnail')) {
            $thumbnail_name = $blog->id . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $thumbnail_path = $request->file('thumbnail')->storeAs('blogs/thumbnails', $thumbnail_name, 'public');
            $blog->thumbnail = $thumbnail_name;
        }

        // 4. Save updated blog record
        $blog->save();

        return $this->sendResponse(null, 'blog created successfully');
    }


    public function show($id)
    {
        $feature = Blog::findOrFail($id);
        return $this->sendResponse(new BlogResource($feature), 'blog show');

    }


    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|string',
            'slug' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'body' => 'required|string',
            'published_at' => 'required|date'
        ];

        $messages = [
            'title.required' => 'this item must be filled !',
            'title.string' => 'this must be string',
            'slug.required' => 'this item must be filled',
            'slug.string' => 'this item must be string',
            'slug.unique' => 'this item must be unique',
            'image.required' => 'this item must be filled !',
            'image.image' => 'this item must be image',
            'image.mimes' => 'this item must be jpeg,png,jpg,gif,svg',
            'image.max' => 'image size must be less than 2MB',
            'thumbnail.required' => 'this item must be filled !',
            'thumbnail.image' => 'this item must be image',
            'thumbnail.mimes' => 'this item must be jpeg,png,jpg,gif,svg',
            'thumbnail.max' => 'image size must be less than 2MB',
            'body.required' => 'this item must be filled !',
            'body.string' => 'this item must be string',
            'published_at.required' => 'this item must be filled !',
            'published_at.date' => 'this item must be date',
        ];

        $validation_data = Validator::make($request->all(), $rules, $messages);

        if ($validation_data->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'invalid data',
                'errors' => $validation_data->errors()
            ], 422);
        }

        $blog = Blog::findOrFail($id);

        if ($request->hasFile('image') && $blog->image) {
            Storage::disk('public')->delete('blogs/images/' . $blog->image);
        }

        if ($request->hasFile('thumbnail') && $blog->thumbnail) {
            Storage::disk('public')->delete('blogs/thumbnails/' . $blog->thumbnail);
        }

        if ($request->hasFile('image')) {
            $image_name = $blog->id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('blogs/images', $image_name, 'public');
            $blog->image = $image_name;
        }

        if ($request->hasFile('thumbnail')) {
            $thumbnail_name = $blog->id . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $request->file('thumbnail')->storeAs('blogs/thumbnails', $thumbnail_name, 'public');
            $blog->thumbnail = $thumbnail_name;
        }

        $blog->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body,
            'published_at' => $request->published_at,
        ]);

        return $this->sendResponse(null, 'blog updated successfully');
    }


    public function delete(int $id)
    {
        $feature = Blog::findOrFail($id);
        Storage::delete('blogs/images/' . $feature->image);
        $feature->delete();
        return response()->json(['success' => true, 'message' => 'feature deleted', 'data' => $feature], 200);
    }
}
