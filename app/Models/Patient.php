<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Civil status
     */

    const CIVIL_STATUS_SINGLE = 'soltero';
    
    const CIVIL_STATUS_MARRIED = 'casado';
     
    const CIVIL_STATUS_WIDOWER = 'viudo';
     
    const CIVIL_STATUS_DIVORCED = 'divorciado';

    const CIVIL_STATUSES = [
        self::CIVIL_STATUS_SINGLE,
        self::CIVIL_STATUS_MARRIED,
        self::CIVIL_STATUS_WIDOWER,
        self::CIVIL_STATUS_DIVORCED
    ];

    /**
     * Birth sex
     */

    const BIRTH_SEX_MALE = 'masculino';

    const BIRTH_SEX_FEMALE = 'femenino';

    const BIRTH_SEXS = [
        self::BIRTH_SEX_MALE,
        self::BIRTH_SEX_FEMALE
    ];

    
}
