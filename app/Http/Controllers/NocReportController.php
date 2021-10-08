<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MsNocReport;
use App\User;
use App\Models\MsLink;

use DateTime;

class NocReportController extends Controller
{
    public function noc_daily_report()
    {
        $get_auth = Auth::user();

        if ($get_auth->role == "admin" || $get_auth->role == "noc") {
            $data = MsNocReport::with('jnsuser', 'jnslink')->get();
        }else {
            return abort(404);
        }

        $id_daily = MsNocReport::orderBy('id', 'DESC')->first();
        if ($id_daily == null) {
            // $tiket_autogenerate = "ICT" . "-" . str_pad(1, 6, "0", STR_PAD_LEFT);
            $tiket_autogenerate = "AutoGenerage-Tiket";

        }else {
            $tiket_autogenerate = "ICT" . "-" . str_pad($id_daily->id + 1, 6, "0", STR_PAD_LEFT);
        }

        $data_user = User::where('email', '!=', 'setlightcombo@gmail.com')->where('role', 'admin')->orWhere('role', 'noc')->get();
        $data_link = MsLink::all();

        return view('dashboard_view.noc_management.noc_daily_report', compact('data', 'tiket_autogenerate', 'data_user', 'data_link'));
    }

    public function noc_daily_report_store(Request $request)
    {
        $this->validate($request, [
            'tiket_report' => ['required', 'string', 'max:255'],
            'id_user_rel' => ['required', 'integer', 'min:1'],
            'id_link_rel' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string', 'max:255'],

        ]);

        try {

            \DB::beginTransaction();

            $data = new MsNocReport;
            $data->tiket_report = $request->tiket_report;
            $data->id_user_rel = $request->id_user_rel;
            $data->id_link_rel = $request->id_link_rel;
            $data->issues = $request->issues;
            $data->solution = $request->solution;
            $data->dari_long = date('Y-m-d H:i:s',strtotime($request->input('dari_long')));
            $data->sampai_long = date('Y-m-d H:i:s',strtotime($request->input('sampai_long')));
            $data->status = $request->status;
            $data->notes = $request->notes;
            $data->save();

            // Ini fungsi untuk generate otomatis untuk yang pertama.
            if ($data->tiket_report == "AutoGenerage-Tiket") {
                $tiket_autogenerate_first = "ICT" . "-" . str_pad($data->id, 6, "0", STR_PAD_LEFT);
                $data->update(['tiket_report' => $tiket_autogenerate_first]);
            }

            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Created',"Ticket $data->tiket_report has been successfully entered.");
            return redirect(route('noc-daily-report'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('noc-daily-report'));
        }
    }

    public function noc_daily_report_editshow($id)
    {
        $get_auth = Auth::user();

        if ($get_auth->role == "admin" || $get_auth->role == "noc") {
            $data = MsNocReport::with('jnsuser', 'jnslink')->find($id);
        }else {
            return abort(404);
        }

        $data_user = User::where('email', '!=', 'setlightcombo@gmail.com')->where('role', 'admin')->orWhere('role', 'noc')->get();
        $data_link = MsLink::all();
        
        return view('dashboard_view.noc_management.noc_daily_report_editshow', compact('data', 'data_user', 'data_link'));

    }

    public function noc_daily_report_update(Request $request, $id)
    {
        $this->validate($request, [
            'tiket_report' => ['required', 'string', 'max:255'],
            'id_user_rel' => ['required', 'integer', 'min:1'],
            'id_link_rel' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string', 'max:255'],

        ]);

        try {

            \DB::beginTransaction();

            $data = MsNocReport::find($id);
            $data->tiket_report = $request->get('tiket_report');
            $data->id_user_rel = $request->get('id_user_rel');
            $data->id_link_rel = $request->get('id_link_rel');
            $data->issues = $request->get('issues');
            $data->status = $request->get('status');
            if ($request->status == "solved") {
                $data->solution = $request->get('solution');
                $data->dari_long = date('Y-m-d H:i:s',strtotime($request->input('dari_long')));
                $data->sampai_long = date('Y-m-d H:i:s',strtotime($request->input('sampai_long')));
            }
            $data->notes = $request->get('notes');
            $data->save();
            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Updated',"Ticket $data->ticket_report has been successfully updated.");
            return redirect(route('noc-daily-report'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('noc-daily-report'));
        }
    }

    public function select_delete_daily_report_noc(Request $request)
    {
        $select_delete = $request->get('select_delete');

        if ($select_delete == true) {

            $data_confirm = MsNocReport::whereIn('id', $select_delete)->get('id');

            if ($data_confirm == true) {
                $delete_now = MsNocReport::whereIn('id', $data_confirm)->delete();
            } else {
                return "Gagal Menghapus Data :(";
            }

            alert()->success('Success Delete',"Data Berhasil Di Hapus");
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }



    public function perform_noc_history()
    {
        $get_auth = Auth::user();

        if ($get_auth->role == "admin") {
            $data = MsNocReport::with('jnsuser', 'jnslink')->get();
            $data_user = User::where('role', 'admin')->orWhere('role', 'noc')->get();
            $data_link = MsLink::all();

            return view('dashboard_view.noc_management.perform_noc_history', compact('data', 'data_user', 'data_link'));
        }else {
            return abort(404);
        }
    }

    public function perform_noc_history_get(Request $request)
    {
        // data url untuk get link
        $data_url = $request->fullUrl();
        $data_url = \Str::substr($data_url, 46);

        // Data From perform_noc_history
        $get_auth = Auth::user();

        if ($get_auth->role == "admin") {
            $data = MsNocReport::with('jnsuser', 'jnslink')->get();
            $data_user = User::where('role', 'admin')->orWhere('role', 'noc')->get();
            $data_link = MsLink::all();

        }else {
            return abort(404);
        }


        $this->validate($request, [
            'id_user_rel' => ['required', 'integer', 'min:1'],
            'id_link_rel' => ['required', 'numeric'],
            'status' => ['required', 'string', 'max:255'],

        ]);

        // Data Pendukung (whereBetween)
        $data_dari_long = date('Y-m-d H:i',strtotime($request->input('from_long')));
        $data_sampai_long = date('Y-m-d H:i',strtotime($request->input('after_long')));

        if ($request->status == "solved") {

            if ($data_dari_long == "1970-01-01 00:00" || $data_sampai_long == "1970-01-01 00:00") {
                alert()->error('ErrorAlert','Pastikan field (From Time / After Time) sudah terisi !!!');
                return redirect(route('perform-noc-history'));  
            }else {
                if ($request->id_link_rel != "0101010101" ) {
                    $data_history = MsNocReport::whereBetween('created_at',[$data_dari_long, $data_sampai_long])
                        ->where('id_user_rel',$request->id_user_rel)
                        ->where('id_link_rel',$request->id_link_rel)
                        ->where('status',$request->status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }elseif ($request->id_link_rel == "0101010101" ) {
                    $data_history = MsNocReport::whereBetween('created_at',[$data_dari_long, $data_sampai_long])
                        ->where('id_user_rel',$request->id_user_rel)
                        ->where('status',$request->status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }else {
                    return abort(404);   
                }
            }        
            
        } elseif ($request->status == "ocn" || $request->status == "n_solved") {
            if ($data_dari_long == "1970-01-01 00:00" || $data_sampai_long == "1970-01-01 00:00") {
                if ($request->id_link_rel != "0101010101" ) {
                    $data_history = MsNocReport::where('id_user_rel',$request->id_user_rel)
                        ->where('id_link_rel',$request->id_link_rel)
                        ->where('status',$request->status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }elseif ($request->id_link_rel == "0101010101" ) {
                    $data_history = MsNocReport::where('id_user_rel',$request->id_user_rel)
                        ->where('status',$request->status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }else {
                    return abort(404);   
                }
            }

        } else{
            return abort(404); 
        }

        return view('dashboard_view.noc_management.perform_noc_history', compact('data_history', 'data', 'data_user', 'data_link', 'data_url'));
        
        
    }

    public function pdf_daily_report_noc(Request $request)
    {
        $data = MsNocReport::with('jnsuser', 'jnslink')->get();
        $pdf = \PDF::loadView('pdf.pdf_daily_report_noc', compact('data'))->setPaper('A4')->setOrientation('landscape');
        return $pdf->download("NOC-Daily-Report.pdf");

    }

    public function download_perform_noc_history(Request $request)
    {
        $this->validate($request, [
            'id_user_rel' => ['required', 'integer', 'min:1'],
            'id_link_rel' => ['required', 'numeric'],
            'status' => ['required', 'string', 'max:255'],

        ]);

        // Data Pendukung (whereBetween)
        $data_dari_long = date('Y-m-d H:i',strtotime($request->input('from_long')));
        $data_sampai_long = date('Y-m-d H:i',strtotime($request->input('after_long')));
        $data_link = $request->id_link_rel;
        $data_user = $request->id_user_rel;
        $data_status = $request->status;

        if ($data_status == "solved") {

            if ($data_dari_long == "1970-01-01 00:00" || $data_sampai_long == "1970-01-01 00:00") {
                alert()->error('ErrorAlert','Pastikan field (From Time / After Time) sudah terisi !!!');
                return redirect(route('perform-noc-history'));  
            }else {
                if ($data_link != "0101010101" ) {
                    $data_history = MsNocReport::whereBetween('created_at',[$data_dari_long, $data_sampai_long])
                        ->where('id_user_rel',$data_user)
                        ->where('id_link_rel',$data_link)
                        ->where('status',$data_status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }elseif ($data_link == "0101010101" ) {
                    $data_history = MsNocReport::whereBetween('created_at',[$data_dari_long, $data_sampai_long])
                        ->where('id_user_rel',$data_user)
                        ->where('status',$data_status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }else {
                    return abort(404);   
                }
            }        
            
        } elseif ($data_status == "ocn" || $data_status == "n_solved") {
            if ($data_dari_long == "1970-01-01 00:00" || $data_sampai_long == "1970-01-01 00:00") {
                if ($data_link != "0101010101" ) {
                    $data_history = MsNocReport::where('id_user_rel',$data_user)
                        ->where('id_link_rel',$data_link)
                        ->where('status',$data_status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }elseif ($data_link == "0101010101" ) {
                    $data_history = MsNocReport::where('id_user_rel',$data_user)
                        ->where('status',$data_status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }else {
                    return abort(404);   
                }
            }

        } else{
            return abort(404); 
        }

        $getname = User::where('id', $data_user)->first();

        $pdf = \PDF::loadView('pdf.pdf_perform_noc_history', compact('data_history', 'data', 'data_user', 'data_link', 'data_url', 'getname', 'data_dari_long', 'data_sampai_long'))->setPaper('A4')->setOrientation('landscape');
        return $pdf->download("NOC-Daily-Report-($getname->name).pdf");



    }
}