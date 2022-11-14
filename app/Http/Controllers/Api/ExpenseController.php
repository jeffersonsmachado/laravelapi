<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use App\Http\Resources\ExpenseCollection;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\ExpenseCollection
     */
    public function index()
    {
        return new ExpenseCollection(Expense::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        // $request->validated();
        return response($request->toArray());
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
            abort(403);
        return new ExpenseResource($expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
