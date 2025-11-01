<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Customer feature was removed; keep stubbed controller to avoid class-not-found errors.
    public function index()
    {
        return redirect()->route('home');
    }

    public function create()
    {
        return redirect()->route('home');
    }

    public function store(Request $request)
    {
        return redirect()->route('home');
    }

    public function show()
    {
        abort(404);
    }

    public function edit()
    {
        return redirect()->route('home');
    }

    public function update(Request $request)
    {
        return redirect()->route('home');
    }

    public function destroy()
    {
        abort(404);
    }
}
