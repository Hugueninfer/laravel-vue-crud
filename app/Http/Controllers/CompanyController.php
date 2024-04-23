<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Company\{StoreRequest, UpdateRequest};
use App\Models\Company;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewCompanyNotification;
use Illuminate\Support\Facades\Notification;

class CompanyController extends Controller
{

    public function index()
    {
        $companies = Company::orderBy('created_at', 'desc')->paginate(30);
        return Inertia::render('Companies/Index', compact('companies'));
    }

    public function create()
    {
        return Inertia::render('Companies/Create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Company::create($data);
        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        return Inertia::render('Companies/Show', compact('company'));
    }

    public function edit(Company $company)
    {
        return Inertia::render('Companies/Edit', compact('company'));
    }

    public function update(UpdateRequest $request, Company $company)
    {
        $data = $request->validated();

        $company->update($data);
        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
