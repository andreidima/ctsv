@extends ('layouts.app')

@section('content')
<div class="mx-3 px-3 card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2">
                <span class="badge culoare1 fs-5">
                    <i class="fas fa-bars me-1"></i>Rapoarte - stocuri pungi sânge
                </span>
            </div>
            <div class="col-lg-7">
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="row">
                <div class="col-lg-5 mx-auto text-center">
                    <h3 style="margin: 0">Stocuri pungi sânge</h3>
                    Până la data: {{ \Carbon\Carbon::parse(strtok($interval, ','))->isoFormat('DD.MM.YYYY') }}

                    <br>
                    <br>
                    @foreach ($recoltariSange->sortby('produs.id')->groupBy('recoltari_sange_produs_id') as $recoltariSangeGrupateDupaGrupa)
                        <form class="needs-validation" novalidate method="GET" action="/rapoarte/stocuri-pungi-sange">
                            @csrf
                            <input type="hidden" name="interval" value="{{ $interval }}">
                            <input type="hidden" name="produsId" value="{{ $recoltariSangeGrupateDupaGrupa->first()->produs->id }}">

                            {{-- PPC-urile sunt foarte multe, asa ca se sparg in 2 fisiere separate --}}
                            @if($recoltariSangeGrupateDupaGrupa->first()->produs->nume === "PPC")
                                {{ $recoltariSangeGrupateDupaGrupa->first()->produs->nume }}:
                                {{ $recoltariSangeGrupateDupaGrupa->count() }} pungi /
                                {{ number_format((float)($recoltariSangeGrupateDupaGrupa->sum('cantitate') / 1000), 2, '.', '') }} litri
                                @php
                                    dd($recoltariSangeGrupateDupaGrupa)->take(5)->get();
                                @endphp
                                <button class="btn btn-primary" type="submit" name="action" value="doarGrupePozitive">
                                    0+ ({{ $recoltariSangeGrupateDupaGrupa->where('recoltari_sange_grupa_id' == 1)->count() }} pungi)
                                </button>
                                <button class="btn btn-primary" type="submit" name="action" value="doarGrupePozitive">
                                    A+ ({{ $recoltariSangeGrupateDupaGrupa->where('recoltari_sange_grupa_id' == 2)->count() }} pungi)
                                </button>
                                <button class="btn btn-primary" type="submit" name="action" value="doarGrupePozitive">
                                    AB+ ({{ $recoltariSangeGrupateDupaGrupa->where('recoltari_sange_grupa_id' == 3)->count() }} pungi)
                                </button>
                                <button class="btn btn-primary" type="submit" name="action" value="doarGrupeNegative">
                                    -
                                </button>
                            @else
                                <button class="btn btn-primary" type="submit">
                                    {{ $recoltariSangeGrupateDupaGrupa->first()->produs->nume }}:
                                    {{ $recoltariSangeGrupateDupaGrupa->count() }} pungi /
                                    {{ number_format((float)($recoltariSangeGrupateDupaGrupa->sum('cantitate') / 1000), 2, '.', '') }} litri
                                </button>
                            @endif
                        </form>
                        <br>
                    @endforeach
                </div>
            </div>

            {{-- @foreach ($recoltariSange->sortBy('data') as $recoltare)
                {{ $recoltare->data }}
                <br>
            @endforeach
            {{ $recoltariSange->count() }} --}}

        </div>
    </div>

@endsection
