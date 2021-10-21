<?php

namespace App\Exports;

use App\Models\MsNocReport;
use App\User;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NocPerformExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $id_user_rel;
    protected $id_link_rel;
    protected $status;
    protected $data_dari_long;
    protected $data_sampai_long;

    function __construct($id_user_rel, $id_link_rel, $status, $data_dari_long, $data_sampai_long) {
        $this->id_user_rel = $id_user_rel;
        $this->id_link_rel = $id_link_rel;
        $this->status = $status;
        $this->data_dari_long = $data_dari_long;
        $this->data_sampai_long = $data_sampai_long;
    }

    public function view(): View
    {   

        // $this->validate($request, [
        //     'id_user_rel' => ['required', 'integer', 'min:1'],
        //     'id_link_rel' => ['required', 'numeric'],
        //     'status' => ['required', 'string', 'max:255'],

        // ]);

        // Data Pendukung (whereBetween)
        // Untuk data $data_dari_long & $data_sampai_long sudah di konversi ke format database pada controller jadi di sini tidak usah konversi kembali

        if ($this->status == "solved") {

            if ($this->data_dari_long == "1970-01-01 07:00" || $this->data_sampai_long == "1970-01-01 07:00") {
                alert()->error('ErrorAlert','Pastikan field (From Time / After Time) sudah terisi !!!');
                return redirect(route('perform-noc-history'));  
            }else {
                if ($this->id_link_rel != "259b0d4e5350466fad1320653c37f80e" ) {
                    $data_history = MsNocReport::whereBetween('created_at',[$this->data_dari_long, $this->data_sampai_long])
                        ->where('id_user_rel',$this->id_user_rel)
                        ->where('id_link_rel',$this->id_link_rel)
                        ->where('status',$this->status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }elseif ($this->id_link_rel == "259b0d4e5350466fad1320653c37f80e" ) {
                    $data_history = MsNocReport::whereBetween('created_at',[$this->data_dari_long, $this->data_sampai_long])
                        ->where('id_user_rel',$this->id_user_rel)
                        ->where('status',$this->status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }else {
                    return abort(404);   
                }
            }        
            
        } elseif ($this->status == "ocn" || $this->status == "n_solved") {
            if ($this->data_dari_long == "1970-01-01 07:00" || $this->data_sampai_long == "1970-01-01 07:00") {
                if ($this->id_link_rel != "259b0d4e5350466fad1320653c37f80e" ) {
                    $data_history = MsNocReport::where('id_user_rel',$this->id_user_rel)
                        ->where('id_link_rel',$this->id_link_rel)
                        ->where('status',$this->status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }elseif ($this->id_link_rel == "259b0d4e5350466fad1320653c37f80e" ) {
                    $data_history = MsNocReport::where('id_user_rel',$this->id_user_rel)
                        ->where('status',$this->status)
                        ->with('jnsuser', 'jnslink')
                        ->get();
                }else {
                    return abort(404);   
                }
            }

        } else{
            return abort(404); 
        }

        $getname = User::where('id', $this->id_user_rel)->first(); 
        $data_dari_long = $this->data_dari_long;
        $data_sampai_long = $this->data_sampai_long;  
        
        return view('folder_excel.excelex_perform_noc_history', compact('data_history', 'getname', 'data_dari_long', 'data_sampai_long'));


    }

}
