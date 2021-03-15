@extends('layouts.main')
@section('title', "Daftar Peserta Menunggu Validasi")
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('') }}</h1>

    <!-- Main Content goes here -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <h6 class="m-0 font-weight-bold text-primary mb-2">Daftar Peserta Menunggu Validasi</h6>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <form action="{{route('peserta.index')}}" method="GET" autocomplete="off">
                                <div class="input-group">
                                    <input name="name" type="text" class="form-control bg-light border-1 small" placeholder="Cari peserta...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <th>No.</th>
                            <th>Nama Peserta</th>
                            <th>Email</th>
                            <th>Asal Sekolah</th>
                            <th>Pilihan</th>
                            <th>Opsi</th>
                        </thead>
                        <tbody>
                            @php $no = 1@endphp
                            @forelse ($peserta as $p)
                            <tr id="user_{{$p->id}}">
                                <td>{{$no}}</td>
                                <td>{{$p->name}}</td>
                                <td>{{$p->email}}</td>
                                <td>{{$p->asal_sekolah}}</td>
                                <td>{{$p->pilihan->name}}</td>
                                <td>
                                    <!--<button class="btn btn-primary btn-sm validate-btn" data-id={{$p->id}} data-decision="_ACC"><i class="fa fa-user fa-fw"></i> Validasi</button>
                                    <button class="btn btn-danger btn-sm validate-btn" data-id={{$p->id}} data-decision="_REJECT"><i class="fa fa-user fa-fw"></i> Tolak</button>-->
                                </td>
                                @php $no+=1 @endphp
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" align="center"><span class="text-muted">Data tidak ditemukan</span></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $peserta->links() }}
                    </div>
                </div>
            </div>
        </div>

    <!-- End of Main Content -->
@endsection

@push('notif')
@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('status'))
    <div class="alert alert-success border-left-success" role="alert">
        {{ session('status') }}
    </div>
@endif
@endpush

@push('js')
<script src="http://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
crossorigin="anonymous"></script>

<script type="text/javascript">

    $('.validate-btn').click(function (){
        let user_id = $(this).attr('data-id');
        let decision_type = $(this).attr('data-decision');
        $.ajax({
            type:'POST',
            url:'/validate',
            data:{_token: "{{ csrf_token() }}", user_id: user_id, decision: decision_type},
            success:function(data) {
                $('#user_'+user_id).remove();
                if(data.data == '_ACC'){
                    toastr.success('Peserta yang telah diverifikasi dapat mengikuti tryout.', 'Peserta berhasil divalidasi!');
                } else{
                    toastr.error('Peserta yang ditolak tidak dapat dilakukan verifikasi kembali.', 'Peserta berhasil ditolak!');
                }


            },
            error: function(err){
                console.log(err)
            }
        });

    })
</script>

@endpush
