<?php
namespace Modules\Home\Http\Controllers\Api\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Home\Models\Feature;
use Modules\Shared\Http\Controllers\Api\BaseResponderController;

class AdminFeatureController extends BaseResponderController {
    public function getFeatures(){
        $features = Feature::all();
        return $this->sendResponse($features,'list of features');
    }
    public function store(Request $request){
        $rules = ['title' => 'required|string','icon' => 'required|string'];
        $attributes = ['name.required' => 'this item must be filled !','icon.string'=>'this item must be number'];
        $validation_data=Validator::make($request->all(),$rules,$attributes);
        if($validation_data->fails()){
            return response()->json(['success' => false , 'message' => 'invalid data' , 'errors' => $validation_data->errors()],422);
        }
        $features = new Feature;
        $features->create([
            'title' => $request->title,
            'icon' => $request->icon,
        ]);
        return $this->sendResponse(null,'feature created successfully');
    }
    public function show($id)
    {
        $feature = Feature::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Feature loaded successfully',
            'data' => $feature
        ], 200);
    }


    public function update(Request $request,$id){
        $rules = ['title' => 'required|string','icon' => 'required|string'];
        $attributes = ['name.required' => 'this item must be filled !'];
        $validation_data=Validator::make($request->all(),$rules,$attributes);
        if($validation_data->fails()){
            return response()->json(['success' => false , 'message' => 'invalid data' , 'errors' => $validation_data->errors()],422);
        }
        $feature = Feature::findOrFail($id);
        $feature->update([
            'title' => $request->title,
            'icon' => $request->icon,
        ]);
        return $this->sendResponse($feature->fresh(),'feature updated successfully');
    }
    public function delete(int $id){
        $feature = Feature::findOrFail($id);
        $feature->delete();
        return $this->sendResponse($feature,'feature deleted successfully');
    }
}
