<?php
namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function Categories(){
        $categories=Category::all();
        return response(['categories'=>$categories]);
    }

    public function makeCategory(Request $request) {
        $validated = $request->validate([
            'name' => 'required|min:5|max:50',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $validated['sender']=auth('sanctum')->user()->id;
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename=uniqid() . '.' . $image->getClientOriginalExtension();
            $location=public_path('storage/AdPhoto'.$filename);
            Image::make($image)->resize(300,300)->save($location);
            $validated['photo']=$filename;
        }
        $category = Category::create($validated);
        return response($category, $category ? 201 : 500);
    }

    public function delete($id){
        $Category=Category::find($id);
        if ($Category==null){
            return response()->json(['error'=>'Category not found'],404);
        }
        $Category->update();
        return response()->json(['success'=>'Category deleted'],200);
    }
}
