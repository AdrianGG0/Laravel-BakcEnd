<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs  extends Model
{
    use HasFactory;

    protected $table = 'logs';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'section',
        'message',
        'query',
        'date',
    ];

    public $timestamps = true;

}
