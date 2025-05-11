<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LicenseRequest;
use App\Models\License;
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

    // LicenseRequest
    public function store(LicenseRequest  $request)
    {
        // Log::info('License creation request', ['request' => $request->all()]);
        $license = $this->licenseService->store($request->validated());
        // Log::info('License created', ['license' => $license]);

        return redirect()
            ->route('admin.licenses.index')
            ->with('success', 'License created successfully!');
    }

    public function show($id)
    {
        $license = $this->licenseService->findLicenseById($id);
        if (!$license) {
            return redirect()->route('admin.licenses.index')->with('error', 'License not found.');
        }
        return view('admin.license.show', compact('license'));
    }

    public function edit($id)
    {
        $license = $this->licenseService->findLicenseById($id);
        if (!$license) {
            return redirect()->route('admin.licenses.index')->with('error', 'License not found.');
        }
        return view('admin.license.edit', compact('license'));
    }

    public function update(Request $request, $id)
    {
        Log::info('License update request', ['request' => $request->all()]);
        // Logic to update the license
        $license = $this->licenseService->findLicenseById($id);
        if (!$license) {
            return redirect()->route('admin.licenses.index')->with('error', 'License not found.');
        }
        $this->licenseService->update($license, $request->all());
        return redirect()->route('admin.licenses.index');
    }

    public function destroy($id)
    {
        // Logic to delete the license
        return redirect()->route('admin.licenses.index');
    }

    public function validate(Request $request)
    {
        Log::info($request->all());

        $validated = $request->validate([
            'license_key' => 'required|string',
            'domain' => 'required|string',
            'ip' => 'nullable|ip',
        ]);

        Log::info('License validation request', ['validated' => $validated]);

        $result = $this->licenseService->validate($validated['license_key'], $validated['domain'], $validated['ip']);
        Log::info('License validation result', ['result' => $result]);

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    public function deactivate($id, Request $request)
    {


        $license = $this->licenseService->findLicenseById($id);
        if (!$license) {
            return redirect()->route('admin.licenses.index')->with('error', 'License not found.');
        }

        $this->licenseService->deactivate($license);

        return redirect()
            ->route('admin.licenses.index')
            ->with('success', 'License deactivated successfully!');
    }
    public function activate($id, Request $request)
    {
        $license = $this->licenseService->findLicenseById($id);
        if (!$license) {
            return redirect()->route('admin.licenses.index')->with('error', 'License not found.');
        }

        $this->licenseService->activate($license);

        return redirect()
            ->route('admin.licenses.index')
            ->with('success', 'License activated successfully!');
    }
}
