<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Request
 *
 * @property int $id
 * @property int $ad_id
 * @property int $company_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Request newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Request newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Request query()
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Request whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Ad|null $ad
 * @property-read \App\Models\Company|null $company
 */
class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id', 'company_id', 'status'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
	public function ad()
	{
		return $this->belongsTo(Ad::class);
	}
	public function company()
	{
		return $this->belongsTo(Company::class);
	}
}
