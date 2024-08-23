<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    // Tentukan tabel jika nama tabel berbeda dari konvensi Laravel
    protected $table = 'tb_ro_cities';

    // Tentukan primary key jika tidak menggunakan 'id'
    protected $primaryKey = 'city_id';

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['city_id', 'province_id', 'city_name', 'postal_code'];

    // Relasi dengan Subdistrict
    public function subdistricts()
    {
        return $this->hasMany(Subdistrict::class, 'city_id', 'city_id');
    }
}

