<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RecoltareSange;
use App\Models\RecoltareSangeRebut;
use App\Models\RecoltareSangeProdus;
use App\Models\RecoltareSangeProdusPret;
use App\Models\RecoltareSangeComanda;
use App\Models\RecoltareSangeCerere;


class RaportController extends Controller
{
    public function index(Request $request)
    {
        // $request->session()->forget('raportReturnUrl');
        $interval = $request->interval;
        $produse = RecoltareSangeProdus::all();

        switch ($request->input('action')) {
            case 'recoltariSangeCtsvToate':
                $request->validate(['interval' => 'required']);
                $query = RecoltareSange::
                    with('produs', 'comanda')
                    ->whereNull('intrare_id')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->latest();
                $recoltariSange = $query->get();

                $livrari = RecoltareSange::with('comanda.beneficiar')
                    ->whereHas('comanda', function ($query) use($interval) {
                        return $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();

                $rebutari = RecoltareSange::with('produs')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('rebut_data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();

                // return view('rapoarte.export.recoltariSangeCtsvToate', compact('recoltariSange', 'livrari', 'rebutari', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.recoltariSangeCtsvToate', compact('recoltariSange', 'livrari', 'rebutari', 'interval'))
                    ->setPaper('a4', 'portrait');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'recoltariSangeCtsvToateDetaliatPeZile':
                $request->validate(['interval' => 'required']);
                $query = RecoltareSange::
                    with('produs', 'comanda')
                    ->whereNull('intrare_id')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->latest();
                $recoltariSange = $query->get();

                return view('rapoarte.export.recoltariSangeCtsvToateDetaliatPeZile', compact('recoltariSange', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.recoltariSangeCtsvToateDetaliatPeZile', compact('recoltariSange', 'interval'))
                    ->setPaper('a4', 'landscape');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'intrariDetaliatePeZile':
                $request->validate(['interval' => 'required']);

                $recoltariSange = RecoltareSange::with('produs', 'intrare')
                    ->whereHas('intrare', function ($query) use ($interval) {
                        $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();

                // return view('rapoarte.export.intrariDetaliatePeZile', compact('recoltariSange', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.intrariDetaliatePeZile', compact('recoltariSange', 'interval'))
                    ->setPaper('a4', 'landscape');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'livrariDetaliatePeZile':
                $request->validate(['interval' => 'required']);

                $recoltariSange = RecoltareSange::with('produs', 'comanda')
                    ->whereHas('comanda', function ($query) use ($interval) {
                        $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();

                // return view('rapoarte.export.livrariDetaliatePeZile', compact('recoltariSange', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.livrariDetaliatePeZile', compact('recoltariSange', 'interval'))
                    ->setPaper('a4', 'landscape');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'rebuturiDetaliatePeZile':
                $request->validate(['interval' => 'required']);

                $recoltariSange = RecoltareSange::with('rebut')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('rebut_data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->orderBy('rebut_data')
                    ->get();
                $rebuturi = RecoltareSangeRebut::select('id', 'nume')->orderBy('nume')->get();

                // return view('rapoarte.export.rebuturiDetaliatePeZile', compact('recoltariSange', 'rebuturi', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.rebuturiDetaliatePeZile', compact('recoltariSange', 'rebuturi', 'interval'))
                    ->setPaper('a4', 'landscape');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'rebuturiDetaliatePeZileGrupatePerProdus':
                $request->validate(['interval' => 'required']);

                $recoltariSange = RecoltareSange::with('rebut', 'produs')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('rebut_data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->orderBy('rebut_data')
                    ->get();
                $rebuturi = RecoltareSangeRebut::select('id', 'nume')->orderBy('nume')->get();

                foreach($recoltariSange as $recoltare){
                    if (str_contains(($recoltare->produs->nume ?? ''), "CE")){
                        $recoltare->categorieProdus = "CE";
                    }elseif (str_contains(($recoltare->produs->nume ?? ''), "CTS")){
                        $recoltare->categorieProdus = "CTS";
                    }elseif (str_contains(($recoltare->produs->nume ?? ''), "PPC")){
                        $recoltare->categorieProdus = "PPC";
                    }elseif (str_contains(($recoltare->produs->nume ?? ''), "REBUT")){
                        $recoltare->categorieProdus = "Rebut recoltare";
                    }else {
                        $recoltare->categorieProdus = "Rebuturi alte produse";
                    }
                }

                $recoltariSange = $recoltariSange->sortBy('categorieProdus');

                $recoltariSangeGrupatePerCategorieProdus = $recoltariSange->groupBy('categorieProdus');

                // return view('rapoarte.export.rebuturiDetaliatePeZile', compact('recoltariSange', 'rebuturi', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.rebuturiDetaliatePeZileGrupatePerProdus', compact('recoltariSangeGrupatePerCategorieProdus', 'rebuturi', 'interval'))
                    ->setPaper('a4', 'landscape');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'recoltariNevalidate':
                $request->validate(['interval' => 'required']);

                $recoltariSange = RecoltareSange::with('produs', 'grupa')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->where('validat', 0)
                    ->orderBy('data')
                    ->get();

                // return view('rapoarte.export.rebuturiToate', compact('recoltariSange', 'rebuturi', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.recoltariNevalidate', compact('recoltariSange', 'interval'))
                    ->setPaper('a4', 'portrait');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'stocuriPungiSange':
                $request->validate(['interval' => 'required']);
                $recoltariSange = RecoltareSange::with('produs', 'grupa')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereDate('data', '<', [strtok($interval, ',')]);
                    })
                    ->where(function($query) use ($interval){
                        $query->whereDoesntHave('comanda')
                            ->orWhereHas('comanda', function ($query) use ($interval) {
                                $query->whereDate('data', '>=', [strtok($interval, ',')]);
                            });
                    })
                    ->where(function($query) use ($interval){
                        $query->whereNull('rebut_data')
                            ->orwhereDate('rebut_data',  '>=', [strtok($interval, ',')]);
                    })
                    ->get();

                return view('rapoarte.stocuriPungiSange', compact('recoltariSange', 'interval'));

                return view('rapoarte.export.stocuriPungiSange', compact('recoltariSange', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.stocuriPungiSange', compact('recoltariSange', 'interval'))
                    ->setPaper('a4', 'portrait');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Stocuri pungi sange.pdf');
                return $pdf->stream();

            case 'situatiaSangeluiSiAProduselorDinSange':
                $request->validate(['interval' => 'required']);
                $recoltariSangeInterval = RecoltareSange::with('produs')
                    // ->select('id', 'recoltari_sange_produs_id', 'cantitate')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();
                $recoltariSangeInitiale = RecoltareSange::with('produs')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereDate('data', '<', [strtok($interval, ',')]);
                    })
                    ->where(function($query) use ($interval){
                        $query->whereDoesntHave('comanda')
                            ->orWhereHas('comanda', function ($query) use ($interval) {
                                $query->whereDate('data', '>=', [strtok($interval, ',')]);
                            });
                    })
                    ->where(function($query) use ($interval){
                        $query->whereNull('rebut_data')
                            ->orwhereDate('rebut_data',  '>=', [strtok($interval, ',')]);
                    })
                    ->get();
                $recoltariSangeRebutate = RecoltareSange::with('produs')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('rebut_data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();
                $recoltariSangeLivrate = RecoltareSange::with('produs', 'comanda')
                    ->whereHas('comanda', function ($query) use ($interval) {
                        $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();
                $recoltariSangeStocFinal = RecoltareSange::with('produs')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereDate('data', '<=', explode(',', $interval, 2)[1]);
                    })
                    ->where(function($query) use ($interval){
                        $query->whereDoesntHave('comanda')
                            ->orWhereHas('comanda', function ($query) use ($interval) {
                                $query->whereDate('data', '>', explode(',', $interval, 2)[1]);
                            });
                    })
                    ->where(function($query) use ($interval){
                        $query->whereNull('rebut_data')
                            ->orwhereDate('rebut_data',  '>', explode(',', $interval, 2)[1]);
                    })
                    ->get();

                $produseIds = [];
                foreach ($recoltariSangeInterval as $recoltare){
                    if (!in_array($recoltare->produs->id, $produseIds)){
                        array_push($produseIds, $recoltare->produs->id);
                    }
                }
                foreach ($recoltariSangeInitiale as $recoltare){
                    if (!in_array($recoltare->produs->id, $produseIds)){
                        array_push($produseIds, $recoltare->produs->id);
                    }
                }
                foreach ($recoltariSangeRebutate as $recoltare){
                    if (!in_array($recoltare->produs->id, $produseIds)){
                        array_push($produseIds, $recoltare->produs->id);
                    }
                }
                foreach ($recoltariSangeLivrate as $recoltare){
                    if (!in_array($recoltare->produs->id, $produseIds)){
                        array_push($produseIds, $recoltare->produs->id);
                    }
                }
                foreach ($recoltariSangeStocFinal as $recoltare){
                    if (!in_array($recoltare->produs->id, $produseIds)){
                        array_push($produseIds, $recoltare->produs->id);
                    }
                }
                $produse = RecoltareSangeProdus::with('preturi')->whereIn('id', $produseIds)->where('nume', '<>', 'REBUT')->orderBy('nume')->get();
                $produsePreturi = RecoltareSangeProdusPret::with('produs')->where('activ', 1)->get();

                // return view('rapoarte.export.situatiaSangeluiSiAProduselorDinSange', compact('recoltariSangeInterval', 'recoltariSangeInitiale', 'recoltariSangeRebutate', 'recoltariSangeLivrate', 'recoltariSangeStocFinal', 'produse', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.situatiaSangeluiSiAProduselorDinSange', compact('recoltariSangeInterval', 'recoltariSangeInitiale', 'recoltariSangeRebutate', 'recoltariSangeLivrate', 'recoltariSangeStocFinal', 'produse', 'produsePreturi', 'interval'))
                    ->setPaper('a4', 'landscape');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Stocuri pungi sange.pdf');
                return $pdf->stream();

            case 'DProcesare':
                $request->validate(['interval' => 'required']);
                $recoltariSangeFaraRebutRecoltare = RecoltareSange::
                    with('rebut', 'produs')
                    ->whereNull('intrare_id')
                    ->where(function($query) {
                        $query->whereNull('recoltari_sange_rebut_id')
                            ->orwhere('recoltari_sange_rebut_id', '<>', 1);
                    })
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->latest()
                    ->get();
                $recoltariSangeRebutProcesareAspectChilos = RecoltareSange::
                    with('rebut', 'produs')
                    // ->whereNull('intrare_id')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->where('recoltari_sange_rebut_id', 3) // Rebuturi de procesare - Aspect chilos
                    ->latest()
                    ->get();

                // return view('rapoarte.export.DProcesare', compact('recoltariSange', 'rebuturi', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.DProcesare', compact('recoltariSangeFaraRebutRecoltare', 'recoltariSangeRebutProcesareAspectChilos', 'interval'))
                    ->setPaper('a4', 'portrait');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'G1Rebut':
                $request->validate(['interval' => 'required']);
                $recoltariSange = RecoltareSange::
                    with('rebut', 'produs')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('rebut_data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();
                $rebuturi = RecoltareSangeRebut::select('id', 'nume')->orderBy('nume')->get();

                // return view('rapoarte.export.G1Rebut', compact('recoltariSange', 'rebuturi', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.G1Rebut', compact('recoltariSange', 'rebuturi', 'interval'))
                    ->setPaper('a4', 'portrait');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'G2RebutRepartitie':
                $request->validate(['interval' => 'required']);
                $recoltariSange = RecoltareSange::
                    with('rebut', 'produs')
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('rebut_data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->latest()
                    ->get();
                $rebuturi = RecoltareSangeRebut::select('id', 'nume')->orderBy('nume')->get();

                // return view('rapoarte.export.G2RebutRepartitie', compact('recoltariSange', 'rebuturi', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.G2RebutRepartitie', compact('recoltariSange', 'rebuturi', 'interval'))
                    // ->setPaper('a4', 'portrait');
                    ->setPaper('a4', 'landscape');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'HUnitatiValidateDonareStandard':
                $request->validate(['interval' => 'required']);
                $recoltariSange = RecoltareSange::
                    whereNull('intrare_id')
                    ->where('recoltari_sange_produs_id', '<>', 7) // 7 este id-ul pentru REBUT
                    // ->where(function($query) use ($interval){
                    //     $query->whereNull('rebut_data')
                    //         ->orWhereNotBetween('rebut_data', [strtok($interval, ','), strtok( '' )]);
                    // })
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->latest()
                    ->get();

                $rebuturi = RecoltareSange::
                    // whereNull('intrare_id')
                    when($interval, function ($query, $interval) {
                        return $query->whereBetween('rebut_data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->latest()
                    ->get();

                // return view('rapoarte.export.HUnitatiValidateDonareStandard', compact('recoltariSange', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.HUnitatiValidateDonareStandard', compact('recoltariSange', 'rebuturi', 'interval'))
                    ->setPaper('a4', 'portrait');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'JCerereSiDistributie':
                $request->validate(['interval' => 'required']);
                $cereri = RecoltareSangeCerere::with('produs')
                    ->whereHas('comanda', function ($query) use ($interval) {
                        $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();

                $recoltariSangeDeLaComenziFaraCereriAdaugate = RecoltareSange::with('produs')
                    ->whereHas('comanda', function ($query) use ($interval) {
                        $query->whereDoesntHave('cereri')
                            ->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();

                // dd($cereri->sum('nr_pungi'));

                $recoltariSangeDistribuite = RecoltareSange::with('produs')
                    ->whereHas('comanda', function ($query) use ($interval) {
                        $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();
                $recoltariSangeDistribuiteInJudet = RecoltareSange::with('produs')
                    ->whereHas('comanda', function ($query) use ($interval) {
                        $query->whereIn('recoltari_sange_beneficiar_id', [1,2,3])
                            ->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();
                $recoltariSangeDistribuiteCatreAlteCts = RecoltareSange::with('produs')
                    ->whereHas('comanda', function ($query) use ($interval) {
                        $query->whereNotIn('recoltari_sange_beneficiar_id', [1,2,3])
                            ->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();
                $recoltariSangePrimite = RecoltareSange::with('produs')
                    ->whereHas('intrare', function ($query) use ($interval) {
                        $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();

                // return view('rapoarte.export.JCerereSiDistributie', compact('cereri', 'recoltariSangeDeLaComenziFaraCereriAdaugate', 'recoltariSangeDistribuite', 'recoltariSangeDistribuiteInJudet', 'recoltariSangeDistribuiteCatreAlteCts', 'recoltariSangePrimite', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.JCerereSiDistributie', compact('cereri', 'recoltariSangeDeLaComenziFaraCereriAdaugate', 'recoltariSangeDistribuite', 'recoltariSangeDistribuiteInJudet', 'recoltariSangeDistribuiteCatreAlteCts', 'recoltariSangePrimite', 'interval'))
                    ->setPaper('a4', 'portrait');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'MIncidenteDeaLungulActivitatiiDinCts':
                $request->validate(['interval' => 'required']);
                $numarRebuturiCantitate = RecoltareSange::
                    where('recoltari_sange_rebut_id', 1) // Rebut recoltare, rebut cantitate
                    ->when($interval, function ($query, $interval) {
                        return $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->count();

                // return view('rapoarte.export.G1Rebut', compact('recoltariSange', 'rebuturi', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.MIncidenteDeaLungulActivitatiiDinCts', compact('numarRebuturiCantitate', 'interval'))
                    ->setPaper('a4', 'portrait');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();

            case 'livrariPerProdusPerGrupa':
                $request->validate(['interval' => 'required']);

                $recoltariSange = RecoltareSange::with('produs', 'grupa', 'comanda.beneficiar')
                    ->whereHas('comanda', function ($query) use ($interval) {
                        $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                    })
                    ->get();

                $recoltariSange = $recoltariSange->sortBy('grupa.nume')->sortBy('produs.nume');

                // return view('rapoarte.export.livrariDetaliatePeZile', compact('recoltariSange', 'interval'));
                $pdf = \PDF::loadView('rapoarte.export.livrariPerProdusPerGrupa', compact('recoltariSange', 'interval'))
                    ->setPaper('a4', 'portrait');
                $pdf->getDomPDF()->set_option("enable_php", true);
                // return $pdf->download('Contract ' . $comanda->transportator_contract . '.pdf');
                return $pdf->stream();


            default:
                    $query = RecoltareSange::
                        when($interval, function ($query, $interval) {
                            return $query->whereBetween('data', [strtok($interval, ','), strtok( '' )]);
                        })
                        ->latest();

                    $recoltariSange = $query->get();

                    return view('rapoarte.index', compact('recoltariSange', 'interval', 'produse'));
                break;
        }
    }

    public function stocuriPungiSange(Request $request)
    {
        $interval = $request->interval;
        $grupa = $request->input('action');

        $request->validate(['interval' => 'required']);
        $recoltariSange = RecoltareSange::with('produs', 'grupa')
            ->when($interval, function ($query, $interval) {
                return $query->whereDate('data', '<', [strtok($interval, ',')]);
            })
            ->when($grupa, function ($query, $grupa) {
                return $query->where('recoltari_sange_grupa_id', $grupa);
            })
            ->where(function($query) use ($interval){
                $query->whereDoesntHave('comanda')
                    ->orWhereHas('comanda', function ($query) use ($interval) {
                        $query->whereDate('data', '>=', [strtok($interval, ',')]);
                    });
            })
            ->where(function($query) use ($interval){
                $query->whereNull('rebut_data')
                    ->orwhereDate('rebut_data',  '>=', [strtok($interval, ',')]);
            })
            ->where('recoltari_sange_produs_id', $request->produsId)
            // ->take(1000)
            ->get();

        // return view('rapoarte.export.stocuriPungiSange', compact('recoltariSange', 'interval'));
        $pdf = \PDF::loadView('rapoarte.export.stocuriPungiSange', compact('recoltariSange', 'interval'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        // return $pdf->download('Stocuri pungi sange.pdf');
        return $pdf->stream();
    }
}
