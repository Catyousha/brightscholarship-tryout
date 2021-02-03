@extends('layouts.auth')

@section('title', "Masuk")

@push('stylesheets')
@endpush

@section('simple')
	<div class="container">

		<!-- Outer Row -->
		<div class="row justify-content-center">
			<div class="col-xl-10 col-lg-12 col-md-9">
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
							<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
							<div class="col-lg-6">
								<div class="p-5">

									@include('layouts.flash')

									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
									</div>
									<form action="{{ route('login') }}" method="POST" class="user">
										@csrf
										<div class="form-group">
											<input type="text" class="form-control form-control-user @error('email') is-invalid @enderror" placeholder="Alamat Email" name="email" required>
										</div>
										<div class="form-group">
											<input type="password" class="form-control form-control-user @error('email') is-invalid @enderror" placeholder="Kata Sandi" name="password" required>
											@error('email')
											<div class="invalid-feedback">Email atau Password Salah!</div>
											@enderror
                                        </div>
										<div class="form-group">
											<div class="custom-control custom-checkbox small">
												<input type="checkbox" class="custom-control-input" id="customCheck" name="remember" @if(old('remember') == 'on') checked @endif>
												<label class="custom-control-label" for="customCheck">Ingat Saya</label>
											</div>
										</div>
										<button type="submit" class="btn btn-primary btn-user btn-block">Masuk</button>
									</form>
									<hr>
									<div class="text-center">
										<a class="small" href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
									</div>
									<div class="text-center">
										<a class="small" href="{{ route('register') }}">Buat Akun!</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
@endsection

@push('scripts')
@endpush
