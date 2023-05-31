<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacturer',
        'size',
        'resolution',
        'screenType',
        'touch',
        'processorName',
        'physicalCores',
        'clockSpeed',
        'ram',
        'storage',
        'discType',
        'graphicCardName',
        'memory',
        'os',
        'disc_reader',
    ];
}
