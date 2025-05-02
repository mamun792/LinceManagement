<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LicenseRequest;
use App\Services\LicenseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LicensesController extends Controller
{

    protected $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }


    public function index()
    {
        $licenses = $this->licenseService->getAllLicenses();
        return view('admin.license.index', compact('licenses'));
    }

    public function create()
    {
        return view('admin.license.create');
    }

    public function store(LicenseRequest  $request)
    {
        //  Log::info('License creation request', ['request' => $request->all()]);
        $license = $this->licenseService->store($request->validated());
        // Log::info('License created', ['license' => $license]);

        return redirect()
            ->route('admin.licenses.index')
            ->with('success', 'License created successfully!');
    }

    public function show($id)
    {
        return view('admin.license.show', compact('id'));
    }

    public function edit($id)
    {
        return view('licenses.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update the license
        return redirect()->route('admin.licenses.index');
    }

    public function destroy($id)
    {
        // Logic to delete the license
        return redirect()->route('admin.licenses.index');
    }
}
