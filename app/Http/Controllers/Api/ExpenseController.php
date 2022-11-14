<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use App\Http\Resources\ExpenseCollection;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\ExpenseCollection
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('index'))
            abort(Response::HTTP_FORBIDDEN, 'unauthorized');
        return new ExpenseCollection(Expense::where('user_id', Auth::user()->id)->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ExpenseRequest  $request
     * @return \App\Http\Resources\ExpenseResource
     */
    public function store(ExpenseRequest $request)
    {
        $expenses = Expense::create($request->all());
        return new ExpenseResource($expenses);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \App\Http\Resources\ExpenseResource
     */
    public function show(Expense $expense, Request $request)
    {
        if ($request->user()->cannot('view', $expense))
            abort(Response::HTTP_FORBIDDEN, 'unauthorized');
        return new ExpenseResource($expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ExpenseRequest  $request
     * @param  \App\Models\Expense  $expense
     * @return \App\Http\Resources\ExpenseResource
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        if ($request->user()->cannot('update', $expense))
            abort(Response::HTTP_FORBIDDEN, 'unauthorized');
        $expense->update($request->all());
        return new ExpenseResource($expense);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Expense $expense)
    {
        // return response($request);
        if ($request->user()->cannot('delete', $expense))
            abort(Response::HTTP_FORBIDDEN, 'unauthorized');
        return response($expense->delete());
    }
}
