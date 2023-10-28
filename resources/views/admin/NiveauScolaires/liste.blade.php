@extends('layouts/master')
@section('contenu')
    <div class="col-12" <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('getHome') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Niveau Scolaire</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                

                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Liste des Niveaux Scolaires</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="ms-auto"><a href="javascript:;" class="btn btn-light radius-30 mt-2 mt-lg-0"
                                data-bs-toggle="modal" data-bs-target="#exampleDarkModal"><i
                                    class="bx bxs-plus-square"></i>Nouvelle Niveaux Scolaires</a></div>
                                    @include ('admin.NiveauScolaires.create')
                             </div>

                    <br> <br>
                    <table id="example2" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align:center">Numero</th>
                                <th style="text-align:center">Niveau Scolaires</th>
                                <th style="text-align:center">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($NiveauScolaires as $NiveauScolaire)
                                <tr>
                                    <td style="text-align:center">{{ $NiveauScolaire->id }}</td>
                                        <td style="text-align:center">{{ $NiveauScolaire->nom }}
 
                                    <td>
                                        <div class="d-flex order-actions d-flex justify-content-center">
                                          
                                        <a href="{{ url('NiveauScolaires=' . $NiveauScolaire->id) }}" class="ms-1"
                                                        data-bs-toggle="modal" data-bs-target="#exampleDarkModals{{ $NiveauScolaire->id }}"><i class='bx bxs-edit'
                                                            style="text-align:center"></i></a>
                                                    @include('admin.NiveauScolaires.edite', ['NiveauScolaireId' => $NiveauScolaire->id])
                                                    <a href="{{ route('delete_NiveauScolaires', $NiveauScolaire->id) }}" id="btn-hapus" data-id="{{ $NiveauScolaire->id }}" nom-id="{{ $NiveauScolaire->nom }}" prenom-id="{{ $NiveauScolaire->prenom }}" class="ms-4"><i class='bx bxs-trash'
                                                style="text-align:center"></i></a>
                                        </div>

                                    </td>
                                  
                                </tr>
                            @endforeach

                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endsection
