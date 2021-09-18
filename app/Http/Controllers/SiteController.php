<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsSite;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MsSite::all();
        return view('dashboard_view.elements.site', compact('data'));
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
            'name_site' => ['required', 'string', 'max:255'],
        ]);

        try {

            \DB::beginTransaction();

            $data = new MsSite;
            $data->name_site = $request->name_site;
            $data->location_site = $request->location_site;
            $data->save();
            // \DB::commit() ini akan menginput data jika dari proses diatas tidak ada yg salah atau error.
            \DB::commit();
            alert()->success('Success Created',"Successfully Created Data : $data->name_site");
            return redirect(route('site-element.index'));

        } catch (\Exception $e) {
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('site-element.index'));
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
            'name_site' => ['required', 'string', 'max:255'],
        ]);

        try {
            
            \DB::beginTransaction();

            $data = MsSite::find($id);
            $data->name_site = $request->get('name_site');
            $data->location_site = $request->get('location_site');
            
            
            $data->save();

            \DB::commit();
            alert()->success('Success Updated',"Successfully Updated Data : $data->name_site");
            return redirect(route('site-element.index'));
            
        } catch (\Exception $e) {
            // \DB::rollback() yang akan mengembalikan data atau dihapus jika ada salah satu proses diatas ada yg
            // error ataupun salah. Biasakan pakai Ini juga 
            \DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect(route('site-element.index'));
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
        $data_redirect = MsSite::find($id);
        $data = MsSite::find($id)->delete();

        return redirect(route('site-element.index'));
    }
}
