@extends('layouts.auth')

@section('title', "Pendaftaran")

@push('stylesheets')
@endpush

@section('simple')
    <div class="container">
		<div class="card o-hidden border-0 shadow-lg my-5">
			<div class="card-body p-0">
				<!-- Nested Row within Card Body -->
				<div class="row">
					<div class="col-lg-5 d-none d-lg-block bg-register-image" id="bg"></div>
					<div class="col-lg-7">
						<div class="p-5">
							<div class="text-center">
								<h1 class="h4 text-gray-900 mb-4">Daftarkan Akun!</h1>
							</div>

							@include('layouts.flash')

							<form action="{{ route('register') }}" method="post" id="form-register" enctype="multipart/form-data">
								@csrf
								
								<div class="form-group">
									<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required>
									@error('name')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="form-group">
									<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Alamat Email" required>
									@error('email')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="form-group row">
									<div class="col-sm-6 mb-3 mb-sm-0">
										<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Kata Sandi" required>
										@error('password')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									<div class="col-sm-6">
										<input type="password" class="form-control @error('password_confirmation ') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Ulangi Kata Sandi" required>
										@error('password_confirmation')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<button class="g-recaptcha btn btn-primary btn-user btn-block" data-sitekey="{{ env('RECAPTCHA_SITEKEY') }}" data-callback="onSubmit" data-action="register">Daftar</button>
							</form>
							<hr>
							<div class="text-center">
								<a class="small" href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
							</div>
							<div class="text-center">
								<a class="small" href="{{ route('login') }}">Sudah punya akun? Masuk!</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
@endsection

@push('scripts')
	<script src="https://www.google.com/recaptcha/api.js"></script>
	<script>
		function onSubmit(token) {
			$('input[name="g-recaptcha"]').val(token);
			$("#form-register").submit();
		}

		$('input[name="nim"]').keyup(function(e){
			var value = $(this).val();

			if(value.length >= 2){
				$('input[name="angkatan"]').val("20"+value.substr(0, 2));
			}
		})
	</script>
@endpush
