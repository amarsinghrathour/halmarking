<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\WebPage;
use App\Models\WebMenu;
use Illuminate\Support\Facades\Log;
use App\Models\WebAlbum;
use App\Models\WebAlbumImage;
use App\Models\NoticeBoard;
use App\Models\TcManagement;
use App\Models\Alumani;
use App\Models\UpcomingEvent;
use App\Models\RecentActivity;
use App\Models\Enquiry;
use DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Service;
class HomeController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($all = '/') {
        $menuUrl = $all;
        Log::debug(__CLASS__ . "::" . __FUNCTION__ . " Get page url as $menuUrl");
        $webMenuDetail = WebMenu::where('link', $menuUrl)->where('status', 'ACTIVE')->first();
        if (isset($webMenuDetail->page_id) && $webMenuDetail->type==2) {
            $webPageDetail = WebPage::where('id', $webMenuDetail->page_id)->where('status', 'ACTIVE')->first();
            if (!isset($webMenuDetail->page_id)) {
                abort(404, 'Page not found.');
            }
            return view('web.page')
                            ->with('title', $webMenuDetail->name)
                            ->with('menu_url', $menuUrl)
                            ->with('menu_detail', $webMenuDetail)
                            ->with('pageDetail', $webPageDetail)

            ;
        } elseif(isset($webMenuDetail->type) && $webMenuDetail->type==1) {
            $webPageDetail = WebPage::where('url', $webMenuDetail->link)->where('status', 'ACTIVE')->first();
            if (!isset($webPageDetail->id)) {
                abort(404, 'Page not found.');
            }
            return view('web.page')
                            ->with('title', $webMenuDetail->name)
                            ->with('menu_url', $menuUrl)
                            ->with('menu_detail', $webMenuDetail)
                            ->with('pageDetail', $webPageDetail)

            ;
        }elseif($menuUrl){
            $webPageDetail = WebPage::where('url', $menuUrl)->where('status', 'ACTIVE')->first();
            if (!isset($webPageDetail->id)) {
                abort(404, 'Page not found.');
            }
            return view('web.page')
                            ->with('title', $webPageDetail->title)
                            ->with('menu_url', $menuUrl)
                            ->with('menu_detail', $webPageDetail)
                            ->with('pageDetail', $webPageDetail)

            ;
        }
        else {
            abort(404, 'Page not found.');
        }
    }

    public function galleryView($slug) {
        $album = WebAlbum::where('url', $slug)->first();
        if (!isset($album->id)) {
            session()->flash('error', 'No Data Found !');
            return redirect()->back();
        }
        $albumsImageArray = WebAlbumImage::where('album_id', $album->id)->where('status', '!=', 'DELETED')->orderBy('sort_order')->orderBy('id', 'desc')->get();

        return view('web.gallery.view')
                        ->with('title', 'Gallery View')
                        ->with('album', $album)
                        ->with('albumsImageArray', $albumsImageArray);
    }
    
    public function noticeView($slug) {
        $noticeView = NoticeBoard::where('url', $slug)->first();

        return view('web.notice_board.view')
                        ->with('title', $noticeView->title)
                        ->with('noticeView', $noticeView)
                ;
    }
    public function upcomingEventView($slug) {
        $data = UpcomingEvent::where('url', $slug)->first();

        return view('web.events.view')
                        ->with('title', $data->title)
                        ->with('data', $data)
                ;
    }
    public function recentActivityView($slug) {
        $data = RecentActivity::where('url', $slug)->first();

        return view('web.activity.view')
                        ->with('title', $data->title)
                        ->with('data', $data)
                ;
    }
    public function serviceView($slug) {
        $data = Service::where('url', $slug)->first();

        return view('web.services.view')
                        ->with('title', $data->title)
                        ->with('data', $data)
                ;
    }
    
    
    public function tcView(Request $request) {
        
        $this->validate($request,[
         'tc_number'=>'required',
         'issue_date'=>'required|date'
        ]);
        $tc_number = $request->input('tc_number');
        $issue_date = $request->input('issue_date');
        $data = TcManagement::where('tc_number', $tc_number)->whereDate('issue_date',$issue_date)->first();
        return view('web.tc.view')
                        ->with('title', 'View Tc')
                        ->with('data', $data)
                ;
    }

    public function enquiryFormSave(Request $request) {

        Log::debug(__CLASS__ . "::" . __FUNCTION__ . " Called " . json_encode($request->all()));
        try {
            $enquiry = new Enquiry;
            $enquiry->name = htmlspecialchars(strip_tags($request->input('name')));
            $enquiry->email = htmlspecialchars(strip_tags($request->input('email')));
            $enquiry->mobile = htmlspecialchars(strip_tags($request->input('mobile')));
            $enquiry->subject = htmlspecialchars(strip_tags($request->input('subject')));
            $enquiry->message = htmlspecialchars(strip_tags($request->input('message')));
            $enquiry->created_by = htmlspecialchars(strip_tags($request->input('email')));
            
            if ($enquiry->save()) {

                return 'success';
            }
        } catch (\Exception $e) {
            Log::error(__CLASS__ . "::" . __FUNCTION__ . " Exception Occured " . $e->getMessage());
        }
        return 'error';
    }

    
    public function alumaniFormSave(Request $request) {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'designation' => 'nullable',
            'phone' => 'bail|required|numeric|unique:alumanis,mobile',
            'year_passout' => 'bail|required|numeric',
            'passout_class' => 'bail|required',
            'file' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        $imageDb = '';
        try {
            DB::beginTransaction();
            if($request->hasFile('file')){
                $imageDb = uploadImage($request->file('file'), 'alumani',"alumani");
            }
            
            if(!$imageDb){
                session()->put('error',"Error while uploading Image !");
                return false;
            }
            
            $alumani = new Alumani;
            $alumani->name = htmlspecialchars(strip_tags($request->input('name')));
            $alumani->designation = htmlspecialchars(strip_tags($request->input('designation')));
            $alumani->email = htmlspecialchars(strip_tags($request->input('email')));
            $alumani->mobile = htmlspecialchars(strip_tags($request->input('phone')));
            $alumani->pass_out_year = htmlspecialchars(strip_tags($request->input('year_passout')));
            $alumani->pass_out_class = htmlspecialchars(strip_tags($request->input('passout_class')));
            $alumani->image = $imageDb;
            $alumani->created_by = htmlspecialchars(strip_tags($request->input('email')));
            
            if($alumani->save()){
             session()->put('success',"Data Saved Successfully");
              DB::commit();
             
            }else{
                DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__."Eror occured ");
            if(!empty($imageDb) && file_exists(public_path().'/'.$imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Error Occured While Data Storing Please try again !");
           
            }
        } catch (\Exception $e) {
            Log::error(__CLASS__ . "::" . __FUNCTION__ . " Exception Occured " . $e->getMessage());
            if(!empty($imageDb) && file_exists(public_path().'/'.$imageDb)){
                unlink(public_path().'/'.$imageDb);
            }
            session()->put('error',"Exception While Data Storing Please try again !");
        }
        return redirect()->back();
    }
    
     public function shop(Request $request) {
        
        $query = '';
        $category = '';
        $category_url = '';
        $manufacturer = '';
        if($request->filled('query')){
            Log::debug("recieving Query");
            $query = htmlspecialchars($request->input('query'));
        }
        if($request->filled('category')){
            Log::debug("recieving Category");
            $category = htmlspecialchars($request->input('category'));
        }
        if($request->filled('category_url')){
            Log::debug("recieving category_url");
            $category_url = htmlspecialchars($request->input('category_url'));
          $category_data =  Category::where('slug',$category_url)->first();
          
          if(isset($category_data->id)){
              $category = $category_data->id;
          }
        }
        if($request->filled('brand')){
            Log::debug("recieving brand");
            $manufacturer = htmlspecialchars($request->input('brand'));
        }
        Log::debug(__CLASS__."::".__FUNCTION__."called");
        $productData = Product::where('status','ACTIVE');
        if(!empty($query)){
            Log::debug("under Query");
            $productData->where('name','LIKE',"%$query%")->orWhere('product_id','LIKE',"%$query%");
        }
        else if(!empty($category)){
            Log::debug("under Category");
            $productData->where('category_id',$category)->orWhere('sub_category_id',$category);
        }
        else if(!empty($manufacturer)){
            Log::debug("under Manufacturer");
            $productData->where('manufacturer_id',$manufacturer);
        }
         $productListArray =  $productData->orderBy('id','desc')->paginate(20); 
        
        
        
        return view('web.shop.list')
            ->with('title', 'Shop')
            ->with('productList', $productListArray);
    }
    
    public function blogByCategory($slug)
    {
        $categoryData = Category::where('status','!=','DELETED')->where('slug',$slug)->first();
        $ids = $categoryData->id;
        $similarProductData = WebPage::where('status','ACTIVE')->where('category_id',$ids)->orWhere('sub_category_id',$ids)->where('type','BLOG')->orderBy('id','desc')->paginate(20);
        
        return view('web.blog.list')
            ->with('title', 'Blog')
            ->with('categoryData', $categoryData)
            ->with('blogList', $similarProductData)
                ;
    }
    
    public function blog(Request $request) {
        
        $query = '';
        $category = '';
        $category_url = '';
        if($request->filled('slug')){
            Log::debug("recieving Query");
            $query = htmlspecialchars($request->input('query'));
        }
        
        if($request->filled('category_url')){
            Log::debug("recieving category_url");
            $category_url = htmlspecialchars($request->input('category_url'));
          $category_data =  Category::where('slug',$category_url)->first();
          
          if(isset($category_data->id)){
              $category = $category_data->id;
          }
        }
        
        Log::debug(__CLASS__."::".__FUNCTION__."called");
        $productData = WebPage::where('status','ACTIVE')->where('type','BLOG');
        if(!empty($query)){
            Log::debug("under Query");
            $productData->where('title','LIKE',"%$query%")->orWhere('description','LIKE',"%$query%");
        }
        else if(!empty($category)){
            Log::debug("under Category");
            $productData->where('category_id',$category)->orWhere('sub_category_id',$category);
        }
        
         $blogListArray =  $productData->orderBy('id','desc')->paginate(20); 
        
        
        
        return view('web.blog.list')
            ->with('title', 'Blog')
            ->with('blogList', $blogListArray);
    }
    
}
