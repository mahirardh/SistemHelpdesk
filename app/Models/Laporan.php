<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'ticket_number',
        'email',
        'phone',
        'kategori_id',
        'pelapor_id',
        'department',
        'description',
        'status',
        'attachment',
    ];

    public $timestamps = true;

    // Laporan.php

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }



    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }
}
