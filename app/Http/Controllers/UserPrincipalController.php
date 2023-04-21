<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userprincipal;
use Illuminate\Support\Facades\Hash;

class UserPrincipalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userPrincipals= userprincipal::all();
        return view('accueil',compact('userPrincipals'));
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

    public function loginSuperAdmin(Request $request)
    {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'

            ]);
           $users = userprincipal::where("email", "=", $request->email)->first();
            if ($users) {

                if (Hash::check($request->password, $users->password)) {
                    $request->session()->put('userprincipal', $users->id);
                    return redirect('dashbord');


                } else {
                    return redirect()->back()->with("error", "Authentification incorrect");

                }
            }else{

                return redirect()->back()->with("error", "Authentification incorrect");
            }

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
}


