@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="culoare2 border border-secondary p-2" style="border-radius: 40px 40px 0px 0px;">
                    <span class="badge text-light fs-5">
                        <i class="fa-solid fa-clipboard-list me-1"></i>Recoltări sânge / Intrări / {{ $recoltareSangeIntrare->bon_nr }}
                    </span>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                >

            @include ('errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-striped table-hover"
                        >
                            <tr>
                                <td class="pe-4">
                                    Bon nr.
                                </td>
                                <td>
                                    {{ $recoltareSangeIntrare->bon_nr }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Aviz nr.
                                </td>
                                <td>
                                    {{ $recoltareSangeIntrare->aviz_nr }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Expeditor
                                </td>
                                <td>
                                    {{ $recoltareSangeIntrare->expeditor->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Data
                                </td>
                                <td>
                                    {{ $recoltareSangeIntrare->data ? \Carbon\Carbon::parse($recoltareSangeIntrare->data)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Recoltări sânge
                                </td>
                                <td>
                                    @if ($recoltareSangeIntrare->recoltariSange->count())
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Cod</th>
                                                    <th scope="col" class="text-center">Cantitate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recoltareSangeIntrare->recoltariSange as $recoltareSange)
                                                <tr>
                                                    <td scope="row">{{ $loop->iteration }}
                                                    <td>{{ $recoltareSange->cod }}</td>
                                                    <td class="text-center">{{ $recoltareSange->cantitate }}</td>
                                                <tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-secondary text-white rounded-3" href="{{ Session::get('recoltareSangeIntrareReturnUrl') }}">Înapoi</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
