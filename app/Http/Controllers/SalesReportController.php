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
        $data = MsSalesReport::with('jnsuser', 'jnsclient', 'jnscapacity', 'jnssite')->get();
        return view('dashboard_view.sales_management.sales_daily_report', compact('data'));
    }

    public function sales_daily_report_create_nemail()
    {
        $get_auth = Auth::user();

        if ($get_auth->role == "admin" || $get_auth->role == "sales") {
            $data_client = MsClient::all();
            $data_capacity = MsCapacity::with('jnsvendor')->get();
            $data_site= MsSite::all();
        }else {
            return abort(404);
        }

        $id_daily = MsSalesReport::orderBy('id', 'DESC')->first();
        if ($id_daily == null) {
            // $tiket_autogenerate = "ICT" . "-" . str_pad(1, 6, "0", STR_PAD_LEFT);
            $tiket_autogenerate = "AutoGenerage-Tiket";

        }else {
            $tiket_autogenerate = "INV" . "-" . str_pad($id_daily->id + 1, 6, "0", STR_PAD_LEFT);
        }

        $data_user = User::where('email', '!=', 'setlightcombo@gmail.com')->where('role', 'admin')->orWhere('role', 'sales')->get();

        return view('dashboard_view.sales_management.sales_daily_report_create', compact('data_user', 'data_client', 'data_capacity', 'data_site', 'tiket_autogenerate'));
    }

    public function sales_daily_report_wemail($emailclient)
    {

        $get_auth = Auth::user();

        $data_client_byemail = MsClient::where('email_client', $emailclient)->first();

        if ($get_auth->role == "admin" || $get_auth->role == "sales") {
            $data_client = MsClient::all();
            $data_capacity = MsCapacity::with('jnsvendor')->get();
            $data_site= MsSite::all();
        }else {
            return abort(404);
        }

        $id_daily = MsSalesReport::orderBy('id', 'DESC')->first();
        if ($id_daily == null) {
            // $tiket_autogenerate = "ICT" . "-" . str_pad(1, 6, "0", STR_PAD_LEFT);
            $tiket_autogenerate = "AutoGenerage-Tiket";

        }else {
            $tiket_autogenerate = "INV" . "-" . str_pad($id_daily->id + 1, 6, "0", STR_PAD_LEFT);
        }

        $data_user = User::where('email', '!=', 'setlightcombo@gmail.com')->where('role', 'admin')->orWhere('role', 'sales')->get();

        return view('dashboard_view.sales_management.sales_daily_report_create', compact('data_client_byemail', 'data_user', 'data_client', 'data_capacity', 'data_site', 'tiket_autogenerate'));
        
    }

    // Ajax Autocomplate
    public function getprice_capacitybandwith(Request $request)
    {
        $data = MsCapacity::find($request->id);
        return response()->json($data, 200);
    }
    // Ajax Autocomplate

    public function sales_daily_report_store(Request $request)
    {
        $this->validate($request, [
            'tiket_report' => ['required', 'string', 'max:255'],
            'id_user_rel' => ['required', 'integer', 'min:1'],
            'id_client_rel' => ['required', 'integer', 'min:1'],
            'id_capacity_rel' => ['required', 'integer', 'min:1'],
            'id_site_rel' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        try {

            \DB::beginTransaction();

            $data = new MsSalesReport;
            $data->tiket_report = $request->tiket_report;

            $data->id_user_rel = $request->id_user_rel;
            $data->id_client_rel = $request->id_client_rel;
            $data->id_capacity_rel = $request->id_capacity_rel;
            $data->id_site_rel = $request->id_site_rel;

            $replace_rpfromme = str_replace("Rp. " , "", $request->get('profit_no_ppn'));
            $replace_dotfromme = str_replace("." , "", $replace_rpfromme);
            $data->price_capacity_fromme = $replace_dotfromme;

            $replace_rpvendor = str_replace("Rp. " , "", $request->get('price_capacity_vendor'));
            $replace_dotvendor = str_replace("." , "", $replace_rpvendor);
            $data->price_capacity_vendor = $replace_dotvendor;

            $data->ppn_percentage = $request->ppn_percentage;

            $replace_rpsubtotal = str_replace("Rp. " , "", $request->get('subtotal_plus_ppn'));
            $replace_dotsubtotal = str_replace("." , "", $replace_rpsubtotal);
            $data->subtotal_plus_ppn = $replace_dotsubtotal;

            $data->status = $request->status;
            $data->save();

            // Ini fungsi untuk generate otomatis untuk yang pertama.
            if ($data->tiket_report == "AutoGenerage-Tiket") {
                $tiket_autogenerate_first = "INV" . "-" . str_pad($data->id, 6, "0", STR_PAD_LEFT);
                $data->update(['tiket_report' => $tiket_autogenerate_first]);
            }
            
            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Created',"Ticket Invoice $data->tiket_report has been successfully entered.");
            return redirect(route('sales-daily-report'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('sales-daily-report'));
        }
    }

    public function sales_daily_report_editshow($id)
    {
        $get_auth = Auth::user();

        if ($get_auth->role == "admin" || $get_auth->role == "sales") {
            $data = MsSalesReport::with('jnsuser', 'jnsclient', 'jnscapacity', 'jnssite')->find($id);

            $data_client = MsClient::all();
            $data_capacity = MsCapacity::with('jnsvendor')->get();
            $data_site= MsSite::all();

            $price_origin_capacity = MsCapacity::where('id', $data->id_capacity_rel)->first();
            $profit_noppn = $data->price_capacity_fromme;
            $ppn_percentage = $data->ppn_percentage;
            $profit_subtotal_plusppn = $data->subtotal_plus_ppn;

        }else {
            return abort(404);
        }

        $data_user = User::where('email', '!=', 'setlightcombo@gmail.com')->where('role', 'admin')->orWhere('role', 'sales')->get();
        return view('dashboard_view.sales_management.sales_daily_report_editshow',
        compact(
            'data_user', 'data_client', 'data_capacity', 'data_site', 'data',
            'price_origin_capacity', 'profit_noppn', 'ppn_percentage', 'profit_subtotal_plusppn'
        ));


    }

    public function sales_daily_report_showonly($id)
    {
        $data = MsSalesReport::with('jnsuser', 'jnsclient', 'jnscapacity', 'jnssite')->find($id);

        $data_client = MsClient::all();
        $data_capacity = MsCapacity::with('jnsvendor')->get();
        $data_site= MsSite::all();

        $price_origin_capacity = MsCapacity::where('id', $data->id_capacity_rel)->first();
        $profit_noppn = $data->price_capacity_fromme;
        $ppn_percentage = $data->ppn_percentage;
        $profit_subtotal_plusppn = $data->subtotal_plus_ppn;

        return view('dashboard_view.sales_management.sales_daily_report_showonly',
        compact(
            'data_client', 'data_capacity', 'data_site', 'data',
            'price_origin_capacity', 'profit_noppn', 'ppn_percentage', 'profit_subtotal_plusppn'
        ));

    }

    public function sales_daily_report_update(Request $request, $id)
    {
        $this->validate($request, [
            'tiket_report' => ['required', 'string', 'max:255'],
            'id_user_rel' => ['required', 'integer', 'min:1'],
            'id_client_rel' => ['required', 'integer', 'min:1'],
            'id_capacity_rel' => ['required', 'integer', 'min:1'],
            'id_site_rel' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        try {

            \DB::beginTransaction();

            $data = MsSalesReport::find($id);
            $data->tiket_report = $request->tiket_report;

            $data->id_user_rel = $request->get('id_user_rel');
            $data->id_client_rel = $request->get('id_client_rel');
            $data->id_capacity_rel = $request->get('id_capacity_rel');
            $data->id_site_rel = $request->get('id_site_rel');
            
                
            $replace_rpfromme = str_replace("Rp. " , "", $request->get('profit_no_ppn'));
            $replace_dotfromme = str_replace("." , "", $replace_rpfromme);
            $data->price_capacity_fromme = $replace_dotfromme;
            
            $replace_rpvendor = str_replace("Rp. " , "", $request->get('price_capacity_vendor'));
            $replace_dotvendor = str_replace("." , "", $replace_rpvendor);
            $data->price_capacity_vendor = $replace_dotvendor;
            
            $data->ppn_percentage = $request->get('ppn_percentage');

            $replace_rpsubtotal = str_replace("Rp. " , "", $request->get('subtotal_plus_ppn'));
            $replace_dotsubtotal = str_replace("." , "", $replace_rpsubtotal);
            $data->subtotal_plus_ppn = $replace_dotsubtotal;


            $data->status = $request->get('status');
            $data->save();
            
            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Updated',"Ticket Invoice $data->tiket_report has been successfully entered.");
            return redirect(route('sales-daily-report'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('sales-daily-report'));
        }
    }

    public function select_delete_daily_report_sales(Request $request)
    {
        $select_delete = $request->get('select_delete');

        if ($select_delete == true) {

            $data_confirm = MsSalesReport::whereIn('id', $select_delete)->get('id');

            if ($data_confirm == true) {
                $delete_now = MsSalesReport::whereIn('id', $data_confirm)->delete();
            } else {
                return "Gagal Menghapus Data :(";
            }

            alert()->success('Success Delete',"Data Berhasil Di Hapus");
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }


}


