<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShipmentController extends Controller
{
    public function index()
    {
        // Fetch all shipments and pass them to the AdminShipment view
        $shipments = Shipment::all();

        return Inertia::render('AdminShipment', [
            'shipments' => $shipments
        ]);
    }

    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([

            'sender_name' => 'required|string',
            'sender_address' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_address' => 'required|string',
            'package_weight' => 'required|numeric',
            'status' => 'required|string|in:Pending,Shipped,Delivered',
        ]);

        // Auto-generate tracking ID
        $validated['tracking_id'] = 'TRK' . strtoupper(uniqid());

        // Create shipment
        Shipment::create($validated);

        return redirect()->route('shipments.index')->with('success', 'Shipment created successfully!');
    }

    public function update(Request $request, Shipment $shipment)
    {
        // Validate request
        $validated = $request->validate([
            'sender_name' => 'required|string',
            'sender_address' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_address' => 'required|string',
            'package_weight' => 'required|numeric',
            'status' => 'required|string|in:Pending,Shipped,Delivered',
        ]);

        // Update shipment
        $shipment->update($validated);

        return redirect()->route('shipments.index')->with('success', 'Shipment updated successfully!');
    }

    public function show(Shipment $shipment)
    {
        return Inertia::render('ShipmentDetails', [
            'shipment' => $shipment
        ]);
    }

    public function trackShipment(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string',
        ]);

        $shipment = Shipment::where('tracking_id', $request->tracking_id)->first();

        if (!$shipment) {
            return Inertia::render('TrackingDetails', [
                'error' => 'Shipment not found.',
            ]);
        }

        return Inertia::render('TrackingDetails', [
            'shipment' => $shipment,
        ]);
    }


}
