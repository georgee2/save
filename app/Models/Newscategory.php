<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newscategory extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $guarded = [];

    public function NewRecord(array $data){
        $this->create($data);
    }

    public function list(){
        $newscategories = DB::select('
            SELECT 
                newscategories.id AS "Code",
                newscategories.name_english AS "English Name",
                newscategories.name_arabic AS "Arabic Name"
            FROM newscategories
            WHERE newscategories.deleted_at IS NULL 
            ');
        return $newscategories;
    }

    public function trashed(){
        $newscategories = DB::select('
            SELECT 
                newscategories.id AS "Code",
                newscategories.name_english AS "English Name",
                newscategories.name_arabic AS "Arabic Name"
            FROM newscategories
            WHERE newscategories.deleted_at IS NOT NULL 
            ');
        return $newscategories;
    }

    public function find(int $id){
        return $this->findOrFail($id);
    }

    public function updateRecord(int $id , array $data){

        $this->findOrFail($id)->update($data);
    }

    public function deleteRecord(int $id){

        $this->findOrFail($id)->delete();
    }

    public function restore(int $id)
    {
      $newscategories =   Newscategory::withTrashed()->where('id',$id)->restore();
      return $newscategories;
    }

    public function getscopes()
    {
        $newscategories = DB::select('
            SELECT 
                newscategories.id,
                newscategories.name_english,
                newscategories.name_arabic
            FROM newscategories
            WHERE newscategories.deleted_at IS NULL 
            '); 
        return $newscategories;
    }
}
