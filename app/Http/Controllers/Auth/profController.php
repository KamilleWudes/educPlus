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
use App\Models\Ecole;




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
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            if ($request->na == 'admin') {
                $user = User::where("email", $request->email)->first();
                if ($user && Hash::check($request->password, $user->password)) {
                    $request->session()->put('user', $user->id);
                    return redirect('dashbord');
                }
            } else {
                $request->validate([
                    'ecole_id' => 'required',
                ]);
    
                $prof = Professeur::where("email", $request->email)->first();

                if ($prof && Hash::check($request->password, $prof->password)) {
                    // Vérification de l'école du professeur ici
                    $chosen_ecole_id = $request->input('ecole_id');
                        $chosen_ecole = Ecole::find($chosen_ecole_id);
                        if ($chosen_ecole) {
                            $prof = Professeur::with(['ecoles' => function ($query) use ($chosen_ecole_id) {
                                $query->where('ecole_id', $chosen_ecole_id);
                            }])->where("email", $request->email)->first();
                        
                            if ($prof && Hash::check($request->password, $prof->password) && $prof->ecoles->count() > 0) {
                                $request->session()->put('ecole_id', $chosen_ecole_id);
                                $request->session()->put('ecole_nom', $chosen_ecole->nom);
                                $request->session()->put('Professeur', $prof->id);
                                return redirect('dashbord');
                            }}
                }
            }
    
            return redirect()->back()->with("error", "Authentification incorrecte");
        }
}

public function dashbord()
    {
        return view('dashbord');
    }

}
