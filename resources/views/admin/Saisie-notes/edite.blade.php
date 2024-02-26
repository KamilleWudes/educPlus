@extends('layouts/master')
@section('contenu')
<form class="row g-3" method="POST" action="{{ url('update_note/' . $notes->id) }}">
    @csrf
    @method('PUT')
        <div class="col-12" <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('saisi-note') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edition des notes</li>
                        </ol>
                    </nav>
                </div>
              
            </div>
            <!--end breadcrumb-->
            <h6 id="matiereChoisie" class="mb-0 text-uppercase">Editions des Notes</h6>
            <hr />
<div id="stepper1" class="bs-stepper">
  <div class="card">

	<div class="card-body">
	
	  <div class="bs-stepper-content">

		  <div id="test-l-4" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger4">
			<h5 class="mb-1">Edition Note de: {{ $notes->inscription->etudiant->nom }} {{ $notes->inscription->etudiant->prenom }}</h5>
			<p class="mb-4">Matricule: {{ $notes->inscription->etudiant->matricule }}</p>

			<div class="row g-3">
				<div class="col-12 col-lg-4">
					<label for="Experience1" class="form-label">Année Scolaire</label>
					<input type="text" class="form-control" id="annee" placeholder="Année Scolaire" value="{{ $notes->anneeScolaire->annee1 }}- {{ $notes->anneeScolaire->annee2 }}">
				</div>
				<div class="col-12 col-lg-4">
					<label for="Position1" class="form-label">Type Trimestre</label>
					<input type="text" class="form-control" id="Tri" placeholder="Type Trimestre" value="{{$notes->typeTrimestre->nom }}" >
				</div>
				<div class="col-12 col-lg-4">
					<label for="Experience2" class="form-label">Type Composition</label>
					<input type="text" class="form-control" id="comp" placeholder="Type Composition" value="{{ $notes->typeComposition->nom }}">
				</div>
				<div class="col-12 col-lg-4">
					<label for="PhoneNumber" class="form-label">Classe</label>
					<input type="text" class="form-control" id="classe" placeholder="Classe"value="{{ $notes->classe->nom }}">
				</div>
				<div class="col-12 col-lg-4">
					<label for="Experience3" class="form-label">Matière</label>
					<input type="text" class="form-control" id="mat" placeholder="Matière" value="{{ $notes->matiere->nom }}">
				</div>
				<div class="col-12 col-lg-4">
					<label for="PhoneNumber" class="form-label">Note</label>
					<input type="text" class="form-control @error('note') is-invalid  @enderror" id="note" name="note" placeholder="Note" value="{{ $notes->note }}">
                    @error('note')
                    <span class="error" style="color:red">{{ $message }}</span>
                @enderror
				</div><br>
				<div class="col-12">
					<div class="d-flex align-items-center gap-3">
                        <a href="{{ route('saisi-note') }}"> <button type="button" class="btn btn-danger px-5"
                            onclick="error_noti()"><i class="bx bx-x-circle mr-1"></i> Annuler</button> </a>
                            <button type="submit" class="btn btn-primary px-5" id="flash"
                                    data-flash="{!! session()->get('success') !!}"><i
                                        class="bx bx-check-circle mr-1"></i>Valider la modification</button>
                           		</div>
				</div>
			</div><!---end row-->
			
		  </div>
	  </div>
	   
	</div>
   </div>
 </div>
</div>
</form>

@endsection

@push('editNote')
<script>
        document.getElementById("annee").readOnly = true;
        document.getElementById("Tri").readOnly = true;
        document.getElementById("comp").readOnly = true;
        document.getElementById("classe").readOnly = true;
        document.getElementById("mat").readOnly = true;
        


</script>
    
@endpush
