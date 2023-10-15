<!-- admin/matieres/edite.blade.php -->
<div class="modal fade" id="exampleDarkModals{{ $matiereId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark" style="width: 800px">
            <div class="modal-header">
                <h5 class="modal-title text-white">Formulaire de modification de la Matière</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-white">
                <h5 class="mb-0 text-white">Édition Matière</h5><br><br><br><br>
                <form class="row g-3" method="POST" action="{{ url('update_matiere/' . $matiereId) }}">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">Entrez la matière</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                value="{{ $matiere->nom }}" id="inputEnterYourName" name="nom" placeholder="Matière">
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
@push('validate')
    <script>
        var successFlash = '{{ session('success') }}';
        var errorFlash = '{{ session('error') }}';

        if (successFlash) {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: successFlash,
                showClass: {
                    popup: 'animate__animated animate__jackInTheBox'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut'
                },
                timer: 500000, // Temps en millisecondes (3 secondes dans cet exemple)
                timerProgressBar: true, // Affiche une barre de progression
                toast: false, // Style de popup de notification
                position: 'center' // Position de la notification
            });
        } else if (errorFlash) {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: errorFlash,
                showClass: {
                    popup: 'animate__animated animate__shakeX'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut'
                },
                //timer: 50000, // Temps en millisecondes (3 secondes dans cet exemple)
                //timerProgressBar: true, // Affiche une barre de progression
                //toast: false, // Style de popup de notification
                //position: 'top-end' // Position de la notification
            });
        }
    </script>
@endpush