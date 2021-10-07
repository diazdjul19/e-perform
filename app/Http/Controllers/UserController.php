<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function user_registration_index()
    {
        // Start  Alur For Create SuperUser DiazDjuliansyah
            // php artisan tinker
            // \App\User::create(['name' => 'SuperAdmin', 'email' => 'setlightcombo@gmail.com', 'password' => bcrypt('diazdjuldiaz'), 'role' => 'admin', 'status' => 'A',]);
        // End Alur For Create SuperUser DiazDjuliansyah 
        

        $data = User::where('status', 'P')->where('email', '!=', 'setlightcombo@gmail.com')->get();
        return view('dashboard_view.user_management.user', compact('data'));
    }

    public function user_approved_index()
    {
        $data = User::where('status', 'A')->where('email', '!=', 'setlightcombo@gmail.com')->get();
        return view('dashboard_view.user_management.user', compact('data'));
    }

    public function user_rejected_index()
    {
        $data = User::where('status', 'NA')->where('email', '!=', 'setlightcombo@gmail.com')->get();
        return view('dashboard_view.user_management.user', compact('data'));
    }

    public function user_store(Request $request)
    {
        // Membuat Validasi Dulu
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'max:255'],

        ]);

        try {

            \DB::beginTransaction();

            // Membuat Data User
            $data = new User();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->no_telp = $request->no_telp;
            $data->role = $request->role;
            $data->foto_user = $request->foto_user;
            $data->foto_ktp = $request->foto_ktp;
            $data->status = "P";

            if (isset($request->foto_user)) {
                $imageFile = $request->name . '/' . \Str::random(60) . '.' . $request->foto_user->getClientOriginalExtension();
                $image_path = $request->file('foto_user')->move(storage_path('app/public/user/' . $request->name), $imageFile);

                $data->foto_user = $imageFile;
            }

            if (isset($request->foto_ktp)) {
                $imageFile = $request->name . '/' . \Str::random(60) . '.' . $request->foto_ktp->getClientOriginalExtension();
                $image_path = $request->file('foto_ktp')->move(storage_path('app/public/foto_ktp/' . $request->name), $imageFile);

                $data->foto_ktp = $imageFile;
            }
            $data->save();

            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Created',"Successfully Created Data : $data->name");
            return redirect()->back();

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function user_edit($id)
    {
        $getauth = Auth::user();
        $data = User::find($id);

        if ($getauth->role == "admin") {
            if ($getauth->email == "setlightcombo@gmail.com" and $data->role == "admin") {
                return view('dashboard_view.user_management.user_edit', compact('data'));
            }elseif ($getauth->id == $id and $data->role == "admin") {
                return view('dashboard_view.user_management.user_edit', compact('data'));
            }elseif ($getauth->id != $id and $data->role == "admin") {
                abort(403, "Sorry, you don't have access to this page.");
            }elseif ($getauth->id != $id and $data->role != "admin") {
                return view('dashboard_view.user_management.user_edit', compact('data'));
            }else {
                return abort(404);
            }
        }elseif ($getauth->role != "admin") {
            if ($getauth->id == $id) {
                return view('dashboard_view.user_management.user_edit', compact('data'));
            }elseif ($getauth->id != $id) {
                abort(403, "Sorry, you don't have access to this page.");
            }else {
                return abort(404);
            }
        }

    }

    public function user_update(Request $request, $id)
    {
        try {
            
            \DB::beginTransaction();

            $data = User::find($id);
            $data->name = $request->get('name');
            $data->email = $request->get('email');
            $data->no_telp = $request->get('no_telp');

            if (isset($request->level)) {
                $data->role = $request->get('role');
            }

            if (isset($request->status)) {
                $data->status = $request->get('status');
            }

            if (isset($request->foto_user)) {
                $imageFile = $request->name . '/' . \Str::random(60) . '.' . $request->foto_user->getClientOriginalExtension();
                $image_path = $request->file('foto_user')->move(storage_path('app/public/user/' . $request->name), $imageFile);

                $data->foto_user = $imageFile;
            }

            if (isset($request->foto_ktp)) {
                $imageFile = $request->name . '/' . \Str::random(60) . '.' . $request->foto_ktp->getClientOriginalExtension();
                $image_path = $request->file('foto_ktp')->move(storage_path('app/public/foto_ktp/' . $request->name), $imageFile);

                $data->foto_ktp = $imageFile;
            }
            $data->save();

            \DB::commit();
            \Session::flash('success_edit_profil', "Selamat, Anda telah berhasil mengedit data user dengan nama '$data->name' ");
            // return redirect(route('user-update', [$data->id]));
            return redirect()->back();

            
        } catch (\Exception $e) {
            // \DB::rollback() yang akan mengembalikan data atau dihapus jika ada salah satu proses diatas ada yg
            // error ataupun salah. Biasakan pakai Ini juga 
            \DB::rollback();
            \Session::flash('error_edit_profil', $e->getMessage());
            return redirect(route('user-update', [$data->id]));

        }

    }

    public function user_update_password(Request $request, $id)
    {
        $data_findid = User::find($id);

        $data = User::where('email', $data_findid->email)->first();

        // Check Old Password
        if (\Hash::check($request->old_password, $data->password)) {

            // Check Confirm Password
            if ($request->password != $request->password_confirmation) {
                \Session::flash('pass_copass_tidak_sama', 'Password Dan Confirm Password Tidak Sama !');
                return redirect()->back();
            }
            elseif ($request->password == false) {
                \Session::flash('non_new_pass', 'Password Baru Belum Di Isi !');
                return redirect()->back();
            }

            // Make Hash Password
            if (isset($request->password)) {
                $data->password = \Hash::make($request->password);

                // Update Password Siswa
                $data_akhir = $data->password;
                $data->update(['password' => $data_akhir]);


                \Session::flash('success_edit_password', 'Sukses Update Password');
                return redirect()->back();
            }

        }else {
            \Session::flash('error_old_password', 'Password Lama Tidak Sesuai !');
            return redirect()->back();
        }
    }

    public function user_approve_print()
    {
        $data = User::where('status', 'A')->where('email', '!=', 'setlightcombo@gmail.com')->get();
        return view('dashboard_view.user_management.user_print_approve', compact('data'));
    }

    public function user_active($id)
    {
        $data = User::find($id);
        $data->update(['status' => 'A']);
        return redirect()->back();
        
        
        
    }

    public function user_not_active($id)
    {
        $data = User::find($id);
        $data->update(['status' => 'NA']);
        return redirect()->back();
        
        
        
    }

    public function select_delete_user(Request $request)
    {
        $select_delete = $request->get('select_delete');

        if ($select_delete == true) {

            $data_confirm = User::whereIn('id', $select_delete)->get('id');

            if ($data_confirm == true) {
                $delete_now = User::whereIn('id', $data_confirm)->delete();
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
