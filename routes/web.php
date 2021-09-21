<?php

use App\Http\Controllers\PetaniController;
use App\Http\Controllers\SopirController;
use App\Http\Controllers\PgController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerangkatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PulangContoller;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;


Route::get('/', [UserController::class, 'index']);


Route::get('/dashboard', [DashboardController::class, 'index']);

Route::prefix('/user')->group(function () {
    Route::prefix('/view')->group(function () {
        Route::get('/add', [UserController::class, 'viewAdd'])->middleware('myAuth');
    });
    Route::get('/', [UserController::class, 'viewindex']);
    // route crud user
    Route::post('/', [UserController::class, 'add'])->middleware('isAdmin');
    Route::put('/{id}', [UserController::class, 'update'])->middleware('isAdmin');
    Route::get('/{id}', [UserController::class, 'delete'])->middleware('isAdmin');
    // route grouping
    Route::prefix('/group')->group(function () {
        Route::get('/search', [UserController::class, 'search'])->middleware('isAdmin');
    });
    // Route get update user
    Route::prefix('/json')->group(function () {
        Route::get('/getUser/{id}', [UserController::class, 'getUpdate'])->middleware('isAdmin');
    });
});

/* ===================== Routing petani =================  */

// Routing petani
Route::prefix('/pemilik')->group(function () {
    // route to view pg
    Route::prefix('/view')->group(function () {
        Route::get('/add', [PetaniController::class, 'viewAdd'])->middleware('myAuth');
    });
    // route crud petani
    Route::get('/', [PetaniController::class, 'index'])->middleware('myAuth');
    Route::post('/', [PetaniController::class, 'add'])->middleware('myAuth');
    Route::put('/{id}', [PetaniController::class, 'update'])->middleware('myAuth');
    Route::get('/{id}', [PetaniController::class, 'delete'])->middleware('myAuth');
    Route::get('/getRegister/{id}', [PetaniController::class, 'getRegister'])->middleware('myAuth');
    Route::get('/induk/{id}/{induk}', [PetaniController::class, 'updateInduk'])->middleware('myAuth');
    // route grouping
    Route::prefix('/group')->group(function () {
        Route::get('/search', [PetaniController::class, 'search'])->middleware('myAuth');
    });
    // route get update data petani
    Route::prefix('/json')->group(function () {
        Route::get('/getPetani/{id}', [PetaniController::class, 'getUpdate'])->middleware('myAuth');
    });
});

/* ===================== Routing sopir =================  */

Route::prefix('/petani')->group(function () {
    // route to view pg
    Route::prefix('/view')->group(function () {
        Route::get('/add', [SopirController::class, 'viewAdd'])->middleware('myAuth');
    });
    // route crud sopir
    Route::get('/', [SopirController::class, 'index'])->middleware('myAuth');
    Route::post('/', [SopirController::class, 'add'])->middleware('myAuth');
    Route::put('/{id}', [SopirController::class, 'update'])->middleware('myAuth');
    Route::get('/{id}', [SopirController::class, 'delete'])->middleware('myAuth');

    Route::prefix('/group')->group(function () {
        Route::get('/search', [SopirController::class, 'search'])->middleware('myAuth');
    });

    // route get update data sopir
    Route::prefix('/json')->group(function () {
        Route::get('/getSopir/{id}', [SopirController::class, 'getUpdate'])->middleware('myAuth');
    });
});

/* ===================== Routing wilayah =================  */

Route::prefix('/wilayah')->group(function () {
    // route to view pg
    Route::prefix('/view')->group(function () {
        Route::get('/add', [WilayahController::class, 'viewAdd'])->middleware('myAuth');
    });
    // route crud Wilayah
    Route::get('/', [WilayahController::class, 'index'])->middleware('myAuth');
    Route::post('/', [WilayahController::class, 'add'])->middleware('myAuth');
    Route::put('/{id}', [WilayahController::class, 'update'])->middleware('myAuth');
    Route::get('/{id}', [WilayahController::class, 'delete'])->middleware('myAuth');
    Route::get('/getHarga/{id}', [WilayahController::class, 'getHarga'])->middleware('myAuth');
    Route::get('/harga/{id}/{harga}', [WilayahController::class, 'updateHarga'])->middleware('myAuth');

    Route::prefix('/group')->group(function () {
        Route::get('/search', [WilayahController::class, 'search'])->middleware('myAuth');
    });

    // route get update data Wilayah
    Route::prefix('/json')->group(function () {
        Route::get('/getWilayah/{id}', [WilayahController::class, 'getUpdate'])->middleware('myAuth');
    });
});

/* ===================== Routing pg =================  */

Route::prefix('/pg')->group(function () {
    // route to view pg
    Route::prefix('/view')->group(function () {
        Route::get('/add', [PgController::class, 'viewAdd'])->middleware('myAuth');
    });
    // route crud Pg
    Route::get('/', [PgController::class, 'index'])->middleware('myAuth');
    Route::post('/', [PgController::class, 'add'])->middleware('myAuth');
    Route::put('/{id}', [PgController::class, 'update'])->middleware('myAuth');
    Route::get('/{id}', [PgController::class, 'delete'])->middleware('myAuth');

    Route::prefix('/group')->group(function () {
        Route::get('/search', [PgController::class, 'search'])->middleware('myAuth');
    });

    // route get update data Pg
    Route::prefix('/json')->group(function () {
        Route::get('/getPg/{id}', [PgController::class, 'getUpdate'])->middleware('myAuth');
    });
});

Route::prefix('/auth')->group(function () {
    Route::post('/', [AuthController::class, 'Login']);
    Route::get('/logout', [AuthController::class, 'Logout'])->middleware('myAuth');
});

/* ================== Routing keberangkatan ================  */

Route::prefix('/berangkat')->group(function () {
    // main action
    Route::get('/', [BerangkatController::class, 'index'])->middleware('myAuth');
    Route::post('/', [BerangkatController::class, 'add'])->middleware('myAuth');
    Route::put('/{id}', [BerangkatController::class, 'update'])->middleware('myAuth');
    Route::get('/{id}', [BerangkatController::class, 'delete'])->middleware('myAuth');
    // secondary action
    Route::get('/search', [BerangkatController::class, 'search'])->middleware('myAuth');
    Route::get('/filter', [BerangkatController::class, 'filter'])->middleware('myAuth');
    Route::get('/getPg/{name}', [BerangkatController::class, 'getPg'])->middleware('myAuth');
    // transaksi
    Route::get('/pulang', [PulangContoller::class, 'show'])->middleware('myAuth');
    // view
    Route::prefix('/view')->group(function () {
        Route::get('/get/{id}', [BerangkatController::class, 'getUpdate'])->middleware('myAuth');
        Route::get('/cetak', [BerangkatController::class, 'cetak'])->middleware('myAuth');
    });
});

Route::prefix('/pulang')->group(function () {
    // main action
    Route::get('/', [PulangContoller::class, 'index'])->middleware('myAuth');
    Route::post('/{id}', [PulangContoller::class, 'create'])->middleware('myAuth');
    Route::put('/{id}', [PulangContoller::class, 'edit'])->middleware('myAuth');
    Route::get('/{id}', [PulangContoller::class, 'destroy'])->middleware('myAuth');
    // seondary action
    Route::prefix('/view')->group(function () {
        Route::get('/list', [PulangContoller::class, 'show'])->middleware('myAuth');
        Route::get('/cetak', [PulangContoller::class, 'cetak'])->middleware('myAuth');
        Route::get('/get/{id}', [PulangContoller::class, 'update'])->middleware('myAuth');
        Route::put('/list/{id}', [PulangContoller::class, 'updateSp']);
    });
});

Route::prefix('/pembayaran')->group(function () {
    // main action
    Route::get('/', [PembayaranController::class, 'index'])->middleware('myAuth');
    Route::post('/', [PembayaranController::class, 'add'])->middleware('myAuth');
    Route::put('/{id}', [PembayaranController::class, 'update'])->middleware('myAuth');
    Route::get('/{id}', [PembayaranController::class, 'destroy'])->middleware('myAuth');
    // transaksi route
    Route::prefix('/chekout')->group(function () {
        Route::post('/', [PembayaranController::class, 'store'])->middleware('myAuth');
    });
    // secondary action
    Route::prefix('/view')->group(function () {
        Route::get('/list', [PembayaranController::class, 'show'])->middleware('myAuth');
    });
});

Route::prefix('/transaksi')->group(function () {
    Route::prefix('/berangkat')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->middleware('myAuth');
        Route::post('/cetak', [TransaksiController::class, 'cetakTransaksi'])->middleware('myAuth');
    });
    Route::prefix('/pembayaran')->group(function () {
        Route::get('/', [TransaksiController::class, 'viewLaporan'])->middleware('myAuth');
        Route::get('/cetak', [TransaksiController::class, 'cetakPembayaran'])->middleware('myAuth');
    });
});

Route::post('/filterberangkat', [FilterController::class, 'FilterBData'])->middleware('myAuth');
Route::post('/filterpulang', [FilterController::class, 'FilterData'])->middleware('myAuth');
Route::post('/filtertransaksi', [FilterController::class, 'FilterTData'])->middleware('myAuth');
Route::post('/filterlaporan', [FilterController::class, 'FilterLPData'])->middleware('myAuth');
Route::post('/filterpembayaran', [FilterController::class, 'FilterPData'])->middleware('myAuth');
Route::post('/filterlist', [FilterController::class, 'FilterLData'])->middleware('myAuth');
Route::get('/pilih', [FilterController::class, 'getSopir'])->middleware('myAuth');
Route::get('/detail', [FilterController::class, 'getDetail'])->middleware('myAuth');
Route::get('/detailp', [FilterController::class, 'getDetailP'])->middleware('myAuth');

Route::get('/coba', function () {
    return view('coba-invoice');
});
