@extends ('layouts.app')

@section('content')
<div class="mx-3 px-3 card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2">
                <span class="badge culoare1 fs-5">
                    <i class="fas fa-bars me-1"></i>Rapoarte
                </span>
            </div>
            <div class="col-lg-7">
                {{-- <form class="needs-validation" novalidate method="GET" action="{{ url()->current()  }}">
                    @csrf
                    <div class="row mb-1 custom-search-form justify-content-center">
                        <div class="col-lg-3 d-flex align-items-center" id="datePicker">
                            <label for="searchInterval" class="mb-0 pe-1">Interval:</label>
                            <vue-datepicker-next
                                data-veche="{{ $searchInterval }}"
                                nume-camp-db="searchInterval"
                                tip="date"
                                range="range"
                                value-type="YYYY-MM-DD"
                                format="DD.MM.YYYY"
                                :latime="{ width: '210px' }"
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
                </form> --}}
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <form class="needs-validation" novalidate method="GET" action="{{ url()->current()  }}">
                        @csrf
                        <div class="row mb-1 custom-search-form justify-content-center">
                            <div class="col-lg-12 mb-5 align-items-center text-center" id="datePicker">
                                <label for="interval" class="mb-1 py-1 px-3 culoare2 rounded-3">Alege intervalul</label>
                                <vue-datepicker-next
                                    data-veche="{{ $interval }}"
                                    nume-camp-db="interval"
                                    tip="date"
                                    range="range"
                                    value-type="YYYY-MM-DD"
                                    format="DD.MM.YYYY"
                                    :latime="{ width: '210px' }"
                                ></vue-datepicker-next>
                            </div>
                            <span class="py-1 px-3 rounded-3 culoare2 text-center">Alege raportul dorit</span>
                            <div class="list-group p-0 list-group-numbered rounded-3">
                                <button type="submit" name="action" value="recoltariSangeCtsvToate" class="list-group-item list-group-item-action" aria-current="true">
                                    Recoltări de sânge la CTSV
                                </button>
                                <button type="submit" name="action" value="rebuturi" class="list-group-item list-group-item-action" aria-current="true">
                                    Rebuturi
                                </button>
                                {{-- <a href="/rapoarte/recoltari-sange/export-pdf" target="_blank" class="list-group-item list-group-item-action active" aria-current="true">
                                    Recoltări de sânge
                                </a> --}}
                            </div>
                        </div>

                    </form>
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