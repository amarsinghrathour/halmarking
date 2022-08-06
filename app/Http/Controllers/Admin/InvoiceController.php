<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tax;
use App\Services\Admin\InvoiceService;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Log;
use DB;
use App\Models\Customer;
use Illuminate\Support\Facades\Redirect;
class InvoiceController extends Controller
{
    public function __construct()
    {
        //Check Auth
        $this->middleware('auth');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
       // $this->middleware('session');
        $this->middleware('permission:invoice-list|invoice-create|invoice-edit|invoice-delete', ['only' => ['index','save','get_purchase_item_details_ajax']]);
         $this->middleware('permission:invoice-create', ['only' => ['add','save']]);
         $this->middleware('permission:invoice-edit', ['only' => ['edit','update']]);
    }
    
     public function index(Request $request) {
        
            $invoiceArray = Invoice::where('status','!=','DELETED')->whereYear('created_at', date('Y'))->orderBy('id','desc')->get();
       
        
        return view('admin.invoice.index')
            ->with('title', 'Invoices')
            ->with('invoiceArray', $invoiceArray)
                ;
    }
    
    
    public function viewInvoice($id) {
        $orderData = Invoice::find($id);
        $orderProducts = InvoiceDetail::where('invoice_id',$orderData->invoice_id)->get();
        return view('admin.invoice.invoiceDetails')
            ->with('title', 'View Invoice Details')
            ->with('orderData', $orderData)
            ->with('orderProduct', $orderProducts)
                ;
    }
    
    public function invoice($id) {
        $orderData = Invoice::find($id);
        $orderProducts = InvoiceDetail::where('invoice_id',$orderData->invoice_id)->get();
        return view('admin.invoice.invoice')
            ->with('title', 'Invoice')
            ->with('orderData', $orderData)
            ->with('orderProduct', $orderProducts)
                ;
    }
    
    public function add(Request $request) {
        $productArray = Product::where('status','ACTIVE')->orderBy('id','desc')->get();
        $customerArray = Customer::where('status','ACTIVE')->orderBy('id','desc')->get();
        $taxArray = Tax::where('status','ACTIVE')->orderBy('id','desc')->get();
        return view('admin.invoice.add')
            ->with('title', 'Invoice Create')
            ->with('productArray', $productArray)
            ->with('customerArray', $customerArray)
            ->with('taxArray', $taxArray)
                ;
    }
    
    
    public function saveInvoice(Request $request) {
        Log::debug(__CLASS__." :: ".__FUNCTION__." Called");
        $this->validate(request(), [
            'invoice_date' => 'bail|required|date',
            'delivery_note' => 'nullable',
            'delivery_note_date' => 'nullable|date',
            'buyers_order_no' => 'bail|required',
            'buyers_order_date' => 'bail|required|date',
            'dispatch_document_no' => 'nullable',
            'dispatch_date' => 'nullable|date',
            'dispatch_through' => 'nullable',
            'destination' => 'nullable',
            'delivery_terms' => 'nullable',
            'subTotal' => 'bail|required|numeric|gt:0',
            'grandTotal' => 'bail|required|numeric|gt:0',
            'product_name.*' => 'bail|required',
            'id.*' => 'bail|required',
            'hsn_code.*' => 'bail|required',
            'tax_id.*' => 'nullable',
            'rate.*' => 'bail|required',
            'price.*' => 'bail|required',
            'quantity.*' => 'bail|required',
            'tax_amount.*' => 'nullable',
            'amount.*' => 'bail|required',
            'total_tax_id' => 'nullable',
            'total_tax_amount' => 'nullable',
            'service_charge_name' => 'nullable',
            'service_charge_amount' => 'nullable',
            'service_charge_tax_name' => 'nullable',
            'service_charge_tax_percentage' => 'nullable',
            'service_charge_tax_amount' => 'nullable',
            'customer_id' => 'bail|required',
            'payment_method' => 'nullable',
            'payment_description' => 'nullable',
            'payment_txn_no' => 'nullable',
            'paid_amount' => 'nullable',
            'due_amount' => 'nullable',
        ]);
        
       return InvoiceService::save($request);
        
    }
    
    /*
     * Get Product details row for purchasing invoice
     */
    public function get_purchase_item_details_ajax(Request $request)
    {
        $id = $request->input('id');
        $rowType = $request->input('type');
        Log::debug(__CLASS__." :: ".__FUNCTION__." Called");
        $resp = "FAIL";
        try
        {
            if($id!="")
            {
                Log::debug("Product is not empty, lets validate");
                if($rowType == "add")
                {
                    Log::debug("Product purchase  add method is called with id $id");
                    Log::debug(session()->get('itemCartArray'));
                    if (in_array($id, session()->get('itemCartArray'))) 
                    {
                       Log::error("Product '$id' already added in cart");
                        return 'ALREADY_ADDED';
                    }
                    else
                    {
                        try {
                            Log::debug("Connecting with DB ");
                                $resultArray = Product::where('status','!=','DELETED')->where('id',$id)->first();
                                
                                    Log::debug("Qury executed , getting data ");
                                    if($resultArray->id)
                                    {
                                        if($resultArray->quantity < 1)
                                        {
                                            Log::error("No Out of stock Product ID $id");
                                            return 'OUT_OF_STOCK';
                                        }
                                        $randNo = rand(10000, 99999);
                                        $obj = $resultArray;
                                            
                                                
                                                session()->push('itemCartArray', $id);
                                                Log::debug("Data found, preparing response ");
                                                
                                                $taxList = Tax::where('status','ACTIVE')->get();
                                                $taxSelect = "<select name=\"tax_id[".$id."]\" onchange=\"calculateRow(this)\" class=\"form-control select2 taxt-value\" style=\"max-width: 100%;border-radius: 4px\">";
                                                $taxSelect.="<option value=''>Select</option>";
                                                foreach($taxList as $value){
                                                   $taxSelect.="<option value=\"".$value->id."\" data-percent=\"".$value->percentage."\">".$value->name." ".$value->percentage." %</option>"; 
                                                }
                                                $taxSelect.="</select>";
                                       $product_data="";
                                                $product_data.= "<tr class=\"itemDiv\" id=\"itemDiv\">\n" .
                        "                                                                                    <td style=\"text-align:center\">\n" .
                        "                                                                                        <button class=\"btn btn-danger btn-sm deleteButton\" title=\"Remove Item\" onclick=\"removeItem('$id','$randNo',this)\" id=".$randNo."><i class=\"fa fa-minus\">&nbsp;</i></button>\n" .
                        "                                                                                    </td>\n" .                            
                        "                                                                                    <td>\n" .
                        "                                                                                        <input type=\"text\" style=\"max-width: 90%;border-radius: 4px\" class=\"form-control input-sm\" name=\"product_name[]\" value=\"".$obj->name."\" required=\"\" readonly=\"\"/>\n" .                            
                        "                                                                                    </td>\n" . 
                        "                                                                                    <td>\n" .
                        "                                                                                        <input type=\"text\" readonly='' autocomplete='off' class=\"form-control input-sm\" style=\"max-width: 100%;border-radius: 4px\" name=\"hsn_code[]\" value=\"".$obj->hsn_code."\" placeholder=\" \" required=\"\"/> \n" .                            
                        "                                                                                    </td>\n" . 
                        "                                                                                     <td>\n" .
                        "                                                                                        ".$taxSelect."\n" .                            
                        "                                                                                    </td>\n" . 
                        "                                                                                    <td class=\"\">\n" .
                        "                                                                                        <input type=\"number\" autocomplete='off' class=\"form-control input-sm rate\" min=\"".$obj->cost_price."\" onchange=\"calculateRow(this)\" onkeyup=\"calculateRow(this)\" onblur=\"calculateRow(this)\" style=\"max-width: 100%;border-radius: 4px\" name=\"rate[]\" value=\"".$obj->mrp."\" placeholder=\" \" required=\"\"/> \n" .
                        "                                                                                    </td>\n" .
                        "                                                                                    <td class=\"\">\n" .
                        "                                                                                        <input type=\"number\" class=\"form-control input-sm price\" readonly='' onchange=\"calculateRow(this)\" onkeyup=\"calculateRow(this)\" onblur=\"calculateRow(this)\" style=\"max-width: 100%;border-radius: 4px\" name=\"price[]\" value=\"".$obj->cost_price."\"  placeholder=\" \" required=\"\"/> \n" .
                        "                                                                                    </td>\n" .
                        "                                                                                    <td class=\"\">\n" .
                        "                                                                                        <p>$obj->quantity</p>" .
                        "                                                                                    </td>\n" .
                        "                                                                                    <td class=\"\">\n" .
                        "                                                                                        <input type=\"number\" autocomplete='off' class=\"form-control input-sm quantity\" min='1' max=\"".$obj->quantity."\" onchange=\"calculateRow(this)\" onkeyup=\"calculateRow(this)\" onblur=\"calculateRow(this)\" style=\"max-width: 100%;border-radius: 4px\" name=\"quantity[]\" value='0' placeholder=\"Qty \" required=\"\"/> \n" .
                        "                                                                                    </td>\n" .
                        "                                                                                        <input type=\"hidden\" name=\"id[]\" value=\"".$obj->id."\" />\n" .                            
                        "                                                                                    <td class=\"\">\n" .
                        "                                                                                       <input type=\"number\" class=\"form-control input-sm tax_amount\"  readonly=\"\" name=\"tax_amount[".$id."]\" value=\"0\" style=\"max-width: 100%;border-radius: 4px\" />\n" .
                        "                                                                                    </td>\n".
                        "                                                                                    <td class=\"\">\n" .
                        "                                                                                       <input type=\"number\" class=\"form-control input-sm amount\"  readonly=\"\" name=\"amount[]\" value=\"".($obj->mrp*1)."\" style=\"max-width: 100%;border-radius: 4px\" required=\"\" />\n" .
                        "                                                                                    </td>\n";
                                                
                                                    $product_data.= "</tr>";
                                                    return $product_data;
                                                
                                                ?>
                                                
                                                <?php
                                    }
                                    else
                                    {
                                        Log::error("No Data found in db with Product ID $id");
                                        return 'NOT_FOUND';
                                    }
                                
                        } catch (Exception $exc) {
                            Log::error("Error $exc, while validating $id");
                            return 'ERROR';
                        }
                    }
                }
                else
                {
                    if(in_array($id, session()->get('itemCartArray'))) 
                    {
                        $products = session()->get('itemCartArray'); // Get the array
                        //unset($product[$index]);
                        if(($key = array_search($id, $products)) !== false) {
                            unset($products[$key]);
                        }
                        session()->put('itemCartArray', $products);
                        Log::info("Item $id has been successfully removed from cart");
                        return 'REMOVED';
                    }
                    else
                    {
                        Log::info("Item $id not found in array, so removal not required from cart");
                    }
                }

            }
            else
            {
                Log::error("Item entry not found with Product ID = $id");
                return "ERROR";
            }
        } catch (PDOException $exc) {
           Log::error(__CLASS__." > ".__FUNCTION__." PDO Exception : ".$exc->getMessage());
        }
        
        return $resp;
    }
    
    
    
    
    
}
