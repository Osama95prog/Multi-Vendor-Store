<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();


        // code of video 6 or 7 as I remember
        // $query = Category::query() ;
        // if($name = $request->query('name')){
        //     $query->where('name','like',"%{$name}%") ;
        // }

        // if($status = $request->query('status')){
        //     // $query->whereStatus($status) ; //the same as below -- _--
        //     $query->where('status','=',$status) ;
        // }
        // $categories = $query->paginate(1);


        $categories = Category::with('parent')
        // leftJoin('categories as parents','parents.id','=','categories.parent_id')
        // ->select([
        //     'categories.*',
        //     'parents.name as parent_name'
        // ])
        // ->select('categories.*')
        // ->selectRaw('(SELECT COUNT(*) fROM products WHERE category_id = categories.id) as products_count')
        ->withCount([
            'products as products_count' => function($query){
                $query->where('status','=','active') ;
            }])
        ->filter($request->query())
        ->orderBy('categories.name')
        ->paginate(5);
        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::all( ) ;
        $category = new Category() ;
        return view('dashboard.categories.create',compact('parents','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());

        $request->merge(['slug' => Str::slug($request->post('name'))]);
        $data = $request->except('image');

        $data['image']= $this->uploadImage($request);


        $category = Category::create($data);
        return redirect()->route('dashboard.categories.index')->with('success','created succfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show',[
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $category = Category::find($id);
            if(!$category){
                return redirect()->route('dashboard.categories.index')->with('info','resources not found');
            }
            $parents = Category::where('id','<>',$id)
            ->where(function($query) use($id) {
                $query->whereNull('parent_id')->
                orWhere('parent_id','<>',$id) ;
            })
        // ->whereHas('parent', function($query) use($id){
            //     $query->whereNull('parent_id')
            //           ->where('parent_id','<>',$id);
            // })
            ->get() ;
            return view('dashboard.categories.edit',compact('parents','category'));
            }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        // $request->validate(Category::rules($id));
        $category = Category::findOrFail($id) ;
        $data = $request->except('image');
        $old_image = $category->image ;
        $new_image = $this->uploadImage($request) ;
        if($new_image){
            $data['image'] = $new_image ;
        }
        if($old_image && $new_image ){
            // will search for the image in default disk
            // Storage::delete($old_image);

            // we tell laravel to search in public disk
            Storage::disk('public')->delete($old_image);

        }

        $category->update($data);

        return redirect()->route('dashboard.categories.index')->with('success','updated succfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // we can delete using to way

        $category = Category::findOrFail($id);
        $category->delete() ;

        // if($category->image){
        //     Storage::disk('public')->delete($category->image) ;
        // }

        // Category::destroy($id) ;

        return redirect()->route('dashboard.categories.index')->with('success','deleted succfully');

    }

    function uploadImage(Request $request)   {
        if(!$request->hasFile('image')){
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads',[
            'disk' => 'public'
        ]);
        return $path ;
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')
            ->with('succes', 'Category restored!');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')
            ->with('succes', 'Category deleted forever!');
    }
}
