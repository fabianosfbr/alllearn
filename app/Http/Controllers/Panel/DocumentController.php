<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {


        return view('web.default.panel.financial.document');
    }


    public function selectSearch(Request $request)
    {
    	$users = User::all();
       /*  if($request->has('q')){
            $search = $request->q;
            $users = User::select("id", "name")
            		->where('name', 'LIKE', "%$search%")
            		->get();
        } */
        //return response()->json($users);
        return 'dados';
    }
}
