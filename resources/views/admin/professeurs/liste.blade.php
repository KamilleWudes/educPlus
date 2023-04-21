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
                            <li class="breadcrumb-item active" aria-current="page">Liste Professeur</li>
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
            <h6 class="mb-0 text-uppercase">Listes des Professeurs</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Numero</th>
                                    <th style="text-align:center">Nom</th>
                                    <th style="text-align:center">Sexe</th>
                                    <th style="text-align:center">Adresse</th>
                                    <th style="text-align:center">Télephone</th>

                                    <th style="text-align:center">Détail</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($professeurs as $professeur)
                                    <tr>
                                        <td style="text-align:center">{{ $professeur->id }}</td>
                                        {{--  <td> <img src="/storage/images/{{$professeur->image}}" style="width:60px;height:60px;">
                                            </td>  --}}
                                        {{--  <td>
                                                @if ($professeur->image != '' || $professeur->image != null)
                                                <img src="{{ asset('storage/'.$professeur->image)}}" style="width:60px;height:60px;">

                                                @else
                                                <img src="{{ asset('images/placeholderImage.png') }}" style="width:60px;height:60px;">

                                                @endif
                                            </td>  --}}

                                        <td style="text-align:center">{{ $professeur->prenom }} {{ $professeur->nom }}</td>
                                        <td style="text-align:center">
                                            @if ($professeur->sexe == "1")
                                                H
                                            @else
                                                F
                                            @endif
                                        </td>
                                        {{--  <input type="hidden" class="serdelete_val_id" value={{ $professeur->id }}>  --}}
                                        <td style="text-align:center">{{ $professeur->adresse }}</td>
                                        <td style="text-align:center">{{ $professeur->telephone1 }}</td>

                                        <td style="text-align:center"><a href="{{ url('detail=' . $professeur->id) }}"><button type="button"
                                                class="btn btn-light btn-sm radius-30 px-4"> Voir Détail</button></a></td>

                                        <td>
                                            @if (count($professeur->bulletin) == 0)
                                                <div class="d-flex order-actions">

                                                    <a href="{{ url('professeur=' . $professeur->id) }}" class=""><i
                                                            class='bx bxs-edit' style="text-align:center"></i></a>

                                                    <a href="{{ route('delete_professeur', $professeur->id) }}" id="btn-hapus" data-id="{{ $professeur->id }}" nom-id="{{ $professeur->nom }}" prenom-id="{{ $professeur->prenom }}" class="ms-4"><i class='bx bxs-trash'
                                                            style="text-align:center"></i></a>
                                                            {{--  <form id="form-{{ $professeur->id }}" method="POST"
                                                                action="{{ route('delete_professeur', ['professeur' => $professeur->id]) }}">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="delete">

                                                            </form>  --}}
                                                             {{--  <a href="javascript:;" id="btn-hapus" class="ms-4"><i class='bx bxs-trash'
                                                            style="text-align:center"></i></a>  --}}


                                                            <form id="btn-hapus-{{ $professeur->id }}" method="POST"
                                                                action="{{ route('delete_professeur', ['professeur' => $professeur->id]) }}">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="delete">

                                                            </form>

                                                              {{--  <button type="" class="btn btn-danger"
                                            onclick="if(confirm('Voulez vous vraiment supprimer cet professeur?')){document.getElementById('form-{{ $professeur->id }}').submit()}">Suprimer</button>
                                        <form id="form-{{ $professeur->id }}" method="POST"
                                            action="{{ route('delete_professeur', ['professeur' => $professeur->id]) }}">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete">

                                        </form>  --}}
                                        {{--  https://youtu.be/xQIEQfYWbT0  <button type="" class="btn btn-danger"
                                        id="btn-hapus">Suprimer</button>  --}}

                                                </div>
                                            @endif

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
