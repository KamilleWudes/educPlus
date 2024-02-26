<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use App\Models\userprincipal;
use Illuminate\Support\Facades\Hash;
use App\Models\Etudiant;
use App\Models\inscription;
use Illuminate\Support\Facades\DB;
use App\Models\Ecole;
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
    public function zoneEtude()
    { 
        return view('space-etudiant');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function NoteLogins(Request $request)
    // {
    //     $request->validate([
    //         'matricule' => 'required',
    //     ]);
    
    //     $matricule = $request->matricule;
    
    //     $etudiant = Etudiant::where('matricule', $matricule)->first(); ///rrkrlrklrkllkr
    
    //     if ($etudiant) {
    //         $request->session()->put('Etudiant', $etudiant->id);
    //         return redirect('Note-etudiant');
    //     } else {
    //         // Matricule invalide, renvoyez un message d'erreur
    //         return redirect()->back()->with("error", "Authentification incorrect");
    //     }
    // }
    public function NoteLogins(Request $request)
{
    $request->validate([
        'matricule' => 'required',
    ]);

    $matricule = $request->matricule;

    // Recherche de l'étudiant dans la table Inscription et sélection de la plus récente
    $inscription = Inscription::whereHas('etudiant', function ($query) use ($matricule) {
        $query->where('matricule', $matricule);
    })->latest('annee_scolaire_id')->first();

    if ($inscription) {
        // Si l'inscription est trouvée, stockez l'ID de l'étudiant dans la session
        $request->session()->put('Etudiant', $inscription->etudiant->id);
        return redirect('Note-etudiant');
    } else {
        // Matricule invalide, renvoyez un message d'erreur
        return redirect()->back()->with("error", "Authentification incorrecte");
    }
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
                    return redirect('home');


                } else {
                    return redirect()->back()->with("error", "Authentification incorrect");

                }
            }else{

                return redirect()->back()->with("error", "Authentification incorrect");
            }

}          
public function dashbord()
    {
        
    $ecoles= Ecole::orderBy('id', 'desc')->take(4)->get();
    $users= User::orderBy('id', 'desc')->take(4)->get();

        return view('home',compact('ecoles','users'));
    }    



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    



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


