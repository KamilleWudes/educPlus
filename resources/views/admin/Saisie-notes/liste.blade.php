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
                            <li class="breadcrumb-item active" aria-current="page">Saisie de notes</li>
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
            <h6 class="mb-0 text-uppercase">Listes des Notes</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Numero</th>
                                    <th style="text-align:center">Composition</th>
                                    <th style="text-align:center">Etudiant</th>
                                    <th style="text-align:center">Matière</th>
                                    <th style="text-align:center">Note</th>
                                    <th style="text-align:center">Professeur</th>
                                    <th style="text-align:center">Détail</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--  @foreach ($tuteurs as $tuteur)
                                    <tr>
                                        <td style="text-align:center">{{ $tuteur->tuteurs_id }}</td>
                                        <td style="text-align:center">{{ $tuteur->prenoms }} {{ $tuteur->noms }}</td>
                                        <td style="text-align:center">
                                            @if ($tuteur->sex == 'F')
                                                F
                                            @else
                                                M
                                            @endif
                                        </td>
                                        <td style="text-align:center">{{ $tuteur->adresses }}</td>

                                        <td style="text-align:center">{{ $tuteur->etudiant_prenom }} {{ $tuteur->etudiant_nom }}</td>


                                        <td style="text-align:center"><a href="{{ url('detail=' . $tuteur->id) }}"><button type="button"
                                            class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a></td>

                                        <td>

                                            <div class="d-flex order-actions">
                                                <a href="{{ url('etudiant=' . $tuteur->id) }}" class=""><i
                                                    class='bx bxs-edit' style="text-align:center"></i></a>

                                            <a href="{{ route('delete_etudiant', $tuteur->id) }}" id="btn-hapus" data-id="{{ $tuteur->id }}" nom-id="{{ $tuteur->noms }}" prenom-id="{{ $tuteur->prenoms }}" class="ms-4"><i class='bx bxs-trash'
                                                    style="text-align:center"></i></a>

                                            </div>

                                        </td>

                                    </tr>
                                @endforeach  --}}

                                </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
