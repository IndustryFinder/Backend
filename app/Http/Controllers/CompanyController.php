<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
	    $validated= $request->validate([
		    'id'=>'number',
		    'user'=>'number',
		    'category'=>'numeric',
		    'text'=>'string|nullable',
	    ]);
		if (isset($validated['id'])) {
			$company = Company::find($validated['id']);
			$company->user_id=$company->User;
			return response()->json($company);
		}
		if (isset($validated['user'])) {
			$company = Company::whereUserId($validated['user']);
			return response()->json($company);
		}
		if (isset($validated['category'])){
			$company = Company::where('category_id',$validated['category']);
		}
		if (isset($validated['text'])){
			if (isset($company))
				$company = $company->where('name','like','%'.$validated['text'].'%');
			else
				$company = Company::where('name','like','%'.$validated['text'].'%');
		}
		if (isset($company))
			$company = $company->where('is_active', 1)->paginate(24);
		else
			$company = Company::where('is_active', 1)->paginate(24);
		foreach ($company as $c){
			$c->user_id=$c->User;
		}
		return response($company);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:5|max:20|alpha_num',
            'category_id' => 'required|exists:categories,id',
            'email' => 'required|email:rfc|unique:companies,email',
            'phone' => 'required|min:10',
            'description' => 'max:250',
            'website' => 'string|max:50',
			'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
		$user= auth('sanctum')->user();
		if ($user->role=='company' || $user->role=='pro') {
			$validated['user_id']=$user->id;
			if ($request->hasFile('logo')) {
				$image   =$request->file('logo');
				$filename=uniqid() . '.' . $image->getClientOriginalExtension();
				$location=public_path('storage/logos' . $filename);
				Image::make($image)->resize(300,300)->save($location);
				$validated['logo']=$filename;
			}
			$company=Company::create($validated);
			return response($company,201);
		}
		return response(['error'=>'Unauthorized'],401);
	}


    public function show($id)
    {
        $company = Company::find($id);
		$company=$company->is_active ? $company : null;
        return response($company?:['message'=>'Not Found'],$company?200:404);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
	        'name' => 'required|min:5|max:20|alpha_num',
	        'category_id' => 'required|exists:categories,id',
	        'email' => 'required|email:rfc|unique:companies,email',
	        'phone' => 'required|digits_between:10,10',
	        'description' => 'max:250',
	        'website' => 'url',
	        'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
	    if ($request->hasFile('logo')) {
		    $image = $request->file('logo');
		    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
		    $location = public_path('storage/logos' . $filename);
		    Image::make($image)->resize(300, 300)->save($location);
		    $validated['logo'] = $filename;
	    }
        $company = Company::find($id)->update($validated);
        return response(['message' => $company == 1 ? 'success' : 'failed'], $company == 1 ? 201 : 500);
    }


    public function destroy($id)
    {
        $result = Company::find($id)->update(['is_active' => 0]);
        return response(['message' => $result ? 'success' : 'failed', $result ? 200 : 404]);
    }
}
