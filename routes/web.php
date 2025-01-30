<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
});

Route::get('/shipment', function () {
  return Inertia::render('AdminShipment');
});