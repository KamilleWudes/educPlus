@extends('layouts/master')
@section('contenu')
    <!--end row-->
    {{--  <form method="POST" action="{{ route('update_anneeScolaire', ['anneeScolaire' => $anneeScolaire->id]) }}">
        @csrf
        <input type="hidden" name="_method" value="put">
        <div class="row">
            <div class="col-xl-9 mx-auto">
                <h6 class="mb-0 text-uppercase">Formulaire de modification de l''année scolaire</h6>
                <hr />
                <div class="card border-top border-0 border-4 border-white">
                    <div class="card-body">
                        <div class="border p-4 rounded">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>
                                </div>
                                <h5 class="mb-0 text-white">Edition de l''année scolaire</h5>
                            </div>
                            <hr />
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Année Scolaire</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{ $anneeScolaire->anneeScolaire }}"
                                        class="form-control @error('anneeScolaire') is-invalid  @enderror"
                                        id="inputEnterYourName" name="anneeScolaire" placeholder="Entrer l'année Scolair">
                                    @error('anneeScolaire')
                                        <span class="error" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-pd-3">
                                    <button type="submit" class="btn btn-light pd-5 px-5">Register</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
        </div>
    </form>  --}}
@endsection
