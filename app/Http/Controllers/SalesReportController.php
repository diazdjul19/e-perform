<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\MsLobbyist;
use App\Models\MsSalesReport;
use App\Models\MsClient;
use App\Models\MsCapacity;
use App\Models\MsSite;

use Auth;
use Webpatser\Uuid\Uuid;

class SalesReportController extends Controller
{
    public function sales_lobbyist_process()
    {
        $get_auth = Auth::user();

        if ($get_auth->role == "admin" || $get_auth->role == "sales") {
            $data = MsLobbyist::all();
            return view('dashboard_view.sales_management.sales_lobbyist_process', compact('data'));
        }else {
            return abort(404);
        }
    }

    public function sales_lobbyist_store(Request $request)
    {
        $get_auth = Auth::user();

        $this->validate($request, [
            'name_prospective_client' => ['required', 'string', 'max:255'],
            'respont_prospective_client' => ['required', 'string', 'max:255'],
        ]);

        try {

            \DB::beginTransaction();

            $data = new MsLobbyist;
            $data->uuid_lobbyists = Uuid::generate()->string;
            $data->name_prospective_client = $request->name_prospective_client;
            $data->respont_prospective_client = $request->respont_prospective_client;
            $data->relation_from = $request->relation_from;
            

            if ($data->respont_prospective_client == "po") {
                $data->open_by = $get_auth->name;
                $data->close_by = $get_auth->name;
                $data->save();
                // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
                \DB::commit();
                return redirect(route('client-create-wuuid', [$data->uuid_lobbyists]));
                // Data akan langsung di lempar ke Create Data Client
            }elseif ($data->respont_prospective_client == "n_po" || $data->respont_prospective_client == "labil") {
                $data->open_by = $get_auth->name;
                $data->close_by = "NotBeenSet";
                $data->save();
                // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
                \DB::commit();
                alert()->success('Success Created',"Successfully added data to database.");
                return redirect(route('sales-lobbyist-process'));
            }else {
                return abort(404);
            }

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('sales-lobbyist-process'));
        }
    }

    public function sales_lobbyist_update(Request $request, $id)
    {
        $get_auth = Auth::user();

        $this->validate($request, [
            'name_prospective_client' => ['required', 'string', 'max:255'],
            // 'respont_prospective_client' => ['required', 'string', 'max:255'],
        ]);

        try {

            \DB::beginTransaction();

            $data = MsLobbyist::find($id);
            $data->name_prospective_client = $request->get('name_prospective_client');
            if (isset($request->respont_prospective_client)) {
                $data->respont_prospective_client = $request->get('respont_prospective_client');
            }
            $data->relation_from = $request->get('relation_from');


            if ($data->respont_prospective_client == "po") {
                $data->update(['close_by' => $get_auth->name]);
                $data->save();
                // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
                \DB::commit();
                return redirect(route('client-create-wuuid', [$data->uuid_lobbyists]));
            }elseif ($data->respont_prospective_client == "n_po" || $data->respont_prospective_client == "labil") {
                $data->close_by = "NotBeenSet";
                $data->save();
                // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
                \DB::commit();
                alert()->success('Success Edit',"Successfully Updated data to database.");
                return redirect(route('sales-lobbyist-process'));
            }else {
                return abort(404);
            }

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('sales-lobbyist-process'));
        }
    }

    public function select_delete_lobbyist(Request $request)
    {
        $select_delete = $request->get('select_delete');

        if ($select_delete == true) {

            $data_confirm = MsLobbyist::whereIn('id', $select_delete)->get('id');

            if ($data_confirm == true) {
                $delete_now = MsLobbyist::whereIn('id', $data_confirm)->delete();
            } else {
                return "Gagal Menghapus Data :(";
            }

            alert()->info('Success Delete',"Data Berhasil Di Hapus");
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }


    public function sales_daily_report()
    {
        return view('dashboard_view.sales_management.sales_daily_report');
    }

    public function sales_daily_report_create_nemail()
    {
        $get_auth = Auth::user();

        if ($get_auth->role == "admin" || $get_auth->role == "sales") {

            $data_user = User::where('email', '!=', 'setlightcombo@gmail.com')->where('role', 'admin')->orWhere('role', 'sales')->get();
            $data_client = MsClient::all();
            $data_capacity = MsCapacity::with('jnsvendor')->get();
            $data_site= MsSite::all();

            return view('dashboard_view.sales_management.sales_daily_report_create', compact('data_user', 'data_client', 'data_capacity', 'data_site'));
        }else {
            return abort(404);
        }

    }
}
