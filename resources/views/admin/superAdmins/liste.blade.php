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
                            <li class="breadcrumb-item active" aria-current="page">Utilisateur</li>
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
            <h6 class="mb-0 text-uppercase">Listes des Utilisateurs</h6>
            <hr />
            <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="ms-auto"><a href=" {{ route('addSuperAdmin') }}" class="btn btn-light radius-30 mt-2 mt-lg-0"
                                    data-bs-toggle="" data-bs-target=""><i
                                        class="bx bxs-plus-square"></i>Nouvel Utilisateur</a></div>
                        </div>
                        <br>
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    {{--  <th style="text-align:center">Index</th>  --}}
                                    <th style="text-align:center">Numero</th>
                                    <th style="text-align:center">Nom</th>
                                    <th style="text-align:center">Email</th>
                                    <th style="text-align:center">Télephone</th>
                                    <th style="text-align:center">Détail</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($SuperAdmins as $data)
                                <tr>
                                    <td style="text-align:center">{{ $data->id }}</td>
                                    <td style="text-align:center">{{ $data->prenom }} {{ $data->nom }}</td>

                                    <td style="text-align:center">{{ $data->email }}</td>


                                    <td style="text-align:center">{{ $data->telephone }}</td>


                                    <td style="text-align:center"><a href="{{ url('detail=' . $data->id) }}"><button type="button"
                                        class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a></td>

                                    <td>

                                        <div class="d-flex order-actions">
                                            <a href="{{ url('utilisateur=' . $data->id) }}" class=""><i
                                                class='bx bxs-edit' style="text-align:center"></i></a>

                                        <a href="" id="btn-hapus" data-id="{{ $data->id }}" nom-id="{{ $data->nom }}" prenom-id="{{ $data->prenom }}" class="ms-4"><i class='bx bxs-trash'
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
