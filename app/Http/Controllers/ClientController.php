<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsClient;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MsClient::all();
        return view('dashboard_view.elements.client.client', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard_view.elements.client.client_create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_client' => ['required', 'string', 'max:255'],
            'no_telp_client' => ['required', 'string', 'max:255'],
            'email_client' => ['required', 'string', 'max:255', 'email'],
            'address_client' => ['required', 'string', 'max:255'],
        ]);

        try {

            \DB::beginTransaction();

            $data = new MsClient;
            $data->name_client = $request->name_client;
            $data->no_telp_client = $request->no_telp_client;
            $data->email_client = $request->email_client;
            $data->address_client = $request->address_client;
            $data->company_client = $request->company_client;
            $data->save();
            \DB::commit();
            \Session::flash('success_confirm', "Selamat, Anda berhasil menambahkan client baru dengan nama : $data->name_client");
            return redirect(route('client-element.index'));


        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('client-element.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
