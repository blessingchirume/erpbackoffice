<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::paginate(20);

        // return response($clients);

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request, Client $client)
    {
        $client->create($request->all());

        return redirect()->route('clients.index')->withStatus('Successfully registered customer.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\ClientRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->all());

        return redirect()
            ->route('clients.index')
            ->withStatus('Successfully modified customer.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->withStatus('Customer successfully removed.');
    }

    public function addtransaction($id)
    {
        $client = Client::find($id);
        $payment_methods = PaymentMethod::all();

        return view('clients.transactions.add', compact('client', 'payment_methods'));
    }
}
