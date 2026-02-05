<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailConfigure extends Model
{
    use HasFactory;
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'host',
        'port',
        'email',
        'password',
        'mail_from_name',
        'mail_from_email',
        'encryption',
        'slug',
        'status',
    ];

    /**
     * Hide sensitive attributes from JSON arrays
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'port' => 'integer',
        'encryption' => 'integer',
        'status' => 'integer',
    ];

    /**
     * Return decrypted password (use carefully)
     */
    public function getDecryptedPassword()
    {
        try {
            return \Illuminate\Support\Facades\Crypt::decryptString($this->password);
        } catch (\Exception $e) {
            return null;
        }
    }
}
