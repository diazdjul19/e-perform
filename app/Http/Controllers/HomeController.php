<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsMngr;

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
        // return view('home');
        return view('dashboard_view.home', compact('data_mngr'));
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
            alert()->success('Success Created',"Successfully Created Data");
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
