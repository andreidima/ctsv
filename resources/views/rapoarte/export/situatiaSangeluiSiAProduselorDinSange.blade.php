@php
    use \Carbon\Carbon;
@endphp

<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Situația Sângelui și a produselor din sânge</title>
    <style>
        /* html {
            margin: 0px 0px;
        } */
        /** Define the margins of your page **/
        @page {
            margin: 0px 0px;
        }

        /* header {
            position: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            height: 0px;
        } */

        body {
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 12px;
            margin-top: 0px;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 1cm;
        }

        * {
            /* padding: 0; */
            text-indent: 0;
        }

        table{
            border-collapse:collapse;
            margin: 0px;
            padding: 5px;
            margin-top: 0px;
            border-style: solid;
            border-width: 0px;
            width: 100%;
            word-wrap:break-word;
        }

        th, td {
            padding: 1px 10px;
            border-width: 1px;
            border-style: solid;

        }
        tr {
            border-style: solid;
            border-width: 0px;
        }
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 0.5px;
        }
    </style>
</head>

<body>
    {{-- <header> --}}
        {{-- <img src="{{ asset('images/contract-header.jpg') }}" width="800px"> --}}
    {{-- </header> --}}

    <main>

        {{-- <div style="page-break-after: always"> --}}
        <div>

            @include('rapoarte.export.includes.header')


            <table style="">
                <tr valign="" style="">
                    <td style="border-width:0px; text-align:center;">
                        <h3 style="margin: 0">Situația Sângelui și a produselor din sânge</h3>
                        Perioada: {{ \Carbon\Carbon::parse(strtok($interval, ','))->isoFormat('DD.MM.YYYY') }} - {{ \Carbon\Carbon::parse(strtok(''))->isoFormat('DD.MM.YYYY')}}
                    </td>
                </tr>
            </table>

            <br>

            <table>
                <thead>
                    <tr>
                        <th rowspan="2"></th>
                        @foreach ($produse as $produs)
                        <th colspan="2" style="text-align: center">
                            {{ $produs->nume }}
                        </th>
                        @endforeach
                        <td style="border-width: 0px;"></td>
                    </tr>
                    <tr>
                        @foreach ($produse as $produs)
                        <td style="text-align: center">NR.P</td>
                        <td style="text-align: center">ML</td>
                        @endforeach
                        <td style="border-width: 0px;"></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>STOC INIȚIAL</th>
                        @foreach ($produse as $produs)
                            <td style="text-align: right">
                                {{ ($val =$recoltariSangeInitiale->where('recoltari_sange_produs_id', $produs->id)->count()) === 0 ? '' : $val }}
                            </td>
                            <td style="text-align: right">
                                {{ ($val = number_format($recoltariSangeInitiale->where('recoltari_sange_produs_id', $produs->id)->sum('cantitate') / 1000, 2)) === "0.00" ? '' : $val }}
                            </td>
                        @endforeach
                        <td style="border-width: 0px;"></td>
                    </tr>
                    <tr>
                        <th>RECOLTARE</th>
                        @foreach ($produse as $produs)
                            <td style="text-align: right">
                                {{ ($val =$recoltariSangeInterval->whereNull('intrare_id')->where('recoltari_sange_produs_id', $produs->id)->count()) === 0 ? '' : $val }}
                            </td>
                            <td style="text-align: right">
                                {{ ($val = number_format($recoltariSangeInterval->whereNull('intrare_id')->where('recoltari_sange_produs_id', $produs->id)->sum('cantitate') / 1000, 2)) === "0.00" ? '' : $val }}
                            </td>
                        @endforeach
                        <td style="border-width: 0px;"></td>
                    </tr>
                    <tr>
                        <th>PRIMITE</th>
                        @foreach ($produse as $produs)
                            <td style="text-align: right">
                                {{ ($val =$recoltariSangeInterval->whereNotNull('intrare_id')->where('recoltari_sange_produs_id', $produs->id)->count()) === 0 ? '' : $val }}
                            </td>
                            <td style="text-align: right">
                                {{ ($val = number_format($recoltariSangeInterval->whereNotNull('intrare_id')->where('recoltari_sange_produs_id', $produs->id)->sum('cantitate') / 1000, 2)) === "0.00" ? '' : $val }}
                            </td>
                        @endforeach
                        <td style="border-width: 0px;"></td>
                    </tr>
                    <tr>
                        <th>REBUT</th>
                        @foreach ($produse as $produs)
                            <td style="text-align: right">
                                {{ ($val =$recoltariSangeRebutate->where('recoltari_sange_produs_id', $produs->id)->count()) === 0 ? '' : $val }}
                            </td>
                            <td style="text-align: right">
                                {{ ($val = number_format($recoltariSangeRebutate->where('recoltari_sange_produs_id', $produs->id)->sum('cantitate') / 1000, 2)) === "0.00" ? '' : $val }}
                            </td>
                        @endforeach
                        <td style="border-width: 0px;"></td>
                    </tr>
                    <tr>
                        <th>LIVRARE</th>
                        @foreach ($produse as $produs)
                            <td style="text-align: right">
                                {{ ($val =$recoltariSangeLivrate->where('recoltari_sange_produs_id', $produs->id)->count()) === 0 ? '' : $val }}
                            </td>
                            <td style="text-align: right">
                                {{ ($val = number_format($recoltariSangeLivrate->where('recoltari_sange_produs_id', $produs->id)->sum('cantitate') / 1000, 2)) === "0.00" ? '' : $val }}
                            </td>
                        @endforeach
                        <td style="border-width: 0px;"></td>
                    </tr>
                    <tr>
                        <th>STOC FINAL</th>
                        @foreach ($produse as $produs)
                            <td style="text-align: right">
                                {{ ($val =$recoltariSangeStocFinal->where('recoltari_sange_produs_id', $produs->id)->count()) === 0 ? '' : $val }}
                            </td>
                            <td style="text-align: right">
                                {{ ($val = number_format($recoltariSangeStocFinal->where('recoltari_sange_produs_id', $produs->id)->sum('cantitate') / 1000, 2)) === "0.00" ? '' : $val }}
                            </td>
                        @endforeach
                        <td style="border-width: 0px;"></td>
                    </tr>
                    <tr>
                        <td style="border-width: 0px;">&nbsp;</td>
                        @foreach ($produse as $produs)
                            <td style="border-width: 0px;"></td>
                            <td style="border-width: 0px;"></td>
                        @endforeach
                        <td style="border-width: 0px;"></td>
                    </tr>
                    <tr>
                        <th style="border-width: 0px;"></th>
                        @foreach ($produse as $produs)
                            <th colspan="2" style="text-align: center">VAL</th>
                        @endforeach
                        <tH>VALOARE</tH>
                    </tr>
                    <tr>
                        <th>STOC INIȚIAL</th>
                        @php
                            $total = 0
                        @endphp
                        @foreach ($produse as $produs)
                            <td colspan="2" style="text-align:right">
                                {{-- When it was just 1 price --}}
                                {{ ($val = str_replace(',', '', number_format($recoltariSangeInitiale->where('recoltari_sange_produs_id', $produs->id)->count() * ($produs->pret ?? 0), 2))) === "0.00" ? '' : $val }}
                                @php
                                    $total += $val;
                                @endphp

                                {{-- When was added the posibility to calculate multiple prices --}}
                                {{-- @php
                                    $val = 0;
                                @endphp
                                @foreach ($produs->preturi as $pret)
                                    @php
                                        $val += $recoltariSangeInitiale->where('recoltari_sange_produs_id', $produs->id)->whereBetween('data', [$pret->de_la, $pret->pana_la])->count() * ($pret->pret ?? 0)
                                    @endphp
                                @endforeach
                                @php
                                    $total += $val;
                                @endphp
                                {{ ($val = str_replace(',', '', number_format($val, 2))) === "0.00" ? '' : $val }} --}}
                            </td>
                        @endforeach
                        <td style="text-align:right">{{ $total }}</td>
                    </tr>
                    <tr>
                        <th>RECOLTARE</th>
                        @php
                            $total = 0
                        @endphp
                        @foreach ($produse as $produs)
                            <td colspan="2" style="text-align:right">
                                {{-- When it was just 1 price --}}
                                {{-- {{ $recoltariSangeInterval->whereNull('intrare_id')->where('recoltari_sange_produs_id', $produs->id)->count() }} - {{ $produs->pret }} - --}}
                                {{ ($val = str_replace(',', '', number_format($recoltariSangeInterval->whereNull('intrare_id')->where('recoltari_sange_produs_id', $produs->id)->count() * ($produs->pret ?? 0), 2))) === "0.00" ? '' : $val }}
                                @php
                                    $total += $val;
                                @endphp

                                {{-- When was added the posibility to calculate multiple prices --}}
                                {{-- @php
                                    $val = 0;
                                @endphp
                                @foreach ($produs->preturi as $pret)
                                    @php
                                        $val += $recoltariSangeInterval->whereNull('intrare_id')->where('recoltari_sange_produs_id', $produs->id)->whereBetween('data', [$pret->de_la, $pret->pana_la])->count() * ($pret->pret ?? 0)
                                    @endphp
                                @endforeach
                                @php
                                    $total += $val;
                                @endphp
                                {{ ($val = str_replace(',', '', number_format($val, 2))) === "0.00" ? '' : $val }} --}}
                            </td>
                        @endforeach
                        <td style="text-align:right">{{ $total }}</td>
                    </tr>
                    <tr>
                        <th>PRIMITE</th>
                        @php
                            $total = 0
                        @endphp
                        @foreach ($produse as $produs)
                            <td colspan="2" style="text-align:right">
                                {{-- When it was just 1 price --}}
                                {{ ($val = str_replace(',', '', number_format($recoltariSangeInterval->whereNotNull('intrare_id')->where('recoltari_sange_produs_id', $produs->id)->count() * ($produs->pret ?? 0), 2))) === "0.00" ? '' : $val }}
                                @php
                                    $total += $val;
                                @endphp

                                {{-- When was added the posibility to calculate multiple prices --}}
                                {{-- @php
                                    $val = 0;
                                @endphp
                                @foreach ($produs->preturi as $pret)
                                    @php
                                        $val += $recoltariSangeInterval->whereNotNull('intrare_id')->where('recoltari_sange_produs_id', $produs->id)->whereBetween('data', [$pret->de_la, $pret->pana_la])->count() * ($pret->pret ?? 0)
                                    @endphp
                                @endforeach
                                @php
                                    $total += $val;
                                @endphp
                                {{ ($val = str_replace(',', '', number_format($val, 2))) === "0.00" ? '' : $val }} --}}
                            </td>
                        @endforeach
                        <td style="text-align:right">{{ $total }}</td>
                    </tr>
                    <tr>
                        <th>REBUT</th>
                        @php
                            $total = 0
                        @endphp
                        @foreach ($produse as $produs)
                            <td colspan="2" style="text-align:right">
                                {{-- When it was just 1 price --}}
                                {{ ($val = str_replace(',', '', number_format($recoltariSangeRebutate->where('recoltari_sange_produs_id', $produs->id)->count() * ($produs->pret ?? 0), 2))) === "0.00" ? '' : $val }}
                                @php
                                    $total += $val;
                                @endphp

                                {{-- When was added the posibility to calculate multiple prices --}}
                                {{-- @php
                                    $val = 0;
                                @endphp
                                @foreach ($produs->preturi as $pret)
                                    @php
                                        $val += $recoltariSangeRebutate->where('recoltari_sange_produs_id', $produs->id)->whereBetween('data', [$pret->de_la, $pret->pana_la])->count() * ($pret->pret ?? 0)
                                    @endphp
                                @endforeach
                                @php
                                    $total += $val;
                                @endphp
                                {{ ($val = str_replace(',', '', number_format($val, 2))) === "0.00" ? '' : $val }} --}}
                            </td>
                        @endforeach
                        <td style="text-align:right">{{ $total }}</td>
                    </tr>
                    <tr>
                        <th>LIVRARE</th>
                        @php
                            $total = 0
                        @endphp
                        @foreach ($produse as $produs)
                            <td colspan="2" style="text-align:right">
                                {{-- When it was just 1 price --}}
                                {{ ($val = str_replace(',', '', number_format($recoltariSangeLivrate->where('recoltari_sange_produs_id', $produs->id)->count() * ($produs->pret ?? 0), 2))) === "0.00" ? '' : $val }}
                                @php
                                    $total += $val;
                                @endphp

                                {{-- When was added the posibility to calculate multiple prices --}}
                                {{-- @php
                                    $val = 0;
                                @endphp
                                @foreach ($produs->preturi as $pret)
                                    @php
                                        $val += $recoltariSangeLivrate->where('recoltari_sange_produs_id', $produs->id)->whereBetween('data', [$pret->de_la, $pret->pana_la])->count() * ($pret->pret ?? 0)
                                    @endphp
                                @endforeach
                                @php
                                    $total += $val;
                                @endphp
                                {{ ($val = str_replace(',', '', number_format($val, 2))) === "0.00" ? '' : $val }} --}}
                            </td>
                        @endforeach
                        <td style="text-align:right">{{ $total }}</td>
                    </tr>
                    <tr>
                        <th>STOC FINAL</th>
                        @php
                            $total = 0
                        @endphp
                        @foreach ($produse as $produs)
                            <td colspan="2" style="text-align:right">
                                {{-- When it was just 1 price --}}
                                {{ ($val = str_replace(',', '', number_format($recoltariSangeStocFinal->where('recoltari_sange_produs_id', $produs->id)->count() * ($produs->pret ?? 0), 2))) === "0.00" ? '' : $val }}
                                @php
                                    $total += $val;
                                @endphp

                                {{-- When was added the posibility to calculate multiple prices --}}
                                {{-- @php
                                    $val = 0;
                                @endphp
                                @foreach ($produs->preturi as $pret)
                                    @php
                                        $val += $recoltariSangeStocFinal->where('recoltari_sange_produs_id', $produs->id)->whereBetween('data', [$pret->de_la, $pret->pana_la])->count() * ($pret->pret ?? 0)
                                    @endphp
                                @endforeach
                                @php
                                    $total += $val;
                                @endphp
                                {{ ($val = str_replace(',', '', number_format($val, 2))) === "0.00" ? '' : $val }} --}}
                            </td>
                        @endforeach
                        <td style="text-align:right">{{ $total }}</td>
                    </tr>
                </tbody>
            </table>

            <br>

            <table>
                <tr>
                    {{-- @foreach ($produsePreturi->whereIn('produs_id', $produse->pluck('id')->toArray())->groupBy('de_la') as $produsePreturiPerData)
                        <td style="width:250px">
                            <table style="">
                                    <tr>
                                        <td colspan="3"  style="border-width: 0px; text-align:center; ">
                                            @if ($loop->first)
                                                Până la {{ $produsePreturiPerData->first()->pana_la ? Carbon::parse($produsePreturiPerData->first()->pana_la)->isoFormat('DD.MM.YYYY') : '' }}
                                            @elseif ($loop->last)
                                                De la {{ $produsePreturiPerData->first()->de_la ? Carbon::parse($produsePreturiPerData->first()->de_la)->isoFormat('DD.MM.YYYY') : '' }}
                                            @else
                                                {{ $produsePreturiPerData->first()->de_la ? Carbon::parse($produsePreturiPerData->first()->de_la)->isoFormat('DD.MM.YYYY') : '' }}
                                                -
                                                {{ $produsePreturiPerData->first()->pana_la ? Carbon::parse($produsePreturiPerData->first()->pana_la)->isoFormat('DD.MM.YYYY') : '' }}
                                            @endif
                                        </td>
                                    </tr>
                            @foreach ($produsePreturiPerData->sortBy('produs.nume') as $produsPret)
                                @if ((($produsPret->produs->pret ?? '') !== '0.00')
                                        // Produs$produse contains just the products that are in this raport, so we don't desplay all the products, just those necesary for CTSV Vrancea
                                        // && (in_array($produsPret->produs_id, $produse->pluck('id')->toArray()))
                                    )
                                    <tr>
                                        <td style="border-width: 0px;">{{ $produsPret->produs->nume ?? '' }}</td>
                                        <td style="border-width: 0px; text-align:right">{{ $produsPret->pret }}</td>
                                        <td style="border-width: 0px;">lei/punga</td>
                                    </tr>

                                @endif
                            @endforeach
                            </table>
                        </td>
                    @endforeach --}}


                    <td style="border-width: 0px; width:250px">
                        <table style="">
                            @foreach ($produse as $produs)
                                @if ($produs->pret !== '0.00')
                                    <tr>
                                        <td style="border-width: 0px;">{{ $produs->nume }}</td>
                                        <td style="border-width: 0px; text-align:right">{{ $produs->pret }}</td>
                                        <td style="border-width: 0px;">lei/punga</td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </td>

                    <td style="border-width: 0px; text-align:center; width:30%">
                        ÎNTOCMIT,
                    </td>
                </tr>
            </table>

        </div>


        {{-- Here's the magic. This MUST be inside body tag. Page count / total, centered at bottom of page --}}
        <script type="text/php">
            if (isset($pdf)) {
                $text = "Pagina {PAGE_NUM} / {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("helvetica");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width) / 2;
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>


    </main>
</body>

</html>
