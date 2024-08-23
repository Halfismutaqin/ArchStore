<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    // Tentukan tabel jika nama tabel berbeda dari konvensi Laravel
    protected $table = 'tb_ro_provinces';

    // Tentukan primary key jika tidak menggunakan 'id'
    protected $primaryKey = 'province_id';

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['province_id', 'province_name'];

    // Relasi dengan City
    public function cities()
    {
        return $this->hasMany(City::class, 'province_id', 'province_id');
    }
}
