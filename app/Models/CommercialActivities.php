<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommercialActivities extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        "id",
        "user_id",
        "company_name",
        "organization_type",
        "cr_number",
        "cr_date",
        "unified_number",
        "issued_by",
        "licence_number",
        "licence_issue_place",
        "modify_business"
    ];

    protected $hidden =[
        "created_at",
        "updated_at",
        "deleted_at"
    ];
}
