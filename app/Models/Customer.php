<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Tentukan tabel jika nama tabel berbeda dari konvensi Laravel
    protected $table = 'customers';

    // Tentukan primary key jika tidak menggunakan 'id'
    protected $primaryKey = 'id';

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['id_users', 'address', 'phone', 'province_id', 'city_id', 'subdistric_id'];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users', 'id');
    }
}
