<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Professeur;
use App\Models\User;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session as FacadesSession;



class profController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('isLoggedIn');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function loginProf(Request $request)
    {
        if ($request->na == 'admin') {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'

            ]);
            $user = User::where("email", "=", $request->email)->first();
            if ($user) {

                if (Hash::check($request->password, $user->password)) {
                    $request->session()->put('user', $user->id);
                     return redirect('dashbord');


                } else {
                    return redirect()->back()->with("error", "Authentification incorrect");

                }
            } else {

                return redirect()->back()->with("error", "Authentification incorrect");
            }

  
        } else {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required'

            ]);

            $prof = Professeur::where("email", "=", $request->email)->first();
            if ($prof) {

                if (Hash::check($request->password, $prof->password)) {
                    $request->session()->put('Professeur', $prof->id);

                    return redirect('dashbord');

                } else {
                    return redirect()->back()->with("error", "Authentification incorrect");
                }
            } else {

                return redirect()->back()->with("error", "Authentification incorrect");

        }
    }
}

public function dashbord()
    {
        // $data = array();
        // if(Session::has('user')){
        //     $data = User::where('id','=', Session::get('user'))->first();
        // }

        // $data = array();
        // if(Session::has('Professeur')){
        //     $data = Professeur::where('id','=', Session::get('Professeur'))->first();
        // }
        return view('dashbord');

    }

}
