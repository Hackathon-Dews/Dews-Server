<?php

namespace App\Http\Controllers;

use App\Models\UserHistory;
use App\Http\Requests\StoreUserHistoryRequest;
use App\Http\Requests\UpdateUserHistoryRequest;

class UserHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserHistory $userHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserHistory $userHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserHistoryRequest $request, UserHistory $userHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserHistory $userHistory)
    {
        //
    }
}
