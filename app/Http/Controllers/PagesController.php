<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PagesController extends Controller
{

      public function include(){
     if(!auth()->user())
     {
        return  0;
     }
     else{
       return Cart::where('user_id',auth()->user()->id)->where('is_ordered',false)->count();
     }


      }
    public function home()
    {
       $itemsincart= $this->include();
        $products = Product::paginate(4);
        $categories = Category::orderBy('priority')->get();
        return view('welcome',compact('products','categories', 'itemsincart'));
    }

    public function shop()
    {
        $itemsincart= $this->include();
        $products = Product::all();
        $brands= Brand::all();
        $categories = Category::orderBy('priority')->get();
        return view('shop',compact('brands','categories','products','itemsincart'));
    }
    public function viewproduct(Product $product)
    {
        
        $itemsincart= $this->include();
        // $product = Product::find($id);
        $relatedproducts = Product::where('category_id',$product->category_id)->whereNot('id',$product->id)->get();
        $categories = Category::orderBy('priority')->get();
        return view('viewproduct',compact('product','categories', 'itemsincart','relatedproducts'));
    }


    public function userlogin()
    {
        $itemsincart= $this->include();
        $categories = Category::orderBy('priority')->get();
        return view('userlogin',compact('categories',"itemsincart"));
    }

    public function categoryproduct($id)
    {
        $brand = Brand::find($id);
        $category = Category::find($id);
        $itemsincart = $this->include();
        $products = Product::where('category_id',$id)->paginate(4);
        $categories = Category::orderBy('priority')->get();
        return view('categoryproduct',compact('products','categories','itemsincart','category','brand'));
    }


    public function brandproduct($id)
    {
        $brands = Brand::find($id);
        $category = Category::find($id);
        $itemsincart = $this->include();
        $products = Product::where('category_id',$id)->paginate(4);
        $categories = Category::orderBy('priority')->get();

        return view('brandproduct',compact('products','categories','itemsincart','brands','category'));
    }
   
  

    public function contact()
    {
       $itemsincart= $this->include();
        $products = Product::paginate(4);
        $categories = Category::orderBy('priority')->get();
        return view('contact',compact('products','categories', 'itemsincart'));
    }
    public function about()
    {
       $itemsincart= $this->include();
        $products = Product::paginate(4);
        $categories = Category::orderBy('priority')->get();
        return view('about',compact('products','categories', 'itemsincart'));
    }
    public function blog()
    {
       $itemsincart= $this->include();
        $products = Product::paginate(4);
        $categories = Category::orderBy('priority')->get();
        return view('blog',compact('products','categories', 'itemsincart'));
    }


        public function search(Request  $request){
            $itemsincart= $this->include(); 
            $searchText = $request->input('searchtext');
            $products = Product::where('name', 'like', '%' . $searchText . '%')
            ->orWhereHas('brand', function ($query) use ($searchText) {
                $query->where('name', 'like', '%' . $searchText . '%');
            })
            ->orWhereHas('category', function ($query) use ($searchText) {
                $query->where('name', 'like', '%' . $searchText . '%');
            })
            ->orWhere('price', 'like', '%' . $searchText . '%')
            ->with('brand', 'category')
            ->get();
    
            foreach ($products as $product) {
                $brandName= $product->brand->name;       // brnad's name for each product
                $categoryName = $product->category->name;   // Category's name for each product
            }
       
            return view('search',compact('products','itemsincart'));
          

        }
      

        public function userstore(Request $request){
            $data = $request->validate([
                'name'=>'required',
                'phone'=>'required',
                'address'=>'required',
                'email'=>'required',
                'password'=>['required','confirmed',Rules\password::defaults()],
            ]);
            $data['password']= Hash::make($data['password']);
            $data['role']='user';
            User::create($data);
            return redirect(route('userlogin'));
    }

  
    }  
