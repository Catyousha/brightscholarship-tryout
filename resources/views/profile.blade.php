@extends('layouts.main')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Profile') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        <div class="col-lg-4 order-lg-2">

            <div class="card shadow mb-4">
                <div class="card-profile-image mt-4">
                    <figure class="rounded-circle avatar avatar font-weight-bold" style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->name[0] }}"></figure>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h5 class="font-weight-bold">{{  Auth::user()->fullName }}</h5>
                                <p>{{Auth::user()->role}}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-8 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">My Account</h6>
                </div>

                <div class="card-body">
                    @include('layouts.flash')
                    <form action="{{ route('user-profile-information.update') }}" autocomplete="off"  method="post">
                        @method('put')
                        @csrf

                        <h6 class="heading-small text-muted mb-4">Ubah Identitas</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Nama Lengkap<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Nama Lengkap" value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Alamat Email<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan Perubahan</button>
                                </div>
                            </div>
                    </form>

                    <form action="{{ route('user-password.update') }}" autocomplete="off"  method="post" class="mt-3">
                        @method('put')
                        @csrf
                            <div class="row">
                                <h6 class="heading-small text-muted mb-4">Ubah Password</h6>
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="id_current_password">Password Sekarang</label>
                                        <input type="password" id="id_current_password" class="form-control" name="current_password" placeholder="Current password">
                                    </div>
                                    @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="id_new_password">Password Baru</label>
                                        <input type="password" id="id_new_password" class="form-control" name="new_password" placeholder="New password">
                                    </div>
                                    @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="id_confirm_password">Konfirmasi Password Baru</label>
                                        <input type="password" id="id_confirm_password" class="form-control" name="password_confirmation" placeholder="Confirm password">
                                    </div>
                                    @error('confirm_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
