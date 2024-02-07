<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name','description','parent_id','image','status','slug'
    ];

    function scopeActive(Builder $builder) {
        $builder->where('status','active') ;
    }
    function scopeStatus(Builder $builder,$status) {
        $builder->where('status',$status) ;
    }
    // filter based on status and name ..
    function scopeFilter(Builder $builder,$filter) {
        $builder->when($filter['name'] ?? false, function($builder,$value){
            $builder->where('categories.name','like',"%{$value}%") ;
        }) ;

        $builder->when($filter['status'] ?? false, function($builder,$value){
            if($value == 'all'){
                $builder->whereIn('categories.status',['active','archived']) ;
            }
            else{
                $builder->where('categories.status','=',"{$value }") ;
            }
        }) ;
        // if($filter['name'] ?? false){
        //     $builder->where('name','like',"%{$filter['name'] }%") ;
        // }

        // if($filter['status'] ?? false){
        //     $builder->where('status','=',$filter['status'] );
        // }
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }


    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id','id')
        ->withDefault([
            'name' => '-'
        ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }

    public static function rules($id = 0) {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                // "unique:categories,name,$id",
                Rule::unique('categories','name')->ignore($id),
                // function($attribute,$value,$fails){
                //     if(strtolower($value) == 'laravel'){
                //         $fails('this name is forbidden!');
                //     }
                // }
                // new Filter('laravel')
                'filter:php,laravel,html'
            ],
            'parent_id' => [
                'nullable','int','exists:categories,id'
            ],
            'image' => [
                'image', 'max:1048576', 'dimensions:min_width=100,min_height=100',
            ],
            'status' => 'in:active,archived'
        ];
    }
}
