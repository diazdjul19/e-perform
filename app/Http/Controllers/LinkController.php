<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsLink;
use App\Models\MsCapacity;
use App\Models\MsSite;
use App\Models\MsVendor;
use App\Models\MsClient;



class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MsLink::with('jnscapacity','jnsclient', 'jnssite', 'jnsvendor')->get();
        $data_capacity = MsCapacity::all();
        $data_client = MsClient::all();
        $data_site = MsSite::all();
        $data_vendor = MsVendor::all();
        

        return view('dashboard_view.elements.link', compact('data', 'data_capacity', 'data_client',  'data_site', 'data_vendor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name_link' => ['required', 'string', 'max:255'],
            'id_client_rel' => ['required', 'integer'],

        ]);

        try {

            \DB::beginTransaction();

            $data = new MsLink;
            $data->name_link = $request->name_link;
            $data->id_client_rel = $request->id_client_rel;
            $data->vlan = $request->vlan;
            $data->id_capacity_rel = $request->id_capacity_rel;
            $data->id_site_rel = $request->id_site_rel;
            $data->id_vendor_rel = $request->id_vendor_rel;


            $data->save();
            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Created',"Successfully Created Link");
            return redirect(route('link-element.index'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('link-element.index'));
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
            'name_link' => ['required', 'string', 'max:255'],
            'id_client_rel' => ['required', 'integer'],
            
        ]);

        try {
            
            \DB::beginTransaction();

            $data = MsLink::find($id);
            $data->name_link = $request->get('name_link');
            $data->id_client_rel = $request->get('id_client_rel');
            $data->vlan = $request->get('vlan');

            if (isset($request->id_capacity_rel)) {
                $data->id_capacity_rel = $request->get('id_capacity_rel');
            }

            if (isset($request->id_site_rel)) {
                $data->id_site_rel = $request->get('id_site_rel');
            }

            if (isset($request->id_vendor_rel)) {
                $data->id_vendor_rel = $request->get('id_vendor_rel');
            }
        
            $data->save();

            \DB::commit();
            alert()->success('Success Updated',"Successfully Updated Link");
            return redirect(route('link-element.index'));
            
        } catch (\Exception $e) {
            // \DB::rollback() yang akan mengembalikan data atau dihapus jika ada salah satu proses diatas ada yg
            // error ataupun salah. Biasakan pakai Ini juga 
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('link-element.index'));
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
        $data_redirect = MsLink::find($id);
        $data = MsLink::find($id)->delete();

        return redirect(route('link-element.index'));
    }
}
