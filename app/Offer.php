<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * App\Offer
 *
 * @property int $id
 * @property string $company_name
 * @property string $vacancy
 * @property string $location
 * @property string|null $salary
 * @property string|null $phone
 * @property string $email
 * @property string|null $studies
 * @property string|null $time_shift
 * @property string|null $logo
 * @property string $description
 * @property string $requirements
 * @property string|null $website
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Offer active()
 * @method static Builder|Offer newModelQuery()
 * @method static Builder|Offer newQuery()
 * @method static Builder|Offer query()
 * @method static Builder|Offer whereCompanyName($value)
 * @method static Builder|Offer whereCreatedAt($value)
 * @method static Builder|Offer whereDescription($value)
 * @method static Builder|Offer whereEmail($value)
 * @method static Builder|Offer whereId($value)
 * @method static Builder|Offer whereLocation($value)
 * @method static Builder|Offer whereLogo($value)
 * @method static Builder|Offer wherePhone($value)
 * @method static Builder|Offer whereRequirements($value)
 * @method static Builder|Offer whereSalary($value)
 * @method static Builder|Offer whereStudies($value)
 * @method static Builder|Offer whereTimeShift($value)
 * @method static Builder|Offer whereUpdatedAt($value)
 * @method static Builder|Offer whereVacancy($value)
 * @method static Builder|Offer whereWebsite($value)
 * @mixin Eloquent
 * @property-read mixed $title
 * @property-read mixed $url
 * @property-read mixed $thumbnail_url
 * @property int $is_approved
 * @method static Builder|Offer whereIsApproved($value)
 * @property string|null $end_date
 * @method static Builder|Offer whereEndDate($value)
 */
class Offer extends Model
{
    const VACANCIES = [
        'Contabil şef' => 'Contabil şef',
        'Contabil' => 'Contabil',
        'Jurist' => 'Jurist',
        'Contabil casier' => 'Contabil casier',
        'Auditor' => 'Auditor',
        'Auditor intern' => 'Auditor intern',
        'Director financiar' => 'Director financiar',
        'Casier' => 'Casier',
        'Contabil şef adjunct' => 'Contabil şef adjunct',
        'Economist' => 'Economist',
        'Ajutor contabil' => 'Ajutor contabil',
        'Ajutor auditor' => 'Ajutor auditor',
        'Specialist serviciu personal' => 'Specialist serviciu personal',
        'Analitic financiar' => 'Analitic financiar',
        'Operator PC' => 'Operator PC',
        'Specialist pe impozitare' => 'Specialist pe impozitare',
        'Secretar' => 'Secretar',
        'Financial Controller' => 'Financial Controller',
        'Consultant' => 'Consultant',
    ];

    const LOCATIONS = [
        'Anenii Noi' => 'Anenii Noi',
        'Balti' => 'Balti',
        'Basarabeasca' => 'Basarabeasca',
        'Bender' => 'Bender',
        'Briceni' => 'Briceni',
        'Cahul' => 'Cahul',
        'Cainari' => 'Cainari',
        'Calarasi' => 'Calarasi',
        'Cantemir' => 'Cantemir',
        'Causeni' => 'Causeni',
        'Chisinau' => 'Chisinau',
        'Ciadir-Lunga' => 'Ciadir-Lunga',
        'Cimislia' => 'Cimislia',
        'Comrat' => 'Comrat',
        'Criuleni' => 'Criuleni',
        'Donduseni' => 'Donduseni',
        'Drochia' => 'Drochia',
        'Edinet' => 'Edinet',
        'Falesti' => 'Falesti',
        'Floresti' => 'Floresti',
        'Glodeni' => 'Glodeni',
        'Hincesti' => 'Hincesti',
        'Ialoveni' => 'Ialoveni',
        'Leova' => 'Leova',
        'Nisporeni' => 'Nisporeni',
        'Ocnita' => 'Ocnita',
        'Orhei' => 'Orhei',
        'Rezina' => 'Rezina',
        'Riscani' => 'Riscani',
        'Singerei' => 'Singerei',
        'Soldanesti' => 'Soldanesti',
        'Soroca' => 'Soroca',
        'Stefan Voda' => 'Stefan Voda',
        'Straseni' => 'Straseni',
        'Taraclia' => 'Taraclia',
        'Telenesti' => 'Telenesti',
        'Transnistria' => 'Transnistria',
        'Ungheni' => 'Ungheni',
        'Vulcanesti' => 'Vulcanesti',
    ];

    const STUDIES = [
        'Gimnaziale' => 'Gimnaziale',
        'Liceale' => 'Liceale',
        'Superioare' => 'Superioare',
    ];

    const TIME_SHIFTS = [
        'Full-time' => 'Full-time',
        'Part-time' => 'Part-time',
        'Working in shifts' => 'Working in shifts',
        'Work from home' => 'Work from home',
    ];

    protected $fillable = [
        'company_name',
        'vacancy',
        'location',
        'salary',
        'phone',
        'email',
        'studies',
        'time_shift',
        'logo',
        'description',
        'requirements',
        'website',
        'is_approved',
        'end_date'
    ];

    public function scopeActive(Builder $builder)
    {
        return $builder->where('is_approved', 1)->where(DB::raw('DATE(end_date)'), '>', Carbon::now()->format('Y-m-d'));
    }

    public function getUrlAttribute()
    {
        return route('offer.view', $this->id);
    }

    public function getTitleAttribute()
    {
        return $this->vacancy . ' - ' . $this->company_name;
    }

    public function addNewUrl()
    {
        return route('offer.create');
    }

    public function seeMoreUrl()
    {
        return route('offer.index');
    }

    /**
     * @param $length
     * @return string
     */
    public function getShort($length)
    {
        $body = preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/is', "$1$3", $this->description);
        $short = mb_substr(strip_tags($body), 0, $length);
        if (strlen(strip_tags($body)) > $length) {
            $short .= '...';
        }
        return $short;
    }

    public function getThumbnailUrlAttribute()
    {
        return config('app.url') . Storage::url($this->logo);
    }
}
