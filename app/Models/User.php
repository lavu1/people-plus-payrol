<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Mail\SendMail;
use App\Models\Company\Company;
use App\Models\Company\CompanyEmployee;
use App\Models\Company\Contact;
use App\Models\Company\Identification;
use App\Models\Company\NextOfKin;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens,HasFactory, Notifiable, HasRoles, HasPanelShield;



    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
    public function canAccessFilament(): bool
    {
        return $this->is_verified; // Only verified users can access Filament
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'nrc',
        'gender',
        'marital_status',
        'passport',
        'password',
        'is_verified',
        'otp_code',
        'next_of_kin_id',
        'contact_id',
        'identification_id',
        'current_company_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'current_company_id');
    }
    public function companyEmployee()
    {
        return $this->hasOne(CompanyEmployee::class, 'user_id');
    }
    public static function sendMail($otp)
    {
        $user = Auth::user();
        $details = [
            'subject' => 'OTP',
            'name' => $user->name??'user',
            'OTP' => $otp
        ];

        //  Mail::to($user->email)->send(new ESendMail($details));
        Mail::to($user->email)->send(new SendMail($details));

        return response()->json(['done']);
    }

    public function identification()
    {
        return $this->hasOne(Identification::class,'id','identification_id');
    }

    public function next_of_kin()
    {
        return $this->hasOne(NextOfKin::class, 'id', 'next_of_kin_id');
    }

    public function contacts()
    {
        return $this->hasone(Contact::class);
    }
    public function contact()
    {
        return $this->hasOne(Contact::class,'id','contact_id');
    }

    protected static function boot()
    {

        parent::boot();

        static::creating(function ($user) {
           // $user->otp_code = rand(100000, 999999);
            //  Mail::to($user->email)->send(new ESendMail($details));

        });
        static::updating(function ($user) {
           // $user->otp_code = rand(100000, 999999);
            //  Mail::to($user->email)->send(new ESendMail($details));

        });
/*
        static::created(function ($user) {
            // Send OTP via email
            $details = [
                'subject' => 'OTP',
                'name' => $user->name??'user',
                'OTP' => $user->otp_code
            ];
            Mail::to($user->email)->send(new SendMail($details));
        });

        static::updated(function ($user) {
            // Send OTP via email
            $details = [
                'subject' => 'OTP',
                'name' => $user->name??'user',
                'OTP' => $user->otp_code
            ];
            Mail::to($user->email)->send(new SendMail($details));
        });
        */
    }

}
