<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsVendor;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MsVendor::all();
        return view('dashboard_view.elements.vendor', compact('data'));
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
            'name_vendor' => ['required', 'string', 'max:255'],
        ]);

        try {

            \DB::beginTransaction();

            $data = new MsVendor;
            $data->name_vendor = $request->name_vendor;
            $data->vendor_pt = $request->vendor_pt;
            $data->save();
            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Created',"Successfully Created Data : $data->name_vendor");
            return redirect(route('vendor-element.index'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('vendor-element.index'));
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
            'name_vendor' => ['required', 'string', 'max:255'],
        ]);

        try {
            
            \DB::beginTransaction();

            $data = MsVendor::find($id);
            $data->name_vendor = $request->get('name_vendor');
            $data->vendor_pt = $request->get('vendor_pt');
            
            
            $data->save();

            \DB::commit();
            alert()->success('Success Updated',"Successfully Updated Data : $data->name_vendor");
            return redirect(route('vendor-element.index'));
            
        } catch (\Exception $e) {
            // \DB::rollback() yang akan mengembalikan data atau dihapus jika ada salah satu proses diatas ada yg
            // error ataupun salah. Biasakan pakai Ini juga 
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('vendor-element.index'));
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
        $data_redirect = MsVendor::find($id);
        $data = MsVendor::find($id)->delete();

        return redirect(route('vendor-element.index'));
    }
}
