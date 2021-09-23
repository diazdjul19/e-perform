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
    public function noc_dialy_report()
    {
        $get_auth = Auth::user();

        if ($get_auth->role == "admin" || $get_auth->role == "noc") {
            $data = MsNocReport::with('jnsuser', 'jnslink')->get();
        }else {
            return abort(404);
        }

        $id_dialy = MsNocReport::orderBy('id', 'DESC')->first();
        if ($id_dialy == null) {
            $tiket_autogenerate = "ICT" . "-" . str_pad(1, 6, "0", STR_PAD_LEFT);
        }else {
            $tiket_autogenerate = "ICT" . "-" . str_pad($id_dialy->id + 1, 6, "0", STR_PAD_LEFT);
        }

        $data_user = User::where('role', 'admin')->orWhere('role', 'noc')->get();
        $data_link = MsLink::all();

        return view('dashboard_view.noc_management.noc_dialy_report', compact('data', 'tiket_autogenerate', 'data_user', 'data_link'));
    }

    public function noc_dialy_report_store(Request $request)
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
            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Created',"Ticket $data->tiket_report has been successfully entered.");
            return redirect(route('noc-dialy-report'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('noc-dialy-report'));
        }
    }

    public function noc_dialy_report_editshow($id)
    {
        $get_auth = Auth::user();

        if ($get_auth->role == "admin" || $get_auth->role == "noc") {
            $data = MsNocReport::with('jnsuser', 'jnslink')->find($id);
        }else {
            return abort(404);
        }

        $data_user = User::where('role', 'admin')->orWhere('role', 'noc')->get();
        $data_link = MsLink::all();
        
        return view('dashboard_view.noc_management.noc_dialy_report_editshow', compact('data', 'data_user', 'data_link'));

    }

    public function noc_dialy_report_update(Request $request, $id)
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
            $data->solution = $request->get('solution');
            $data->dari_long = date('Y-m-d H:i:s',strtotime($request->input('dari_long')));
            $data->sampai_long = date('Y-m-d H:i:s',strtotime($request->input('sampai_long')));
            $data->status = $request->get('status');
            $data->notes = $request->get('notes');
            $data->save();
            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Updated',"Ticket $data->ticket_report has been successfully updated.");
            return redirect(route('noc-dialy-report'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('noc-dialy-report'));
        }
    }

    public function select_delete_dialy_report_noc(Request $request)
    {
        $select_delete = $request->get('select_delete');

        if ($select_delete == true) {

            $data_confirm = MsNocReport::whereIn('id', $select_delete)->get('id');

            if ($data_confirm == true) {
                $delete_now = MsNocReport::whereIn('id', $data_confirm)->delete();
            } else {
                return "Gagal Menghapus Data :(";
            }

            alert()->info('Success Delete',"Data Berhasil Di Hapus");
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}