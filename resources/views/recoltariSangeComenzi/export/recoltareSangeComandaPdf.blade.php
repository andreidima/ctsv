<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Comanda</title>
    <style>
        /* html {
            margin: 0px 0px;
        } */
        /** Define the margins of your page **/
        @page {
            margin: 30px 0px;
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
            font-size: 14px;
            margin-top: 10px;
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

            {{-- <table style="">
                <tr valign="" style="">
                    <td style="border-width:0px; padding:0rem; margin:0rem; width:50%;">
                        UNITATEA: {{ $recoltareSangeComanda->beneficiar->nume ?? '' }}
                        <br>
                        LOCALITATEA: {{ $recoltareSangeComanda->beneficiar->localitate }}
                        <br>
                        JUDEȚUL: {{ $recoltareSangeComanda->beneficiar->judet }}
                    </td>
                    <td style="border-width:0px; padding:0rem; margin:0rem; width:50%; text-align:right;">
                        DATA COMENZII: {{ $recoltareSangeComanda->data ? \Carbon\Carbon::parse($recoltareSangeComanda->data)->isoFormat('DD.MM.YYYY') : '' }}
                    </td>
                </tr>
            </table>

            <h3 style="text-align:center">
                COMANDA NR: {{ $recoltareSangeComanda->comanda_nr }}
                <br>
                PRODUSE SANGUINE CĂTRE
                <br>
                CENTRUL DE TRANSFUZIE SANGUINĂ FOCȘANI
            </h3>


            <table>
                <tr valign="top" style="">
                    <th rowspan="2">Nr. crt.</th>
                    <th rowspan="2">Tip produse</th>
                    <th colspan="8">CANTITATE (pungi) PE GRUP SANGUIN</th>
                    <th rowspan="2">Total pungi</th>
                </tr>
                <tr>
                    @foreach ($recoltareSangeGrupe as $recoltareSangeGrupa)
                        <th>{{ $recoltareSangeGrupa->nume }}</th>
                    @endforeach
                </tr>
                @foreach ($recoltareSangeComanda->recoltariSange->groupBy('recoltari_sange_produs_id') as $recoltariSangeGroupByProdus)
                    <tr>
                        <td style="text-align: center">
                            {{ $loop->iteration }}
                        </td>
                        <td style="text-align: center">
                            {{ $recoltariSangeGroupByProdus->first()->produs->nume }}
                        </td>
                        @foreach ($recoltareSangeGrupe as $recoltareSangeGrupa)
                            <td style="text-align: center">
                                @if (($nrRecoltari = $recoltariSangeGroupByProdus->where('recoltari_sange_grupa_id', $recoltareSangeGrupa->id)->count()) !== 0)
                                    {{ $nrRecoltari }}
                                @endif
                            </td>
                        @endforeach
                        <td style="text-align: center">
                            {{ $recoltariSangeGroupByProdus->count() }}
                        </td>
                    </tr>
                @endforeach
            </table>

            <table style="">
                <tr valign="" style="">
                    <td style="border-width:0px; padding:0rem; margin:0rem; width:50%; text-align:center;">
                        MEDIC PPSCRIPTOR,
                    </td>
                    <td style="border-width:0px; padding:0rem; margin:0rem; width:50%; text-align:center;">
                        AS GARDĂ,
                    </td>
                </tr>
            </table> --}}

            {{-- <br><br> --}}

            <table style="">
                <tr valign="" style="">
                    <td style="border-width:0px; text-align:center">
                        <h3>INSTITUTUL NAȚIONAL DE TRANSFUZIE SANGUINĂ</h3>
                        CENTRUL DE TRANSFUZIE SANGUINĂ VRANCEA
                        <br>
                        Str. CUZA VODĂ, Nr. 50-52, FOCȘANI
                        <br>
                        Telefon: 0337.401.233 / Fax: 0237.223.220
                        <hr>
                </tr>
            </table>


            <table style="">
                <tr valign="" style="">
                    <td style="border-width:0px; padding:0rem; margin:0rem; width:50%;">
                        {{-- CTS FOCȘANI:
                        <br> --}}
                        BON DE LIVRARE NR: {{ $recoltareSangeComanda->comanda_nr }}
                        <br>
                        AVIZ NR: {{ $recoltareSangeComanda->aviz_nr }}
                    </td>
                    <td style="border-width:0px; padding:0rem; margin:0rem; width:50%; text-align:right;">
                        CĂTRE SPITALUL: {{ $recoltareSangeComanda->beneficiar->nume ?? '' }}
                    </td>
                </tr>
            </table>

            <br>

            <table>
                <thead>
                    <tr valign="top" style="">
                        <th>#</th>
                        <th>Fel produs</th>
                        <th>Grupa</th>
                        <th>Rh</th>
                        <th>Cod</th>
                        <th>Cant.</th>
                        <th>Dată<br>recoltare</th>
                        <th>Dată<br>expirare</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recoltareSangeComanda->recoltariSange->sortBy('produs.nume') as $recoltareSange)
                        {{-- @if ($loop->odd) <tr> @endif --}}
                        <tr>
                            <td style="text-align:center;">{{ $loop->iteration }}</td>
                            <td style="text-align:center;">{{ $recoltareSange->produs->nume ?? '' }}</td>
                            <td style="text-align:center;">{{ substr_replace(($recoltareSange->grupa->nume ?? ''), "", -1) }}</td>
                            <td style="text-align:center;">{{ substr(($recoltareSange->grupa->nume ?? ''), -1) }}</td>
                            <td>{{ $recoltareSange->cod }}</td>
                            <td style="text-align:right;">{{ $recoltareSange->cantitate }}</td>
                            <td style="text-align:right;">{{ $recoltareSange->data ? \Carbon\Carbon::parse($recoltareSange->data)->isoFormat('DD.MM.YYYY') : ''}}</td>
                            <td style="text-align:right;">
                                @if ($recoltareSange->data !== "2023-06-30")
                                    @switch($recoltareSange->produs->nume ?? '')
                                        @case ('CTS')
                                        @case ('CUT')
                                            {{ $recoltareSange->data ? \Carbon\Carbon::parse($recoltareSange->data)->addDays(5)->isoFormat('DD.MM.YYYY') : ''}}
                                            @break
                                        @case ('CER')
                                        @case ('CER-SL')
                                        @case ('CER-DL')
                                            {{ $recoltareSange->data ? \Carbon\Carbon::parse($recoltareSange->data)->addDays(42)->isoFormat('DD.MM.YYYY') : ''}}
                                            @break
                                        @case ('PPC')
                                            {{ $recoltareSange->data ? \Carbon\Carbon::parse($recoltareSange->data)->addYears(1)->isoFormat('DD.MM.YYYY') : ''}}
                                            @break
                                    @endswitch
                                @endif
                            </td>
                        {{-- @if ($loop->odd) <td style="border-width:0px;"></td> @endif
                        @if ($loop->odd && $loop->last) <td></td><td></td><td></td><td></td><td></td> @endif
                        @if ($loop->even || $loop->last) </tr> @endif --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <br>

            <table style="text-align:center">
                <tr valign="top" style="">
                    @foreach ($recoltareSangeComanda->recoltariSange->sortBy('produs.nume')->groupBy('recoltari_sange_produs_id') as $recoltariSangeGrupateDupaProdus)
                    <td style="border-width:0px;">
                        {{ $recoltariSangeGrupateDupaProdus->first()->produs->nume ?? '' }}:
                        <br>
                        {{ $recoltariSangeGrupateDupaProdus->count() }} pungi
                        <br>
                        {{ number_format((float)($recoltariSangeGrupateDupaProdus->sum('cantitate') / 1000), 2, '.', '') }} litri
                    </td>
                    @endforeach
                    <td style="border-width:0px;">
                        TOTAL:
                        <br>
                        {{ $recoltareSangeComanda->recoltariSange->count() }} pungi
                        <br>
                        {{ number_format((float)($recoltareSangeComanda->recoltariSange->sum('cantitate') / 1000), 2, '.', '') }} litri
                    </td>
                </tr>
            </table>

            <br>

            <div style="page-break-inside: avoid">
            <table style="text-align:center">
                <tr valign="top" style="">
                    <td style="border-width:1px; text-align:center;">
                        Data:
                        <br>
                        {{ $recoltareSangeComanda->data ? \Carbon\Carbon::parse($recoltareSangeComanda->data)->isoFormat('DD.MM.YYYY') : '' }}
                    </td>
                    <td style="border-width:1px;">
                        Ora livrare:
                        <br>
                        {{ \Carbon\Carbon::now()->isoFormat('HH:mm') }}
                        <br><br>
                    </td>
                    <td style="border-width:1px;">
                        Ora recepție:
                        <br><br><br>
                    </td>
                </tr>
                <tr>
                    <td style="border-width:0px;"></td>
                    <td style="border-width:1px;">
                        Temperatura la livrare:
                        <br><br><br>
                    </td>
                    <td style="border-width:1px;">
                        Temperatura la recepție:
                        <br><br><br>
                    </td>
                </tr>
            </table>

            <br>

            <table style="text-align:center">
                <tr valign="top" style="">
                    <td style="border-width:0px;">
                        EXPEDITOR:
                    </td>
                    <td style="border-width:0px;">
                        PRIMITOR:
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
