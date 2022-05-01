<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/Company/Get",
     *     tags={"Company"},
     *     operationId="7",
     *     summary="company index",
     *     description="",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     * )
     */
    public function index(Request $request)
    {
        switch ($request['sort']) {
            case 'date' :{
                $companies = Company::orderBy('created_at');
                break;
            }
            default:
                $companies = Company::all();
        }
        $companies = $request['limit'] ? $companies->limit($request['limit']) : $companies;
        return response($companies->get(),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/Company/Add",
     *     tags={"Company"},
     *     operationId="8",
     *     summary="Add company",
     *     description="",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:5|max:20|alpha_num',
            'category_id' => 'required|exists:categories,id',
            'email' => 'required|email:rfc|unique:companies,email',
            'phone' => 'required|digits_between:10,10',
            'description' => 'max:250',
            'website' => 'url'
        ]);
        $validated['user_id'] = auth('sanctum')->user()->id;
        $result = Company::create($validated);
        return response($result, $result ? 201 : 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/Company/Get/{id}",
     *     tags={"Company"},
     *     operationId="9",
     *     summary="Find Company By id",
     *     description="",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     * )
     */
    public function show($id)
    {
        $company = Company::find($id);
        return response($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put (
     *     path="/Company/Update/{id}",
     *     tags={"Company"},
     *     operationId="10",
     *     summary="Update company",
     *     description="",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:5|max:20|alpha_num',
            'category_id' => 'required|exists:categories,id',
            'phone' => 'required|digits_between:10,10',
            'description' => 'max:250',
            'website' => 'url'
        ]);
        $company = Company::find($id)->update($validated);
        return response($company == 1 ? 'true' : 'false', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete   (
     *     path="/Company/Delete/{id}",
     *     tags={"Company"},
     *     operationId="11",
     *     summary="Delete company",
     *     description="",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     * )
     */
    public function destroy($id)
    {
        $result = Company::find($id)->delete();
        return response(['message' => $result ? 'success' : 'failed', $result ? 200 : 404]);
    }
}
