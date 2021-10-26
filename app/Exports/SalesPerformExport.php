<?php

namespace App\Exports;

use App\Models\MsSalesReport;
use App\User;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesPerformExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $id_user_rel;
    protected $id_client_rel;
    protected $status;
    protected $data_dari_long;
    protected $data_sampai_long;


    function __construct($id_user_rel, $id_client_rel, $status, $data_dari_long, $data_sampai_long) {
        $this->id_user_rel = $id_user_rel;
        $this->id_client_rel = $id_client_rel;
        $this->status = $status;
        $this->data_dari_long = $data_dari_long;
        $this->data_sampai_long = $data_sampai_long;
    }

    public function view(): View
    {   

        // $this->validate($request, [
        //     'id_user_rel' => ['required', 'integer', 'min:1'],
        //     'id_client_rel' => ['required'],
        //     'status' => ['required', 'string', 'max:255'],

        // ]);

        // Data Pendukung (whereBetween)
        // Untuk data $data_dari_long & $data_sampai_long sudah di konversi ke format database pada controller jadi di sini tidak usah konversi kembali
        
        if ($this->status != null) {
            if ($this->data_dari_long == "1970-01-01 07:00" || $this->data_sampai_long == "1970-01-01 07:00") {
                alert()->error('Oops..','Pastikan Data "From Time" & "After Time" Sudah Terisi.');
                return redirect()->back();
    
            }else {
                if ($this->id_client_rel != "34e4e14c9085f747c60aeb339fde1f84" ) {
                    $data_history = MsSalesReport::whereBetween('created_at',[$this->data_dari_long, $this->data_sampai_long])
                        ->where('id_user_rel',$this->id_user_rel)
                        ->where('id_client_rel',$this->id_client_rel)
                        ->where('status',$this->status)
                        ->with('jnsuser', 'jnsclient', 'jnscapacity', 'jnssite')
                        ->get();
                }elseif ($this->id_client_rel == "34e4e14c9085f747c60aeb339fde1f84" ) {
                    $data_history = MsSalesReport::whereBetween('created_at',[$this->data_dari_long, $this->data_sampai_long])
                        ->where('id_user_rel',$this->id_user_rel)
                        ->where('status',$this->status)
                        ->with('jnsuser', 'jnsclient', 'jnscapacity', 'jnssite')
                        ->get();
                }else {
                    return abort(404);   
                }
            }
        }elseif ($this->status == null) {
            if ($this->id_client_rel != "34e4e14c9085f747c60aeb339fde1f84" ) {
                $data_history = MsSalesReport::where('id_user_rel',$this->id_user_rel)
                    ->where('id_client_rel',$this->id_client_rel)
                    ->with('jnsuser', 'jnsclient', 'jnscapacity', 'jnssite')
                    ->get();
            }elseif ($this->id_client_rel == "34e4e14c9085f747c60aeb339fde1f84" ) {
                $data_history = MsSalesReport::where('id_user_rel',$this->id_user_rel)
                    ->with('jnsuser', 'jnsclient', 'jnscapacity', 'jnssite')
                    ->get();
            }else {
                return abort(404);   
            }
        }

        
        $getname = User::where('id', $this->id_user_rel)->first();
        $data_dari_long = $this->data_dari_long;
        $data_sampai_long = $this->data_sampai_long;  
        
        return view('folder_excel.excelex_perform_sales_history', compact('data_history', 'getname', 'data_dari_long', 'data_sampai_long'));


    }


}
