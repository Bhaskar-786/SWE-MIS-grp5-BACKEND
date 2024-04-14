<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicDeficiency extends Model
{
    protected $table = 'academic_deficiency'; // Specify the table name if it differs from the default
    protected $primaryKey = 'id'; // Specify the primary key if it differs from the default
    public $timestamps = false; // If your table doesn't have created_at and updated_at columns

    protected $fillable = [
        'user_id',
        'status',
        'warning_count',
        'probation_count',
    ];

    // Optionally, you can define relationships here
    // Example:
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }
}
