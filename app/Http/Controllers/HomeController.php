<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsMngr;

use App\User;
use App\Models\MsClient;
use App\Models\MsSalesReport;
use App\Models\MsNocReport;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data_mngr = MsMngr::where('id', 1)->where('md5', 'ad6d404a695da4eb8ba3ef9ffcd7b8aa')->first();

        $data_user = count(User::where('status', 'A')->where('email', '!=', 'setlightcombo@gmail.com')->get());
        $data_client = count(MsClient::all());
        $data_sales_report = count(MsSalesReport::all());
        $data_noc_report = count(MsNocReport::all());

        // return view('home');
        return view('dashboard_view.home', compact('data_mngr', 'data_user', 'data_client', 'data_sales_report', 'data_noc_report'));
    }

    public function mngr_store(Request $request)
    {
        $this->validate($request, [
            'mngr_login' => ['required', 'string', 'max:255'],
            'mngr_register' => ['required', 'string', 'max:255'],
            'mngr_fgpassword' => ['required', 'string', 'max:255'],

        ]);

        try {

            \DB::beginTransaction();

            $data = new MsMngr;
            $data->mngr_login = $request->mngr_login;
            $data->mngr_register = $request->mngr_register;
            $data->mngr_fgpassword = $request->mngr_fgpassword;
            $data->md5 = "ad6d404a695da4eb8ba3ef9ffcd7b8aa";
            $data->save();

            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Created',"Successfully Created Data");
            return redirect(route('home'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('home'));
        }
    }

    public function mngr_update(Request $request, $id)
    {
        $this->validate($request, [
            'mngr_login' => ['required', 'string', 'max:255'],
            'mngr_register' => ['required', 'string', 'max:255'],
            'mngr_fgpassword' => ['required', 'string', 'max:255'],

        ]);

        try {
            
            \DB::beginTransaction();

            $data = MsMngr::find($id);
            $data->mngr_login = $request->get('mngr_login');
            $data->mngr_register = $request->get('mngr_register');
            $data->mngr_fgpassword = $request->get('mngr_fgpassword');
            $data->save();

            \DB::commit();
            alert()->success('Success Updated',"Successfully Updated Data");
            return redirect(route('home'));

            
        } catch (\Exception $e) {
            // \DB::rollback() yang akan mengembalikan data atau dihapus jika ada salah satu proses diatas ada yg
            // error ataupun salah. Biasakan pakai Ini juga 
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('home'));

        }
    }
}
