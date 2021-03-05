@extends('layouts.auth')

@section('title', "Verifikasi Email")

@push('stylesheets')
@endpush

@section('simple')
    <div class="container">
		<div class="row justify-content-center">

			<div class="col-xl-10 col-lg-12 col-md-9">

				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
						<div class="row">
							<div class="col-lg-12">
								<div class="p-5">

									@include('layouts.flash')

									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-2">Menunggu Verifikasi Akun</h1>
										<p class="mb-4">Akun anda sedang menunggu verifikasi dari kami, silahkan tunggu.</p>
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
