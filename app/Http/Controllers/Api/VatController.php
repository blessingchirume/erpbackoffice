<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VatGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class VatController extends Controller
{
    public function index(){
        $taxes = VatGroup::all();
        return response()->json($taxes, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'rate' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            VatGroup::create($request->all());
            return response()->json('Tax record has been created!', 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
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
