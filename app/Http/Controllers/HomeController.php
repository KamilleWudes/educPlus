<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Illuminate\Contracts\Session\Session;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Session;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    // public function welcome()
    // {
    //     $data = array();
    //     if(Session::has('user')){
    //         $data = User::where('id','=', Session::get('user'))->first();
    //     }
    //     return view('welcome', compact('data'));

    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // $data = array();
        // if(Session::has('user')){
        //     $data = User::where('id','=', Session::get('user'))->first();
        // }
        $ecoles = Ecole::orderBy("id","Desc")->get();

        return view('welcome',compact('ecoles'));
    }

}


?>
