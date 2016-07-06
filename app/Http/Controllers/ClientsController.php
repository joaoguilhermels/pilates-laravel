<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Client;
use App\Schedule;
use App\ClientPlan;
use App\BankAccount;
use App\PaymentMethod;
use App\FinancialTransaction;
use App\Http\Requests;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\FinancialTransactionRequest;
use App\Http\Controllers\Controller;

class ClientsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $total = Client::count();
        $clients = Client::paginate(10);
        $name = "";
        $phone = "";
        $email = "";

        return view('clients.index', compact('total', 'clients', 'name', 'phone', 'email'));
    }

    public function search(Request $request)
    {
        $total = Client::count();
        $clients = Client::filter($request->all())->paginate(10);
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;

        return view('clients.index', compact('total', 'clients', 'name', 'phone', 'email'));
    }

    public function show(Client $client)
    {
        $client->load('clientPlans', 'clientPlans.clientPlanDetails', 'clientPlans.classType', 'clientPlans.financialTransactions');

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function reportCharge(Client $client) {
        $rows = Schedule::with('professional', 'room')
          ->where('client_id', $client->id)
          ->orderBy('start_at', 'asc')
          ->get()
          ->groupBy(function ($item, $key) {
            return date_create($item->start_at)->format("F Y");
        });


        //$rows = Schedule::with('professional', 'room')->where('client_id', $client->id)
                        //->get();
                        //->whereMonth('start_at', '=', 3)
                        //->whereYear('start_at', '=', 2016)

        $total = Schedule::where('client_id', $client->id)
                          ->sum('price');
                          //->whereMonth('start_at', '=', 3)
                          //->whereYear('start_at', '=', 2016)

        //{{ $row->price * ($professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value / 100) }}

        //$rows = ClientPlan::where('client_id', $client->id)->get();

        return view('clients.report_charge', compact('client', 'rows', 'total'));
    }

    public function create(Client $client)
    {
        return view('clients.create', compact('client'));
    }

    public function store(ClientRequest $request)
    {
        $client = Client::create($request->all());

        Session::flash('message', 'Successfully created client ' . $client->name);

        return redirect('clients');
    }

    public function update(Client $client, ClientRequest $request)
    {
        $client->update($request->all());

        Session::flash('message', 'Successfully updated client ' . $client->name);

        return redirect('clients');
    }

    public function destroy(Client $client)
    {
        Session::flash('message', 'Successfully deleted client ' . $client->name);

        $client->delete();

        return redirect('clients');
    }

    /////////////////////////////////////////////////////////////////////////////////
    public function indexCharges()
    {
        $charges = FinancialTransaction::where('financiable_type', 'App\ClientPlan')->paginate(10);

        return view('clients.charges.index', compact('charges'));
    }

    public function createCharge()
    {
        $paymentMethods = PaymentMethod::all();
        $bankAccounts = BankAccount::all();

        return view('clients.charges.create', compact('paymentMethods', 'bankAccounts'));
    }

    public function storeCharge(FinancialTransaction $charge, FinancialTransactionRequest $request)
    {
        $request->request->add([
            financiable_type => 'App\ClientPlan'
        ]);
        $client = FinancialTransaction::create($request->all());

        Session::flash('message', 'Successfully created client ' . $client->name);

        return redirect('clients/charges');
    }

    public function showCharge(FinancialTransaction $charge)
    {
        return view('clients.charges.show', compact('charge'));
    }

    public function editCharge(FinancialTransaction $charge)
    {
        $bankAccounts = BankAccount::all();
        $paymentMethods = PaymentMethod::all();

        return view('clients.charges.edit', compact('charge', 'bankAccounts', 'paymentMethods'));
    }

    public function updateCharge(FinancialTransaction $charge, FinancialTransactionRequest $request)
    {
        $charge->update($request->all());

        Session::flash('message', 'Successfully updated charge ' . $charge->name);

        return redirect('clients/charges');
    }

    public function destroyCharge(FinancialTransaction $charge)
    {
        Session::flash('message', 'Successfully deleted charge ' . $charge->name);

        $charge->delete();

        return redirect('clients/charges');
    }
}
