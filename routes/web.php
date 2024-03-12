<?php

use App\Models\User;
use App\Models\Customer;
use App\Models\Categorie;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\TokenVerificationMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


//Web API Route

Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);
//Token Verify
Route::post('/reset-password',[UserController::class,'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/user-profile',[UserController::class,'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update',[UserController::class,'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);
//user logout
Route::get('/logout',[UserController::class,'UserLogout']);

// Page Route
Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard',[UserController::class,'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/categoryPage',[CategorieController::class,'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/productPage',[ProductController::class,'ProductPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoicePage',[InvoiceController::class,'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/salePage',[InvoiceController::class,'SalePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/reportPage',[ReportController::class,'ReportPage'])->middleware([TokenVerificationMiddleware::class]);

//Category API
Route::post('/create-category',[CategorieController::class,'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-category',[CategorieController::class,'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-category',[CategorieController::class,'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-category',[CategorieController::class,'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/category-by-id',[CategorieController::class,'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);


//Customer API
Route::post('/create-customer',[CustomerController::class,'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-customer',[CustomerController::class,'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-customer',[CustomerController::class,'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-by-id',[CustomerController::class,'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-customer',[CustomerController::class,'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);


//Product API
Route::post('/create-product',[ProductController::class,'CreateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-product',[ProductController::class,'DeleteProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/product-by-id',[ProductController::class,'ProductByID'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-product',[ProductController::class,'ProductList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-product',[ProductController::class,'UpdateProduct'])->middleware([TokenVerificationMiddleware::class]);

//Invoice Api

Route::post("/invoice-create",[InvoiceController::class,'invoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/invoice-select",[InvoiceController::class,'invoiceSelect'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-details",[InvoiceController::class,'InvoiceDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-delete",[InvoiceController::class,'invoiceDelete'])->middleware([TokenVerificationMiddleware::class]);

//Dashboard Api

Route::get("/summary",[DashboardController::class,'Summary'])->middleware([TokenVerificationMiddleware::class]);

//summary $ Report
Route::get("/sales-report/{FormDate}/{ToDate}",[ReportController::class,'SalesReport'])->middleware([TokenVerificationMiddleware::class]);
