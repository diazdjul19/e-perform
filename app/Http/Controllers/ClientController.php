<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsClient;
use App\Models\MsLobbyist;

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

    public function client_create_wuuid($uuid)
    {
        $data = MsLobbyist::where('uuid_lobbyists', $uuid)->first();
        return view('dashboard_view.elements.client.client_create', compact('data'));
        
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
            'email_client' => ['required', 'string', 'email', 'max:255', 'unique:ms_clients'],
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

            if (empty($request->uuid_lobbyists)) {
                alert()->success('Success Created',"Successfully added data client to database.");
                
            }else {
                \Session::flash('session_data', "$data->email_client");
                \Session::flash('success_confirm', "Selamat, Anda berhasil menambahkan client baru dengan nama : $data->name_client");
            }
            
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
        $this->validate($request, [
            'name_client' => ['required', 'string', 'max:255'],
            'no_telp_client' => ['required', 'string', 'max:255'],
            // 'email_client' => ['required', 'string', 'email', 'max:255', 'unique:ms_clients'],
            'address_client' => ['required', 'string', 'max:255'],
        ]);

        try {

            \DB::beginTransaction();

            $data = MsClient::find($id);
            $data->name_client = $request->get('name_client');
            $data->no_telp_client = $request->get('no_telp_client');
            $data->email_client = $request->get('email_client');
            $data->address_client = $request->get('address_client');
            $data->company_client = $request->get('company_client');
            $data->save();
            \DB::commit();

            alert()->success('Success Updated',"Successfully Updated data to database.");            
            return redirect(route('client-element.index'));


        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('client-element.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data_redirect = MsClient::find($id);
        $data = MsClient::find($id)->delete();

        return redirect(route('client-element.index'));
    }
}
