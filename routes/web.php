<?php
use App\Http\Controllers\ShipmentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
});

Route::get('/tracking', function () {
  return Inertia::render('Tracking');
});

Route::get('/onboarding', function () {
  return Inertia::render('Onboarding');
});

Route::get('/tracking', function () {
  return Inertia::render('Tracking');
});


// Shipment Controller Routes
Route::controller(ShipmentController::class)->group(function () {
  Route::get('/shipments', 'index')->name('shipments.index'); 
  Route::get('/shipments/{shipment}', 'show')->name('shipments.show');
  Route::post('/shipments', 'store')->name('shipments.store');
  Route::put('/shipments/{shipment}', 'update')->name('shipments.update');
  Route::delete('/shipments/{shipment}', 'destroy')->name('shipments.destroy');
});


Route::get('/track-shipment', function () {
  return Inertia::render('Tracking');
})->name('shipments.track-form');

Route::get('/track', [ShipmentController::class, 'trackShipment'])->name('shipments.track');
