<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Rebuturi</title>
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

            @include('rapoarte.export.includes.header')


            <table style="">
                <tr valign="" style="">
                    <td style="border-width:0px; text-align:center;">
                        <h3 style="margin: 0">RAPORT</h3>
                        Perioada: {{ \Carbon\Carbon::parse(strtok($interval, ','))->isoFormat('DD.MM.YYYY') }} - {{ \Carbon\Carbon::parse(strtok(''))->isoFormat('DD.MM.YYYY')}}
                    </td>
                </tr>
            </table>

            <br>

            {{-- <p style="margin:0%; text-align: center"><b>G.1. REBUT - CS</b></p> --}}
            <table style="width: 50%; margin-left:auto; margin-right:auto;">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align:center">
                            G.1. REBUT - CS
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align:center">Produs</th>
                        <th style="text-align:center">Pungi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.1.a CE (indiferent de tip)</td>
                        <td style="text-align:right">{{ $recoltariSange->whereIn('produs.nume', ['CER', 'CER-SL', 'CER-DL'])->count() }}</td>
                    </tr>
                    <tr>
                        <td>1.1.b CT</td>
                        <td style="text-align:right">{{ $recoltariSange->whereIn('produs.nume', ['CT', 'CTS'])->count() }}</td>
                    </tr>
                    <tr>
                        <td>1.1.c PPC</td>
                        <td style="text-align:right">{{ $recoltariSange->whereIn('produs.nume', ['PC', 'PPC'])->count() }}</td>
                    </tr>
                    <tr>
                        <td>1.1.d CRIO</td>
                        <td style="text-align:right">{{ $recoltariSange->whereIn('produs.nume', ['CRIO'])->count() }}</td>
                    </tr>
                    <tr>
                        <td>1.1.e CUT-DL</td>
                        <td style="text-align:right">{{ $recoltariSange->whereIn('produs.nume', ['CUT'])->count() }}</td>
                    </tr>

                    {{-- Daca nu a fost in cele de mai sus, sau daca nu a fost la REBUT, atunci se afiseaza separat --}}
                    @foreach ($recoltariSange->whereNotIn('produs.nume', ['CER', 'CER-SL', 'CER-DL', 'CT', 'CTS', 'PC', 'PPC', 'CRIO', 'CUT', 'REBUT'])->sortBy('produs.nume')->groupBy('recoltari_sange_produs_id') as $recoltariSangeGrupateDupaProdus)
                    <tr>
                        <td>{{ $recoltariSangeGrupateDupaProdus->first()->produs->nume ?? '' }}</td>
                        <td style="text-align:right">{{ $recoltariSangeGrupateDupaProdus->count() }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td style="text-align:right"><b>Total<b></td>
                        <td style="text-align:right"><b>{{ $recoltariSange->whereNotIn('produs.nume', ['REBUT'])->count() }}</b></td>
                    </tr>
                </tbody>
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
