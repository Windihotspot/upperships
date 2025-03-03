<?php
use App\Http\Controllers\ShipmentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
});

// Shipment Controller Routes
Route::controller(ShipmentController::class)->group(function () {
  Route::get('/shipments', 'index')->name('shipments.index'); // AdminShipment View
  Route::post('/shipments', 'store')->name('shipments.store');
  Route::put('/shipments/{shipment}', 'update')->name('shipments.update');
  Route::delete('/shipments/{shipment}', 'destroy')->name('shipments.destroy');
});