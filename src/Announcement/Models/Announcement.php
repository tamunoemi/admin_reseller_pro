<?php

namespace Teckipro\Admin\Announcement\Models;

use Teckipro\Admin\Announcement\Models\Traits\Scope\AnnouncementScope;
use Teckipro\Admin\Database\FactoriesAnnouncementFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * Class Announcement.
 */
class Announcement extends Model
{
    use AnnouncementScope,
        HasFactory,
        LogsActivity;

    public const TYPE_FRONTEND = 'frontend';
    public const TYPE_BACKEND = 'backend';

    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    /**
     * @var string[]
     */
    protected $fillable = [
        'area',
        'type',
        'message',
        'enabled',
        'starts_at',
        'ends_at',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'starts_at',
        'ends_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'enabled' => 'boolean',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return AnnouncementFactory::new();
    }

    /** Fix for 
     * Class Teckipro\Admin\Announcement\Models\Announcement contains 1 
     * abstract method and must therefore be declared abstract or implement the remaining methods (Teckipro\Admin\Announcement\Models\Announcement::getActivitylogOptions)
     */
    public function getActivitylogOptions():LogOptions
 {
     return LogOptions::defaults()
         -> logOnly(['text'])
         -> logOnlyDirty()
         -> dontSubmitEmptyLogs();
 }

   
}
