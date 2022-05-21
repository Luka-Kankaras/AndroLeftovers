<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model {

    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['terms_file_name', 'policy_file_name'];

    public function getTermsFileNameAttribute(){
        $array = explode('/', $this->terms_and_conditions);
        return end($array);
    }

    public function getPolicyFileNameAttribute(){
        $array = explode('/', $this->privacy_policy);
        return end($array);
    }

}
