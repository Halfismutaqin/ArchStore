<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory;

    // Tentukan tabel jika nama tabel berbeda dari konvensi Laravel
    protected $table = 'tb_ro_subdistricts';

    // Tentukan primary key jika tidak menggunakan 'id'
    protected $primaryKey = 'subdistrict_id';

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['subdistrict_id', 'city_id', 'subdistrict_name', 'postal_code'];

    // Relasi dengan City
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }
}
