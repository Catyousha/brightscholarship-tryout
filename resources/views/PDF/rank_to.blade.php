
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hasil Pemeringkatan Peserta {{$pilihan}} BSTO UM</title>
</head>
<body>
    <style>

        * {
        font-size: 100%;
        font-family: Arial;
        }
    .table { display: table; width: 100%; border-collapse: collapse; }
    .table-row { display: table-row; }
    .table-cell { display: table-cell; border: 1px solid black; padding: 10px; text-align: center;}
        .text-center {
            text-align: center;
        }
        main{
            text-align: center;
        }
    </style>
    <div class="main">
    <h2 class="text-center" style="margin-top: 50px; font-size: 42px;">
        Hasil Pemeringkatan Peserta {{$pilihan}} BSTO UM
    </h2>

    <div class="table">
        <div class="table-row">
            <div class="table-cell">Ranking</div>
            <div class="table-cell">Nama Peserta</div>
            @foreach ($tryout->sesi as $s)
                @if($s->istirahat != 1)
                    <th class="text-center">Skor {{$s->mapel->name}}</th>
                @endif
            @endforeach
            <div class="table-cell">Rata-Rata</div>
        </div>
            @php $rank = 0@endphp
            @forelse ($peserta_tryout) as $pt)
            <div class="table-row">
                @php $rank += 1;@endphp
                <div class="table-cell">{{$rank}}</div>
                <div class="table-cell">{{\App\Models\User::where('id', $pt->user_id)->first()->name}}</div>
                @foreach($tryout->sesi as $s)
                    @if($s->istirahat != 1)
                        <div class="table-cell">{{\App\Models\UserTryout::where('sesi_id', $s->id)
                                                                        ->where('user_id', $pt->user_id)
                                                                        ->first()
                                                                        ->score ?? 0}}
                        </div>
                    @endif
                @endforeach
                <div class="table-cell">{{$pt->avg_score}}</div>
            </div>
            @empty
            <div class="table-row">
                <div class="table-cell"><span class="text-muted">Data tidak ditemukan</span></div>
            </div>
            @endforelse
    </div>
    </div>
</body>
</html>
