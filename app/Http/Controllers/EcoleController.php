<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\SendEcoleRegistrationNotification;
use Illuminate\Support\Facades\File;



class EcoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLoggedSuperadmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        carbon::setLocale("fr");
        $ecoles= Ecole::all();
        return view ('admin.ecoles.liste',compact('ecoles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.ecoles.create');
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
            'nom' => 'required|unique:ecoles,nom',
            'telephone1' => 'required|numeric|unique:ecoles,telephone1',
            'telephone2' => 'nullable|numeric|unique:ecoles,telephone2',
            'adresse' => 'required',
            'email' => 'required|email|unique:ecoles,email',
            'image' => 'image|nullable|max:1999'

        ]);
        if ($request->hasFile('image')) {
            //1 : get File with ext
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //2 : get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                // 3 : GET JUSTE FILE EXTENSION
                $extension = $request->file('image')->getClientOriginalExtension();
            //4 : file name to store
            $fileNameTotore = $fileName.'_'.time().'.'.$extension;
 
            //uploader l'image
            $path = $request->file('image')->storeAs('public/images', $fileNameTotore);
        } else {
            $fileNameTotore = 'user.png';
        }
        // Ecole::create($request->all());
        // return back()->with("success","Ecole ajouté avec succè!");
        $ecoles = new Ecole();
        $ecoles->nom = $request->nom;
        $ecoles->telephone1 = $request->telephone1;
        $ecoles->telephone2 = $request->telephone2;
        $ecoles->adresse = $request->adresse;
        $ecoles->email = $request->email;
        $ecoles->image = $fileNameTotore;

        $ecoles->save();

        if($ecoles){

            // Notifiez l'école nouvellement créée
            $ecoles->notify(new SendEcoleRegistrationNotification($ecoles->nom));
        }
        return back()->with("success","Ecole ajouté avec succè!");
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
        $ecoles = Ecole::find($id);

         return view ('admin.ecoles.edite',compact('ecoles'));
    }

    public function detail($id)
    {
        $ecoles = Ecole::find($id);

        return view('admin.ecoles.detail', compact('ecoles'));
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
            'nom' => 'required|' . Rule::unique('ecoles')->ignore($id),
            'telephone1' => 'required|numeric|' . Rule::unique('ecoles')->ignore($id),
            'telephone2' => 'nullable|numeric|' . Rule::unique('ecoles')->ignore($id),
            'adresse' => 'required',
            'email' => 'required|email|' . Rule::unique('ecoles')->ignore($id),

         ]);
         $ecoles = Ecole::find($id);
         $ecoles->nom = $request->nom;
         $ecoles->telephone1 = $request->telephone1;
         $ecoles->telephone2 = $request->telephone2;
         $ecoles->adresse = $request->adresse;
         $ecoles->email = $request->email;
         if ($request->hasFile('image'))
         {
           $destination = 'public/images/'.$ecoles->image;
           if(File::exists($destination))
           {
               File::delete($destination);
           }
           $file = $request->file('image');

            $extension = $file->getClientOriginalExtension();

           $fileName = time().'.'.$extension;

           $file =  $request->file('image')->storeAs('public/images/',$fileName);
           $ecoles->image = $fileName;
         }
         $ecoles->update();

         return back()->with("success","Ecole modifié avec succè!");
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
