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
                            <li class="breadcrumb-item active" aria-current="page">Responsable</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                   
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Listes des Responsables</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="ms-auto"><a href="{{ route('addutilisateur') }}" class="btn btn-light radius-30 mt-2 mt-lg-0"
                            data-bs-toggle="" data-bs-target=""><i
                                class="bx bxs-plus-square"></i>Nouveau Responsable</a></div>
                    </div><br>
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Numero</th>
                                    <th style="text-align:center">Nom du responsable</th>
                                    <th style="text-align:center">ECole D'appartenance</th>
                                    {{-- <th style="text-align:center">Adresse</th> --}}
                                    <th style="text-align:center">Ajouté</th>
                                    <th style="text-align:center">Détail</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td style="text-align:center">{{ $user->id }}</td>
                                        <td style="text-align:center">{{ $user->prenom }} {{ $user->name }}</td>

                                        <td style="text-align:center">{{ optional($user->ecoles)->nom }} </td>

                                        {{-- <td style="text-align:center">{{ $user->adresse }}</td> --}}


                                        <td style="text-align:center">{{ $user->created_at->diffForHumans()}}</td>


                                        <td style="text-align:center"><a href="{{ url('detail-responsable=' . $user->id) }}"><button type="button"
                                            class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a></td>

                                        <td>

                                            <div class="d-flex order-actions d-flex justify-content-center">
                                                <a href="{{ url('responsable=' . $user->id) }}" class=""><i
                                                    class='bx bxs-edit' style="text-align:center"></i></a>

                                            <a href="" id="btn-hapus" data-id="{{ $user->id }}" nom-id="{{ $user->nom }}" prenom-id="{{ $user->prenom }}" class="ms-4"><i class='bx bxs-trash'
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
