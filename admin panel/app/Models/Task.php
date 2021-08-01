<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    const STATUS_ACCEPT=1;
    const STATUS_REJECT=2;
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'y',
        'm',
        'd',
        'status',
        'date'    
    ];
    protected $appends = array('status_text','start');
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function getStatusTextAttribute()
    {
        if($this->status == self::STATUS_ACCEPT){
            return 'accept';  
        }elseif($this->status == self::STATUS_REJECT){
            return'reject';
        }else{
            return'unknown';
        }
    }
    public function getStartAttribute()
    {
        return date('Y-m-d',$this->date);  
    }
}
