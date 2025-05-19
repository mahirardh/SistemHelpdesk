<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika nama tabel adalah bentuk jamak dari nama model)
    protected $table = 'laporans';

    // Field yang boleh diisi mass assignment
    protected $fillable = [
        'ticket_number',
        'email',
        'phone',
        'category',
        'department',
        'description',
        'status',
        'reporter_name',
        'attachment',
    ];


    // timestamps diaktifkan (default true)
    public $timestamps = true;
}
