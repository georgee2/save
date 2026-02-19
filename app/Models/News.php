<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\LogsActivity;

class News extends Model
{
    use HasFactory, LogsActivity;
    
    protected $logTitleField = 'title_english';

    protected $guarded = [];

    public function NewRecord(array $data){
        $this->create($data);
    }

    public function list(){
        $news = DB::select('
            SELECT 
                news.id AS "Code",
                news.title_english AS "English Title",
                news.title_arabic AS "Arabic Title"
            FROM news
            ');
        return $news;
    }


    public function find(int $id){
        $news = DB::select('
            SELECT 
                news.id,
                news.title_english,
                news.title_arabic,
                news.bio_english,
                news.bio_arabic,
                news.body_english,
                news.body_arabic,
                news.button_text,
                news.button_text_arabic,
                news.link_english,
                news.link_arabic,
                news.seo_tags,
                news.seo_des_en,
                news.seo_des_ar,
                news.image,
                news.category_code,
                news.cover,
                newscategories.name_english AS "caten",
                newscategories.name_arabic AS "catar",
                news.slug,
                news.created_at
            FROM news 
            JOIN newscategories ON newscategories.id = news.category_code 
            WHERE news.id = :id
            ',['id' => $id]);

        return collect($news)->first();
    }

    public function updateRecord(int $id , array $data){

        $this->findOrFail($id)->update($data);
    }

    public function deleteRecord(int $id){

        $this->findOrFail($id)->delete();
    }

    public function getscopes()
    {
        $news = DB::select('
            SELECT 
                news.id,
                news.title_english,
                news.title_arabic,
                news.slug
            FROM news
            '); 
        return $news;
    }



    public function getlastnews()
    {
        $news = DB::select('
            SELECT 
                news.id,
                news.title_english,
                news.title_arabic,
                news.bio_english,
                news.bio_arabic,
                news.body_english,
                news.body_arabic,
                news.image,
                newscategories.name_english AS "caten",
                newscategories.name_arabic AS "catar",
                news.category_code,
                news.created_at,
                news.slug
            FROM news
            JOIN newscategories ON newscategories.id = news.category_code
            ORDER BY news.created_at DESC 
            LIMIT 10
            ');
        return $news;
    }


    public function getlastnewspage()
    {
        $news = DB::select('
            SELECT 
                news.id,
                news.title_english,
                news.title_arabic,
                news.bio_english,
                news.bio_arabic,
                news.image,
                newscategories.name_english AS "caten",
                newscategories.name_arabic AS "catar",
                news.category_code,
                news.created_at,
                news.slug
            FROM news
            JOIN newscategories ON newscategories.id = news.category_code
            ORDER BY news.created_at DESC 
            LIMIT 5
            ');
        return $news;
    }


    public function blogs()
    {
        $news = DB::select('
            SELECT 
                news.id,
                news.title_english,
                news.title_arabic,
                news.bio_english,
                news.bio_arabic,
                news.image,
                newscategories.name_english AS "caten",
                newscategories.name_arabic AS "catar",
                news.category_code,
                news.created_at,
                news.slug
            FROM news
            JOIN newscategories ON newscategories.id = news.category_code
            ORDER BY news.created_at DESC 
            ');
        return $news;
    }
}
