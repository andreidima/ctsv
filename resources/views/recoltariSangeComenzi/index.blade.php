@extends ('layouts.app')

@section('content')
<div class="mx-3 px-3 card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2">
                <span class="badge culoare1 fs-5">
                    <i class="fa-solid fa-clipboard-list me-1"></i>Comenzi
                </span>
            </div>
            <div class="col-lg-7">
                <form class="needs-validation" novalidate method="GET" action="{{ url()->current()  }}">
                    @csrf
                    <div class="row mb-1 custom-search-form justify-content-center">
                        <div class="col-lg-2">
                            <input type="text" class="form-control rounded-3" id="searchComandaNr" name="searchComandaNr" placeholder="Comanda nr." value="{{ $searchComandaNr }}">
                        </div>
                        <div class="col-lg-2">
                            <input type="text" class="form-control rounded-3" id="searchAvizNr" name="searchAvizNr" placeholder="Aviz nr." value="{{ $searchAvizNr }}">
                        </div>
                        <div class="col-lg-3">
                            <select name="searchBeneficiar" class="form-select bg-white rounded-3">
                                <option value="" selected>Selectează beneficiar</option>
                                @foreach ($beneficiari as $beneficiar)
                                    <option value="{{ $beneficiar->id }}" {{ ($beneficiar->id === intval($searchBeneficiar)) ? 'selected' : '' }}>{{ $beneficiar->nume }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 d-flex align-items-center" id="datePicker">
                            <label for="data" class="mb-0 pe-1">Data</label>
                            <vue-datepicker-next
                                data-veche="{{ $searchData }}"
                                nume-camp-db="searchData"
                                tip="date"
                                value-type="YYYY-MM-DD"
                                format="DD.MM.YYYY"
                                :latime="{ width: '125px' }"
                            ></vue-datepicker-next>
                        </div>
                    </div>
                    <div class="row custom-search-form justify-content-center">
                        <div class="col-lg-4">
                            <button class="btn btn-sm w-100 btn-primary text-white border border-dark rounded-3" type="submit">
                                <i class="fas fa-search text-white me-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-lg-4">
                            <a class="btn btn-sm w-100 btn-secondary text-white border border-dark rounded-3" href="{{ url()->current() }}" role="button">
                                <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-end">
                <a class="btn btn-sm btn-success text-white border border-dark rounded-3 col-md-8" href="{{ url()->current() }}/adauga" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă comandă
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover rounded">
                    {{-- <thead class="text-white rounded bg-danger" bgcolor="red"> --}}
                    <thead class="text-white rounded">
                        <tr class="thead-danger" style="padding:2rem">

            {{-- <div class="table-responsive rounded">
                <table class="table table-striped table-hover rounded">
                    <thead class="text-white rounded" style="background-color: #69A1B1">
                        <tr class="" style="padding:2rem"> --}}
                            <th class="text-white culoare2">#</th>
                            <th class="text-white culoare2">Comanda nr.</th>
                            <th class="text-white culoare2">Aviz nr.</th>
                            <th class="text-white culoare2">Beneficiar</th>
                            <th class="text-white culoare2">Data</th>
                            {{-- <th class="text-white culoare2">Recoltări sânge</th> --}}
                            {{-- <th class="">Observații</th> --}}
                            <th class="text-white culoare2 text-end">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recoltariSangeComenzi as $recoltareSangeComanda)
                            <tr>
                                <td align="">
                                    {{ ($recoltariSangeComenzi ->currentpage()-1) * $recoltariSangeComenzi ->perpage() + $loop->index + 1 }}
                                </td>
                                <td class="">
                                    {{ $recoltareSangeComanda->comanda_nr }}
                                </td>
                                <td class="">
                                    {{ $recoltareSangeComanda->aviz_nr }}
                                </td>
                                <td class="">
                                    {{ $recoltareSangeComanda->beneficiar->nume ?? '' }}
                                </td>
                                <td class="">
                                    {{ $recoltareSangeComanda->data ? \Carbon\Carbon::parse($recoltareSangeComanda->data)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                                {{-- <td class="">
                                    @if ($recoltareSangeComanda->recoltariSange->count())
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Cod</th>
                                                    <th scope="col" class="text-center">Cantitate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recoltareSangeComanda->recoltariSange as $recoltareSange)
                                                <tr>
                                                    <td scope="row">{{ $loop->iteration }}
                                                    <td>{{ $recoltareSange->cod }}</td>
                                                    <td class="text-center">{{ $recoltareSange->cantitate }}</td>
                                                <tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </td> --}}
                                <td>
                                    <div>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ $recoltareSangeComanda->path() }}/export-pdf" target="_blank" class="flex me-1">
                                                <span class="badge bg-warning text-dark">Bon de livrare</span>
                                            </a>
                                            <a href="{{ $recoltareSangeComanda->path() }}" class="flex me-1">
                                                <span class="badge bg-success">Vizualizează</span>
                                            </a>
                                        {{-- </div>
                                        <div class="d-flex justify-content-end"> --}}
                                            <a href="{{ $recoltareSangeComanda->path() }}/modifica" class="flex me-1">
                                                <span class="badge bg-primary">Modifică</span>
                                            </a>
                                            <div style="flex" class="">
                                                <a
                                                    href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#stergeRecoltareSangeComanda{{ $recoltareSangeComanda->id }}"
                                                    title="Șterge Recoltare Sânge Comandă"
                                                    >
                                                    <span class="badge bg-danger">Șterge</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$recoltariSangeComenzi->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>
        </div>
    </div>

    {{-- Modalele pentru stergere recoltareSangeComanda --}}
    @foreach ($recoltariSangeComenzi as $recoltareSangeComanda)
        <div class="modal fade text-dark" id="stergeRecoltareSangeComanda{{ $recoltareSangeComanda->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Recoltare sănge comanda: <b>{{ $recoltareSangeComanda->numar }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Comanda?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $recoltareSangeComanda->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge Comanda
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
