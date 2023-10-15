<div class="modal fade" id="exampleDarkModals{{ $typeCompositionId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content bg-dark" style="width: 800px">
            <div class="modal-header">
                <h5 class="modal-title text-white">Formulaire de modification de la Type Composition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body text-white">
                <h5 class="mb-0 text-white">Édition Type composition</h5><br><br><br><br>
                 <form class="row g-3" method="POST" action="{{ url('update_TypeComposition/'. $typeCompositionId) }}">
                            @csrf
                            @method('PUT')
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">Type Composition</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                value="{{$typeComposition->nom}}" id="inputEnterYourName" name="nom" placeholder="Type Composition">
                            @error('nom')
                                <span class="error" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary px-5" id="flash"
                    data-flash="{!! session()->get('success') !!}"><i
                        class="bx bx-check-circle mr-1"></i>Valider</button>
            </div>
            </form>
        </div>
    </div>
</div>
