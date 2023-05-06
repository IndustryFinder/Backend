<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\IndexRequest;
use App\Http\Requests\Company\StoreRequest;
use App\Http\Requests\Company\UpdateRequest;
use App\Http\Requests\Company\UserRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CompanyController extends Controller
{
    public function index(IndexRequest $request)
    {
	    $validated= $request->validated();
		if (isset($validated['category_id'])){
			$company = Company::where('category_id',$validated['category_id']);
		}
		if (isset($validated['name'])){
			if (isset($company))
				$company = $company->where('name','like','%'.$validated['name'].'%');
			else
				$company = Company::where('name','like','%'.$validated['name'].'%');
		}
		if (!isset($company))
			$company = Company::query();

        if ($company!=null) {
            $company->with('user')->get();
            foreach ($company as $c) {
                if (auth('sanctum')->check())
                    $c['IsMarked'] = BookmarkController::IsMarked($c->id);
            }
        }
        $company = $company->paginate(24);
		return response($company);
    }

    public function user(UserRequest $request) {
        $validated= $request->validated();
        $company = Company::where('id',$validated['id'])->with('user')->get();
        return response()->json($company);
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
		$user= auth('sanctum')->user();
		if ($user->role=='company' || $user->role=='pro') {

            return response(['error'=>'already own company'],401);
        }
        $validated['user_id']=$user->id;
        if ($request->hasFile('logo')) {
            $image   =$request->file('logo');
            $filename=uniqid() . '.' . $image->getClientOriginalExtension();
            $location=public_path('storage/logos' . $filename);
            Image::make($image)->resize(300,300)->save($location);
            $validated['logo']=$filename;
        }
        $user['role']='company';
        $company=Company::create($validated);
        $user->save();
        $company->save();
        return response($company,201);
	}

    //do view count++
    public function show(Company $company)
    {
        if (!$company->is_active)
            return response(['message'=>'Not Found'],404);
        $company->ViewCount++;
        $company->save();
        $company->user_id=$company->User;
        return response()->json($company);
    }


    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
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
