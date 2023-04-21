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
                            <li class="breadcrumb-item active" aria-current="page">Etudiants</li>
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
            <h6 class="mb-0 text-uppercase">Listes des Etudiants Supprimés</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Index</th>
                                    <th style="text-align:center">Numero</th>
                                    <th style="text-align:center">Nom</th>
                                    <th style="text-align:center">Sexe</th>
                                    <th style="text-align:center">Adresse</th>
                                    <th style="text-align:center">Ajouté</th>
                                    <th style="text-align:center">Détail</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($etudiants as $etudiant)
                                    <tr>
                                        <td style="text-align:center">{{$loop->index+1}}</td>
                                        <td style="text-align:center">{{ $etudiant->id }}</td>
                                        <td style="text-align:center">{{ $etudiant->prenom }} {{ $etudiant->nom }}</td>
                                        <td style="text-align:center">
                                            @if ($etudiant->sexe == '1')
                                                F
                                            @else
                                                M
                                            @endif
                                        </td>
                                        <td style="text-align:center">{{ $etudiant->adresse }}</td>
                                        <td style="text-align:center">{{ $etudiant->created_at->diffForHumans()}}</td>
                                        {{--  <td style="text-align:center">{{ $etudiant->inscription->classe->nom }}</td>  --}}
                                        {{--  <td style="text-align:center">{{ $bulletin->inscription->etudiant->prenom }} {{ $bulletin->inscription->etudiant->nom }}</td>  --}}

                                        {{--  <td>{{ $etudiant->inscription->implode('classe_id') }}</td>  --}}

                                        <td style="text-align:center"><a href="{{ url('detail=' . $etudiant->id) }}"><button type="button"
                                            class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a></td>
                                        <td>

                                            <a href="{{ url('etudiant-restore/'. $etudiant->id) }}"><button type="button" id="flash"
                                                data-flash="{!! session()->get('success') !!}"
                                                class="btn btn-light btn-sm radius-30 px-4"> Restaurer</button></a></td>

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
