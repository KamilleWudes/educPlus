<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\typeComposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class TypeCompositionController extends Controller
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
        // $typeCompositions= typeComposition::all();
        // return view ('admin.type-compositions.liste',compact('typeCompositions'));

        $user_id = Userid(); // Récupération de l'identifiant de l'utilisateur connecté
        $typeCompositions = DB::table('users')
        ->join('ecoles', 'users.ecole_id', '=', 'ecoles.id')
        ->join('type_compositions', 'ecoles.id', '=', 'type_compositions.ecole_id')
        ->where('users.id', '=', $user_id)
        ->select('ecoles.nom as ecole_nom', 'type_compositions.id as id', 'type_compositions.nom as nom')
        ->orderby('id','desc')
        ->get();
        return view ('admin.type-compositions.liste',compact('typeCompositions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.type-compositions.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //     $this->validate($request, [
    //         // 'nom' => 'required|unique:type_compositions,nom',
    //         'nom' => 'required|unique:type_compositions,nom,NULL,id,ecole_id,'.$request->ecole_id,

    //    ]); 
    $validator = Validator::make($request->all(), [
        'ecole_id' => 'required|exists:ecoles,id',
        'nom' => [
            'required',
            Rule::unique('type_compositions')->where(function ($query) use ($request) {
                 $query->where('ecole_id', $request->ecole_id);
            })
        ]
    ]);
    
    if ($validator->fails()) {
        return redirect()->back()->with('error', 'La validation a échoué. Veuillez vérifier vos données.');
    }
    
       typeComposition::create($request->all());
       return back()->with("success","Type composition ajouté avec succè!");
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
        $typeCompositions = typeComposition::find($id);

        return view ('admin.type-compositions.edite',compact('typeCompositions'));

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
        $this->validate($request,[
            // 'nom' => 'required|unique:type_compositions,nom',
            'nom' => 'required|' . Rule::unique('type_compositions')->ignore($id),

         ]);
         $typeCompositions = typeComposition::find($id);
         $typeCompositions->nom = $request->nom;

         $typeCompositions->update();
         return back()->with("success","Type Compositions modifié avec succè!");
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
