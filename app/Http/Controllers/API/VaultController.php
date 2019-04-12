<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vault;

class VaultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$user = auth('api')->user();

        //$contacts = Vault::latest()->paginate(10);
        
                
        //return response()->json($contacts);


        
        // $contacts = array(
        //     'id' => '65445',
        //     'user_name' => 'jsdjfj',
        //     'user_id' => auth('api')->user()->id
        // );
        
        // return ($contacts);
        
        //return Vault::latest()->paginate(10);
        
        
        return Vault::where('user_id', '=', auth('api')->user()->id)->latest()->paginate(10);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'site_name' => 'required|string|max:191',
            'user_name' => 'required|string|max:191',
            'password' => 'required|string|max:191'
        ]);

        return Vault::create([
            'user_id' => auth('api')->user()->id,
            'site_name' => $request['site_name'],
            'user_name' => $request['user_name'],
            'password' => $request['password'],
            'opt_one' => $request['opt_one'],
            'opt_two' => $request['opt_two'],
            'remarks' => $request['remarks'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $vault = Vault::findOrFail($id);

        $this->validate($request,[
            'site_name' => 'required|string|max:191',
            'user_name' => 'required|string|max:191',
            'password' => 'required|string|max:191'
        ]);

        $vault->update($request->all());
        return ['message' => 'Updated this info !'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $vault = Vault::findOrFail($id);
        // delete the user

        $vault->delete();

        return ['message' => 'Info Deleted'];
    }

    public function search(){

        if ($search = \Request::get('q')) {
            $users = Vault::where(function($query) use ($search){
                $query->where('user_id', '=', auth('api')->user()->id)
                        ->orWhere('site_name','LIKE',"%$search%")
                        ->orWhere('user_name','LIKE',"%$search%")
                        ->orWhere('password','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $users = Vault::where('user_id', '=', auth('api')->user()->id)->latest()->paginate(10);
        }

        return $users;

    }
}
