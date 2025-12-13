<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function NewRecord(array $data){
        $this->create($data);
    }

    public function list(){
        $services = DB::select('
            SELECT 
                services.id AS "Code",
                services.title_english AS "English Title",
                services.title_arabic AS "Arabic Title",
                CASE 
                    WHEN services.is_sub_service = 1 THEN "Sub Service"
                    ELSE "Main Service"
                END AS "Type",
                CASE 
                    WHEN services.publish_status = 0 THEN "Published"
                    ELSE "Not Published"
                END AS "Publish Status",
                CASE 
                    WHEN services.home_feature_status = 0 THEN "Shown"
                    ELSE "Not Shown"
                END AS "Home Feature"
            FROM services
            WHERE services.deleted_at IS NULL 
            ');
        return $services;
    }

    public function trashed(){
        $services = DB::select('
            SELECT 
                services.id AS "Code",
                services.title_english AS "English Title",
                services.title_arabic AS "Arabic Title",
                CASE 
                    WHEN services.is_sub_service = 1 THEN "Sub Service"
                    ELSE "Main Service"
                END AS "Type",
                CASE 
                    WHEN services.publish_status = 0 THEN "Published"
                    ELSE "Not Published"
                END AS "Publish Status",
                CASE 
                    WHEN services.home_feature_status = 0 THEN "Shown"
                    ELSE "Not Shown"
                END AS "Home Feature"
            FROM services
            WHERE services.deleted_at IS NOT NULL 
            ');
        return $services;
    }

    public function find(int $id){
        $service = DB::select('
            SELECT 
                services.*,
                parent.title_english AS parent_title_en,
                parent.title_arabic AS parent_title_ar
            FROM services 
            LEFT JOIN services AS parent ON parent.id = services.service_id 
            WHERE services.id = :id
            ',['id' => $id]);

        return collect($service)->first();
    }

    public function updateRecord(int $id , array $data){

        $this->findOrFail($id)->update($data);
    }

    public function deleteRecord(int $id){

        $this->findOrFail($id)->delete();
    }

    public function restore(int $id)
    {
      $service = Service::withTrashed()->where('id',$id)->restore();
      return $service;
    }

    public function getMainServices()
    {
        $services = DB::select('
            SELECT 
                services.id,
                services.title_english,
                services.title_arabic
            FROM services
            WHERE services.deleted_at IS NULL 
            AND services.is_sub_service = 0
            '); 
        return $services;
    }

    public function getservices()
    {
        $services = DB::select('
            SELECT 
                services.id,
                services.title_english,
                services.title_arabic,
                services.bio_english,
                services.bio_arabic,
                services.icon,
                services.slug,
                services.main_image,
                services.is_sub_service,
                services.publish_status,
                services.home_feature_status
            FROM services
            WHERE services.deleted_at IS NULL
            AND services.publish_status = 0
            ');
        return $services;
    }

    public function serviceshome()
    {
        $services = DB::select('
            SELECT 
                services.id,
                services.title_english,
                services.title_arabic,
                services.bio_english,
                services.bio_arabic,
                services.icon,
                services.slug,
                services.main_image,
                services.service_home_image
            FROM services
            WHERE services.deleted_at IS NULL
            AND services.is_sub_service = 0
            AND services.publish_status = 0
            AND services.home_feature_status = 0
            ');
        return $services;
    }
    
    public function features()
    {
        return $this->hasMany(ServiceFeature::class);
    }

    public function values()
    {
        return $this->hasMany(ServiceValue::class);
    }

    public function processes()
    {
        return $this->hasMany(ServiceProcess::class)->orderBy('order');
    }

    public function blocks()
    {
        return $this->hasMany(ServiceBlock::class);
    }

    public function serviceFaqs()
    {
        return $this->hasMany(ServiceFAQ::class);
    }
    
    public function faqs()
    {
        return $this->belongsToMany(FAQ::class, 'service_faqs', 'service_id', 'faq_id')->withTimestamps();
    }
    
    public function sectionOrders()
    {
        return $this->hasMany(ServiceSectionOrder::class)->orderBy('order');
    }
    
    // Relationship for sub-services
    public function subServices()
    {
        return $this->hasMany(Service::class, 'service_id', 'id')
                    ->where('is_sub_service', 1)
                    ->where('publish_status', 0)
                    ->whereNull('deleted_at');
    }
    
    // Relationship for parent service
    public function parentService()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
