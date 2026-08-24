<?php

namespace Modules\Home\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Home\Models\Banner;
use Modules\Shared\Http\Controllers\Api\BaseResponderController;
class AdminBannerController extends BaseResponderController
{
    public function getBanner(){
        $banner = Banner::latest();
        return $this->sendResponse($banner,'Banner list');
    }
    public function store(Request $request){
        $rules = [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $messages = [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'image.required' => 'The image field is required.',
            'image.image' => 'The image must be a image.',
            'image.mimes' => 'The image must be a file.',
            'image.max' => 'The image may not be greater than 2MB.'
        ];
        $validated_data = Validator::make($request->all(),$rules,$messages);
        if($validated_data->fails()) {
            return $this->sendError('Validation Error.', $validated_data->errors());
        }
        $banner=Banner::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => ''
        ]);
        if($request->hasFile('image')){
            $image_name = $banner->id.'.'.$request->file('image')->getClientOriginalExtension();
            $image_path = $request->file('image')->storeAs('banner/images',$image_name,'public');
            $banner->image = $image_name;
        }
        $banner->save();
        return $this->sendResponse($banner,'Banner added successfully');
    }
    public function update(Request $request,$id){
        $rules = [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $messages = [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'image.required' => 'The image field is required.',
            'image.image' => 'The image must be a image.',
            'image.mimes' => 'The image must be a file.',
            'image.max' => 'The image may not be greater than 2MB.'
        ];
        $validated_data = Validator::make($request->all(),$rules,$messages);
        if($validated_data->fails()) {
            return $this->sendError('Validation Error.', $validated_data->errors());
        }
        $banner=Banner::findOrFail($id);
        if($request->hasFile('image')){
            Storage::disk('public')->delete('banner/images',$banner->image);
        }
        if($request->hasFile('image')){
            $image_name = $banner->id.'.'.$request->file('image')->getClientOriginalExtension();
            $image_path = $request->file('image')->storeAs('banner/images',$image_name,'public');
            $banner->image = $image_name;
        }
        $banner->update([
            'title' => $request->title,
            'description' => $request->description,

        ]);
        return $this->sendResponse($banner,'Banner updated successfully');
    }
    public function delete($id){
        $banner = Banner::findOrFail($id);
        Storage::disk('public')->delete('banner/images',$banner->image);
        $banner->delete();
        return $this->sendResponse(null,'Banner deleted successfully');
    }

}
