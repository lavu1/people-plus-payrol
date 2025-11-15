<?php

use App\Filament\Resources\UserResource\Pages\OTPVerification;
use App\Http\Controllers\Documents\ExcelController;
use App\Http\Controllers\Documents\PdfController;
use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/otp', [OTPVerification::class, 'render'])->name('otp.page');
Route::post('/otp/verify', [\App\Http\Controllers\Auth\OTPController::class, 'verify'])->name('otp.verify');
Route::post('/otp/new', [\App\Http\Controllers\Auth\OTPController::class, 'newOTP'])->name('otp.new');
Route::get('/back', [\App\Http\Controllers\Auth\OTPController::class, 'Back'])->name('back');


Route::get('pdf/{order}', PdfController::class)->name('pdf');

Route::get('excel-uba/{order}', [ExcelController::class,'generatePayrollUBA'])->name('bank-uba');
Route::get('excel-zanaco/{order}', [ExcelController::class,'generatePayrollZanaco'])->name('bank-zanaco');
//Route::get('pdf/{order}', PdfController::class)->name('pdf');
//website urls

//Route::get('/', function (){
//    return view('pages.index');
//});

$routes = ['/', '/dashboard', '/home', '/main'];

foreach ($routes as $route) {
    Route::get($route, function () {
        return view('pages.index');
    })->name('home');
}
Route::get('contact-us', function () {
    return view('pages.contact');
})->name('contact-us');
Route::get('about-us', function () {
    return view('pages.about');
})->name('about-us');
Route::get('services', function () {
    return view('pages.services');
})->name('services');
Route::get('portfolio', function () {
    return view('pages.portfolio');
})->name('portfolio');
Route::get('pricing', function () {
    return view('pages.pricing');
})->name('pricing');
Route::get('team', function () {
    return view('pages.team');
})->name('team');
Route::get('testimonials', function () {
    return view('pages.testimonials');
})->name('testimonials');
Route::get('blog', function () {
    return view('pages.blog');
})->name('blog');
Route::get('csr', function () {
    return view('pages.csr');
})->name('csr');
Route::get('sign-in', function () {
    return view('pages.signin');
})->name('sign-in');
Route::get('service-details', function () {
    return view('pages.service_details');
})->name('service-details');
//Route::get('/zigsapi.gsb.gov.zm/documents/84905694-8703-446C-AA9A-EAE751E56415/view', function () {
//    return view('pages.service_details');
//})->name('service-details');
Route::get('/getting-started', function () {
    return view('pages.getting-started');
})->name('getting-started');
// Fallback route
//Route::fallback(function () {
//    return view('pages.index');
//});

