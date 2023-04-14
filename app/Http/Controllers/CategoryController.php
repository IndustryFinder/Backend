<?php
namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::all();
        return response(['categories'=>$categories]);
    }

    public function makeCategory(Request $request) {
        $validated = $request->validate([
            'name' => 'required|min:5|max:50',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
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

    public function delete(Category $category){
        $category->delete();
        return response()->json(['success'=>'Category deleted'],200);
    }

    public function update(Request $request,$id){
        $validated = $request->validate([
            'name' => 'required|min:5|max:50',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $Category=Category::find($id);
        $iduser=auth('sanctum')->user()->id;
        $user=User::find($iduser);
        if($user->role == 'admin'){
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $filename=uniqid() . '.' . $image->getClientOriginalExtension();
                $location=public_path('storage/AdPhoto'.$filename);
                Image::make($image)->resize(300,300)->save($location);
                $validated['photo']=$filename;
            }
            $category = Category::find($id);
            if ($category==null){
                return response()->json(['error'=>'Category not found'],404);
            }
            $Category->update($validated);
            return response()->json(['success'=>'Category update'],200);
        }
        return response(['message' => 'unauthorised'], 401);
    }
}
