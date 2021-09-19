<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCapacity;
use App\Models\MsVendor;


class CapacityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MsCapacity::with('jnsvendor')->get();
        $data_vendor = MsVendor::all();

        return view('dashboard_view.elements.capacity', compact('data', 'data_vendor'));
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
            'bandwith_capacity' => ['required', 'string', 'max:255'],
            'type_trasfer' => ['required', 'string', 'max:255'],
            'price_capacity_fromme' => ['required', 'string', 'max:255'],

        ]);

        try {

            \DB::beginTransaction();

            $data = new MsCapacity;
            $data->bandwith_capacity = $request->bandwith_capacity;
            $data->type_trasfer = $request->type_trasfer;

            $replace_rpfromme = str_replace("Rp. ", "", $request->price_capacity_fromme);
            $replace_dotfromme = str_replace(".", "", $replace_rpfromme);
            $data->price_capacity_fromme = $replace_dotfromme;

            $replace_rpvendor = str_replace("Rp. ", "", $request->price_capacity_vendor);
            $replace_dotvendor = str_replace(".", "", $replace_rpvendor);
            $data->price_capacity_vendor = $replace_dotvendor;

            $data->id_vendor_rel = $request->id_vendor_rel;
            // dd($data);
            $data->save();
            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Created',"Successfully Created Bandwith : $data->bandwith_capacity $data->type_trasfer");
            return redirect(route('capacity-element.index'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('capacity-element.index'));
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
            // 'bandwith_capacity' => ['required', 'string', 'max:255'],
            // 'type_trasfer' => ['required', 'string', 'max:255'],
            // 'price_capacity_fromme' => ['required', 'string', 'max:255'],

        ]);

        try {

            \DB::beginTransaction();

            $data = MsCapacity::find($id);
            if (isset($request->bandwith_capacity)) {
                $data->bandwith_capacity = $request->get('bandwith_capacity');
            }

            if (isset($request->type_trasfer)) {
                $data->type_trasfer = $request->get('type_trasfer');
            }

            if (isset($request->price_capacity_fromme)) {
                $replace_rpfromme = str_replace("Rp. ", "", $request->get('price_capacity_fromme'));
                $replace_dotfromme = str_replace(".", "", $replace_rpfromme);
                $data->price_capacity_fromme = $replace_dotfromme;
            }

            if (isset($request->price_capacity_vendor)) {
                $replace_rpvendor = str_replace("Rp. ", "", $request->get('price_capacity_vendor'));
                $replace_dotvendor = str_replace(".", "", $replace_rpvendor);
                $data->price_capacity_vendor = $replace_dotvendor;
            }

            if (isset($request->id_vendor_rel)) {
                $data->id_vendor_rel = $request->get('id_vendor_rel');
            }

            
            // dd($data);
            $data->save();
            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Created',"Successfully Update Capacity Bandwith");
            return redirect(route('capacity-element.index'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('capacity-element.index'));
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
        $data_redirect = MsCapacity::find($id);
        $data = MsCapacity::find($id)->delete();

        return redirect(route('capacity-element.index'));
    }
}
