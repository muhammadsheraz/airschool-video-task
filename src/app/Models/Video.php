<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    // Status
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    // Visibility
    const VISIBILITY_PUBLIC = 1;
    const VISIBILITY_PRIVATE = 2;

    // State
    const STATE_DEFAULT = 10;
    const STATE_PROCESSING = 20;
    const STATE_M3U8_CONVERTED = 30;

    protected $table = 'videos';
    protected $fillable = [
        'title', 'description', 'video_path', 'meta_data', 'status', 'visibility', 'state', 'user_id'
    ];   
    

    public function scopeConverted($query, $value=self::STATE_M3U8_CONVERTED)
    {
        return $query->where('state', $value);
    }    

    public function getVisibility($value)
    {
        $mappedValue = '';

        switch ($value) {
            case (self::VISIBILITY_PUBLIC):
                $mappedValue = 'Public';
            case (self::VISIBILITY_PRIVATE):
                $mappedValue = 'Private';                
        }

        return $mappedValue;
    }    
}
