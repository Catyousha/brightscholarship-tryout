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
                                    <label for="id_nama" class="font-weight-bold text-primary">Nama Lengkap</label>
									<input type="text" id="id_nama" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required>
									@error('name')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="form-group">
                                    <label for="id_email" class="font-weight-bold text-primary">Alamat Email</label>
									<input type="email" id="id_email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Alamat Email" required>
									@error('email')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
                                <div class="form-group">
                                    <label for="id_pilihan" class="font-weight-bold text-primary">Pilihan</label>
                                    <select class="custom-select" id="id_pilihan" name="pilihan">
                                        @foreach (\App\Models\Pilihan::all() as $p)
                                        <option value="{{$p->id}}" @if(old('pilihan') == $p->id) selected @endif>{{$p->name}}</option>
                                        @endforeach
                                    </select>
									@error('pilihan')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
                                <div class="form-group">
                                    <label for="id_asal_sekolah" class="font-weight-bold text-primary">Asal Sekolah</label>
									<input type="text" id="id_asal_sekolah" class="form-control @error('asal_sekolah') is-invalid @enderror" name="asal_sekolah" value="{{ old('asal_sekolah') }}" placeholder="Asal Sekolah" required>
									@error('asal_sekolah')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
                                <div class="form-group">
                                    <label for="id_foto_profil" class="font-weight-bold text-primary">Foto Profil</label>
									<input type="file" id="id_foto_profil" class="form-control  @error('foto_profil') is-invalid @enderror" name="foto_profil" placeholder="Foto Profil" required>
									@error('foto_profil')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="form-group">
                                    <label class="font-weight-bold text-primary">Kata Sandi</label>
                                    <div class="row">
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
								</div>
								<button class="g-recaptcha btn btn-primary btn-user btn-block" data-sitekey="{{ env('RECAPTCHA_SITEKEY') }}" data-callback="onSubmit" data-action="register" disabled>Daftar</button>
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
