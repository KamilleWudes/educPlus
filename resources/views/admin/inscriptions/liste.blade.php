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
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Inscriptions</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-light">Settings</button>
                        <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                                href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                link</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Listes des Inscriptions</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    {{--  <th style="text-align:center">Numero</th>  --}}
                                    <th style="text-align:center">Matricule</th>
                                    <th style="text-align:center">Année Scolaire</th>
                                    <th style="text-align:center">Date d''inscription</th>
                                    <th style="text-align:center">Etudiant</th>
                                    <th style="text-align:center">classes</th>
                                    <th style="text-align:center">Tuteurs</th>
                                    <th style="text-align:center">Télephone Tuteur</th>
                                    <th style="text-align:center">Détail</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>




                                @foreach ($inscriptions as $inscription)
                                    <tr>
                                        {{--  <td style="text-align:center">{{ $inscription->id }}</td>  --}}
                                      <td style="text-align:center">{{ $inscription->matricule }}</td>
                                        <td style="text-align:center">{{ $inscription->annee1}} - {{ $inscription->annee2}}</td>
                                        <td style="text-align:center">{{ $inscription->date_insription }}</td>
                                        <td style="text-align:center">{{ $inscription->etudiant_prenom }} {{ $inscription->etudiant_nom }}</td>
                                        <td style="text-align:center">{{ $inscription->classe_nom}}</td>
                                        <td style="text-align:center">{{ $inscription->tuteur_prenoms }} {{ $inscription->tuteur_nom }}</td>
                                        <td style="text-align:center">{{ $inscription->tuteur_telephone1 }} / {{ $inscription->tuteur_telephone2 }}</td>

                                        {{--  <td style="text-align:center">{{ $inscription->created_at->diffForHumans() }}</td>  --}}

                                            <td style="text-align:center">
                                                <button type="button"
                                                class="btn btn-light btn-sm radius-30 px-4">View Details</button>
                                            </td>

                                        <td>
                                            <div class="d-flex order-actions" style="margin:2%">
                                                <a href="{{ url('inscription=' . $inscription->id) }}" class=""><i
                                                    class='bx bxs-edit' style="text-align:center"></i></a>
                                                <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'
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
        </div>
    </div>
@endsection
