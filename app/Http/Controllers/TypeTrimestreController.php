<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\typeTrimestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TypeTrimestreController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLoggedIn');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $typeTrimestres = typeTrimestre::all();
        // return view ('admin.type-trimestres.liste',compact('typeTrimestres'));

        $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
        $typeTrimestres = DB::table('users')
        ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
        ->join('type_trimestres', 'ecoles.id', '=', 'type_trimestres.ecole_id')
        ->where('users.id', '=', $user_id)
        ->select('ecoles.nom as ecole_nom', 'type_trimestres.id as id', 'type_trimestres.nom as nom')
        ->orderby('id','desc')
        ->get();
        return view ('admin.type-trimestres.liste',compact('typeTrimestres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.type-trimestres.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            // 'nom' => 'required|unique:type_trimestres,nom',
            'nom' => 'required|unique:type_trimestres,nom,NULL,id,ecole_id,'.$request->ecole_id,

       ]);
       typeTrimestre::create($request->all());
       return back()->with("success","Type Trimestre ajouté avec succè!");
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
        $TypeTrimestres=typeTrimestre::find($id);

        return view ('admin.type-trimestres.edite',compact('TypeTrimestres'));

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
        $this->validate($request, [ 
            // 'nom' => 'required',
            'nom' => 'required|' . Rule::unique('type_trimestres')->ignore($id),

       ]);
        $TypeTrimestres = typeTrimestre::find($id);
         $TypeTrimestres->nom = $request->nom;

         $TypeTrimestres->update($request->all());
         return back()->with("success","TypeTrimestres mise à jour avec succè!");
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
