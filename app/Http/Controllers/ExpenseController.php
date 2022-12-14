<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpenseCollection;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Notifications\ExpenseCreated;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $expenses = new ExpenseCollection(Expense::where('user_id', Auth::user()->id)->paginate(10));
        return Inertia::render('Expenses/index',[
            'expenses' => $expenses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Expenses/create', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ExpenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $request->merge([
            'date' => Carbon::parse($request->date)
                ? Carbon::createFromDate($request->date)
                : Carbon::createFromFormat('d/m/Y H:m:s', $request->date)
        ]);
        $expense = new ExpenseResource(Expense::create($request->all()));
        $expense->user()->first()->notify(new ExpenseCreated($expense));
        
        return redirect()->route('expense.index')
            ->with('message', 'expense created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit(Request $request, Expense $expense)
    {
        if ($request->user()->cannot('edit', $expense))
            abort(Response::HTTP_FORBIDDEN, 'unauthorized');
        
        $expense = new ExpenseResource(Expense::where('id', $expense->id)->first());

        return Inertia::render('Expenses/edit',[
            'expense' => $expense
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ExpenseRequest  $request
     * @param  int  $id
     * @return \App\Http\Resources\ExpenseResource
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        if ($request->user()->cannot('update', $expense))
            abort(Response::HTTP_FORBIDDEN, 'unauthorized');

        $request->merge(['date' => Carbon::parse($request->date) ? Carbon::createFromDate($request->date) : Carbon::createFromFormat('d/m/Y H:m:s', $request->date)]);

        $expense->update($request->all());
        return redirect()->route('expense.index')
            ->with('message', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Expense $expense)
    {
        if ($request->user()->cannot('delete', $expense))
            abort(Response::HTTP_FORBIDDEN, 'unauthorized');

        $expense->delete();

        return redirect()->route('expense.index')
            ->with('message', 'Deleted');
    }
}
