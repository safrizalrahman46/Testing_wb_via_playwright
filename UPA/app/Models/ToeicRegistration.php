<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeicRegistration extends Model
{
    use HasFactory;

    protected $table = 'toeic_registration'; // Pastikan nama tabel sesuai

    // Kolom yang dapat diisi
    protected $fillable = [
        'nim',
        'status',
        'registration_date',
        'score',
        'certificate_path', // Kolom yang diizinkan diisi
        'user_ref_id',
    ];

    // Menyembunyikan kolom tertentu
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Add this to cast 'registration_date' to a Carbon instance
    protected $casts = [
        'registration_date' => 'date',  // Automatically cast registration_date to a Carbon instance
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'nim', 'nim');
    }

}
