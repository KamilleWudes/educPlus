@extends('layouts.auth')

@section('container')

<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-lock-screen d-flex align-items-center justify-content-center">
			<div class="card shadow-none bg-transparent">
				<div class="card-body p-md-5 text-center">

					{{-- <h2 class="text-white">10:53 AM</h2> --}}
                    {{--  @foreach ($userPrincipals as $userPrincipal)  --}}
					<h3 class="text-white" id="t">Tuesday, January 14, 2021</h3>
                    {{--  <h5 class="text-white">{{ $userPrincipal->created_at->diffForHumans()}}</h5>  --}}

                    {{--  @endforeach  --}}
					<div class="">
						<img src="assets/images/icons/user.png" class="mt-5" width="120" alt="" />
					</div>
					<p class="mt-2 text-white">Administrateur</p>
                    <form  method="POST" action="{{ route('superadmin') }}">
                        @csrf
					<div class="mb-3 mt-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" placeholder="Email Address" />
                        @error('email')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror <br>
                    <div class="input-group" id="show_hide_password">
						<input type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" placeholder="Password"/><a href="javascript:;"
                        class="input-group-text bg-transparent"><i
                            class='bx bx-hide'></i></a>
                        </div>
                        @error('password')
                        <span class="error" style="color:red">{{ $message }}</span>
                    @enderror
					</div>


					<div class="d-grid">
						<button type="submit" class="btn btn-light" id="flash"
                        data-flash="{!! session()->get('error') !!}">Se connecter</button>
					</div>
                </form>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->


@endsection


