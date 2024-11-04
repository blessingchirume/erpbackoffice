<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\VatGroup;
use Illuminate\Http\Request;

class VatGroupController extends Controller
{
    public function index(){
        $taxes = VatGroup::paginate(20);
        return view('taxes.index', compact('taxes'));
    }
    public function show($id){

        return view('taxes.edit', ['tax' => VatGroup::find($id)]);
    }
    public function create(){
        return view('taxes.create');
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'rate' => 'required'
        ]);

        VatGroup::create($request->all());

        return redirect()->route('vat-groups.index')->withStatus('Vat Group added successfully');

    }

    public function edit($id){
        return view('taxes.edit', ['tax' => VatGroup::find($id)]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'rate' => 'required'
        ]);

        VatGroup::find($id)->update($request->all());

        return redirect()->route('vat-groups.index')->withStatus('Vat Group updated successfully');

    }

    public function destroy($id){
        VatGroup::find($id)->delete();
        return redirect()->route('vat-groups.index')->withStatus('Vat Group deleted successfully');

    }
}
