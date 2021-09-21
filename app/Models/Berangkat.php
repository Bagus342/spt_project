<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Berangkat extends Model
{
    protected $table = 'tb_transaksi';

    public function getToday()
    {
        $date = date("Y-m-d");
        $query = "SELECT * FROM tb_transaksi WHERE created_at LIKE '%{$date}%' AND refaksi = null";
        return DB::select($query);
    }
}
