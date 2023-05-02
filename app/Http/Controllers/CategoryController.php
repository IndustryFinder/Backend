<?php
namespace App\Http\Controllers;

use App\Http\Requests\Category\makeCategoryRequest;
use App\Http\Requests\Category\UpdateRequest;
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

    //need admin panel to refactor
    public function makeCategory(makeCategoryRequest $request) {
        $validated = $request->validated();

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
        return response(['message' => 'unauthorised'], 401);
    }
    // need admin panel to refactor
    public function delete(Category $category){
        $category->delete();
        return response()->json(['success'=>'Category deleted'],200);
    }


    public function update(UpdateRequest $request,Category $category){
        $validated = $request->validated();
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
            if ($category==null){
                return response()->json(['error'=>'Category not found'],404);
            }
            $category->update($validated);
            $category->save();
            return response()->json(['success'=>'Category update'],200);
        }

        return response(['message' => 'unauthorised'], 401);
    }
}
