<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of StudentClassService
 *
 * @author singh
 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tax;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\CustomerLedger;
use App\Models\InvoiceHistory;
use App\Models\ProductInventory;
use App\Models\Customer;
class InvoiceService {
    //put your code here
    public static function save($request) {
        
   Log::debug(__CLASS__." :: ".__FUNCTION__." Called");
         #######################################################################
         # Invoice Details array recieving and saving in variables
         #######################################################################
           $invoice_date = $request->invoice_date;
           $delivery_note = htmlspecialchars(strip_tags($request->delivery_note));
           $delivery_note_date = $request->delivery_note_date;
           $buyers_order_no = htmlspecialchars(strip_tags($request->buyers_order_no));
           $buyers_order_date = $request->buyers_order_date;
           $dispatch_document_no = htmlspecialchars(strip_tags($request->dispatch_document_no));
           $dispatch_date = $request->dispatch_date;
           $dispatch_through = htmlspecialchars(strip_tags($request->dispatch_through));
           $destination = htmlspecialchars(strip_tags($request->destination));
           $delivery_terms = htmlspecialchars(strip_tags($request->delivery_terms));
            
            $subTotal = htmlspecialchars(strip_tags($request->subTotal));
            $total_tax_id = $request->total_tax_id;
            $total_tax_amount = $request->total_tax_amount;
            $service_charge_name = $request->service_charge_name;
            $service_charge_amount = $request->service_charge_amount;
            $service_charge_tax_name = $request->service_charge_tax_name;
            $service_charge_tax_percentage = $request->service_charge_tax_percentage;
            $service_charge_tax_amount = $request->service_charge_tax_amount;
            $grandTotal = htmlspecialchars(strip_tags($request->grandTotal));
        
        #######################################################################
        # Invoice Product Details array recieving and saving in variables
        #######################################################################
           
        $product_id = $request->id;
        $product_name = $request->product_name;
        $hsn_code = $request->hsn_code;
        $quantity = $request->quantity;
        $mrp = $request->rate;
        $product_price = $request->price;
        $tax_id = $request->tax_id;
        $tax_amount = $request->tax_amount;
        $amount = $request->amount;
        
           
            ##################### customer details parse and save in variables
            $customer_id = $request->customer_id;
            $customerData = Customer::find($customer_id);
            
            if(!isset($customerData->id)){
                session()->put('error',"Error While validating Customer !");
                  return Redirect::back();  
              }
            
            $c_name = $customerData->name;
            $c_gstin = $customerData->gstin;
            $c_mobile = $customerData->mobile;
            $c_address = $customerData->address;
            $c_city = '';
            $c_pincode = $customerData->pin_code;
            $c_state = $customerData->state->name;
            $c_country = $customerData->country->name;
             Log::debug(__CLASS__."::".__FUNCTION__." Customer data as customer id $customer_id buisness $c_name gst $c_gstin mobile $c_mobile");
            ############# ########## ###########
            # PAYMENT DETAILS RECIVE
            #
            $payment_method = $request->payment_method;
            $payment_description = $request->payment_description;
            $payment_txn_no = $request->payment_txn_no;
            $paid_amount = $request->paid_amount;
            $due_amount = $request->due_amount;
            
            #
            # Disdinct Product count on invoice 
            #
            $product_count = count($product_id);
            
        #
        #Generating Invlice Id 
        #
        $invoice_id = self::generateInvoiceId();
        Log::debug(__CLASS__."".__FUNCTION__." Invoice Id Generated as $invoice_id");
        
        if(empty($invoice_id)){
          session()->put('error',"Error While generating  invoice Id!");
            return Redirect::back();  
        }
        
        $server_net_quantity = 0;
        $server_subTotal = 0;
        $server_netAmount = 0;
        
        $server_service_charge_tax_amount = 0;
        $server_service_charge_tax_percent = $service_charge_tax_percentage;
        
        if($service_charge_amount> 0 && $service_charge_tax_percentage > 0){
            $server_service_charge_tax_percent = $server_service_charge_tax_percent/100;
            $server_service_charge_tax_amount = $server_service_charge_tax_percent * $service_charge_amount;
            Log::debug(__CLASS__."".__FUNCTION__." server extra tax amount $server_service_charge_tax_amount client amt $service_charge_tax_amount");
            if($server_service_charge_tax_amount != $service_charge_tax_amount){
                session()->put('error',"Extra charge tax amount miss match!");
            return Redirect::back();  
            }
            
        }
        
        
        
        
         $proceed = 'YES';
        $status = 'PENDING';
        $payment_status = 'CREDIT';
        $server_due_amt = 0;
        if(!empty($paid_amount) && $paid_amount > 0){
            if($paid_amount == $grandTotal){
                $payment_status = 'PAID';
                
            }elseif($paid_amount>$grandTotal){
                 session()->put('error',"Paid Amount Can not be grater than total Amount !");
            return Redirect::back();  
            }else{
                $payment_status = 'PARTIALLY PAID'; 
                $server_due_amt = $grandTotal - $paid_amount;
            }
        }
        
        try {
            DB::beginTransaction();
            
            $newInvoice = new Invoice;
            $newInvoice->invoice_id = $invoice_id;
            $newInvoice->invoice_date = $invoice_date;
            
            $newInvoice->customer_id = $customer_id;
            $newInvoice->c_name = $c_name;
            $newInvoice->c_mobile = $c_mobile;
            $newInvoice->c_address = $c_address;
            $newInvoice->c_city = $c_city;
            $newInvoice->c_pincode = $c_pincode;
            $newInvoice->c_state = $c_state;
            $newInvoice->c_country = $c_country;
            
            $newInvoice->delivery_note = $delivery_note;
            $newInvoice->delivery_note_date = $delivery_note_date;
            $newInvoice->delivery_terms = $delivery_terms;
            $newInvoice->buyer_order_no = $buyers_order_no;
            $newInvoice->buyer_order_date = $buyers_order_date;
            $newInvoice->dispatch_document_no = $dispatch_document_no;
            $newInvoice->dispatch_date = $dispatch_date;
            //if(!empty($dispatch_date)){
            //$newInvoice->dispatch_date = $dispatch_date;
           // }
            $newInvoice->dispatch_through = $dispatch_through;
            $newInvoice->destination = $destination;
            
            $newInvoice->total_quantity = 0;
            $newInvoice->product_count = count($product_id);
            $newInvoice->total_amount = $subTotal;
            
            $newInvoice->service_charge_name = $service_charge_name;
            $newInvoice->service_charge_amount = $service_charge_amount;
            $newInvoice->service_charge_tax_name = $service_charge_tax_name;
            $newInvoice->service_charge_tax_percentage = $service_charge_tax_percentage;
            $newInvoice->service_charge_tax_amount = $service_charge_tax_amount;
            
            if(!empty($total_tax_id) && $total_tax_amount){
                $tax_data1 = Tax::find($total_tax_id);
                $server_tax_percentage = $tax_data1->percentage;
                $server_tax_percentage = $server_tax_percentage/100;
            $server_total_tax_amount = $server_tax_percentage * $subTotal;
            Log::debug(__CLASS__."".__FUNCTION__." server total tax amount $server_total_tax_amount client amt $total_tax_amount");
            if($server_total_tax_amount != $total_tax_amount){
                session()->put('error',"tax amount miss match!");
            return Redirect::back();  
            }else{
            
            $newInvoice->tax_id = $total_tax_id;
            $newInvoice->tax_percentage = $tax_data1->percentage;
            $newInvoice->tax_amount = $total_tax_amount;
            }  
            }
            
            $newInvoice->total_tax_amount = $total_tax_amount+$service_charge_tax_amount;
            
            $newInvoice->payable_amount = $grandTotal;
            
            $newInvoice->paid_amount = $paid_amount;
            $newInvoice->due_amount = $due_amount;
            
            $newInvoice->status = $status;
            $newInvoice->payment_status = $payment_status;
            $newInvoice->created_by = auth()->user()->email;
            
           if(!$newInvoice->save()){
               $proceed = 'NO';
               Log::error(__CLASS__ . "::" . __FUNCTION__ . "Invoice Data Saving Failed for customer id $customer_id");
            
            session()->put('error', "Invoice Data Saving Failed Please try again !");
            return Redirect::back();
           }
           $netquantity = 0;$netamount=0;
           
           for($count=0; $count< count($product_id); $count++)
            {
               $rowAmt=0;
               
               
               $rowTaxAmt = 0;
               $rowTaxPercentage = 0;
               
               $productData = Product::find($product_id[$count]);
               $rowTaxID = 0;
               
               $rowAmt = $productData->mrp*$quantity[$count];
               if(!empty($tax_id[$productData->id])){
                   $rowTaxID = $tax_id[$productData->id];
                   
                   Log::debug(__CLASS__."::".__FUNCTION__." Product row tax id as $rowTaxID and product id as $productData->id");
                   
               $taxData = Tax::find($rowTaxID);
               $rowTaxPercentage = $taxData->percentage;
               $rowTaxPercentageTemp = $rowTaxPercentage/100;
               $rowTaxAmt = $rowAmt * $rowTaxPercentageTemp;
               }
               $rowAmt = $rowAmt+$rowTaxAmt;
               
               if($rowAmt != $amount[$count]){
                   $proceed = 'NO';
                   Log::error(__CLASS__."::".__FUNCTION__." invoice details row amount miss match form $amount[$count] and calculated $rowAmt");
                   break;
               }
               
               $netamount += $rowAmt; 
               $netquantity += $quantity[$count]; 
               if($quantity[$count] > $productData->quantity){
                  session()->put('error',"Product $productData->name quantity is less !"); 
                   $proceed = 'NO';
                    break;
               }
               if($proceed == 'YES'){
                   
               $invoiceDetail = new InvoiceDetail;
               $invoiceDetail->invoice_id = $newInvoice->id;
               $invoiceDetail->product_core_id = $productData->id;
               $invoiceDetail->hsn_code = $hsn_code[$count];
               $invoiceDetail->quantity = $quantity[$count];
               $invoiceDetail->mrp = $productData->mrp;
               $invoiceDetail->cost_price = $productData->cost_price;
               $invoiceDetail->total_amount = $productData->mrp*$quantity[$count];
               $invoiceDetail->tax_id = $rowTaxID;
               $invoiceDetail->tax_percentage = $rowTaxPercentage;
               $invoiceDetail->tax_amount = $rowTaxAmt;
               $invoiceDetail->net_amount = $rowAmt;
               $invoiceDetail->product_name = $productData->name;
               $invoiceDetail->product_id = $productData->product_id;
               $invoiceDetail->created_by = auth()->user()->id;
               
               $decrementQuantity = self::decrementProductQuantity($productData->id, $quantity[$count], "Decreasing quantity against order no $invoice_id");
                if(!$invoiceDetail->save() && !$decrementQuantity){
                  $proceed = 'NO';
                   Log::error(__CLASS__."::".__FUNCTION__." invoice details saving error at count $count for invoice id $invoice_id");
                   break;
                }
               
               }
            }
           
           $updateInvoice = Invoice::where('id',$newInvoice->id)->update(['total_quantity'=>$netquantity,'total_amount'=>$netamount]);
           
            if(!$updateInvoice)
            {
                Log::error(__CLASS__."::".__FUNCTION__." Invoice details saving failed ");
                session()->put("error","Invoice details saving failed ");
                $proceed = 'NO';
            }
             if(!self::saveInvoiceHistory($newInvoice->id, $status, "New Invoice Created with invoice no $invoice_id and payment status $payment_status")){
                 Log::error(__CLASS__."::".__FUNCTION__." Invoice history saving failed ");
                session()->put("error","Invoice history saving failed ");
                $proceed = 'NO';
                }
                
                if(!empty($paid_amount) && $paid_amount > 0){
                  $recipt_no =  self::insertCustomerLedger($invoice_id, $customer_id, $paid_amount, 'IN', $payment_method, 'PAID', $payment_txn_no,$payment_description);
                }
                
            
            if($proceed=='YES'){
                DB::commit();
                Log::debug(__CLASS__."::".__FUNCTION__." Invoice details saved successfully");
                    session()->put("success","Invoice details saved successfully ");
                if($recipt_no && !empty($recipt_no)){
                    //return redirect()->route('admin.invoice.payment.reciept',['id'=>$recipt_no]);
                }
                
                 //return redirect()->route('admin.invoice.print',['id'=>$invoice_id]);
            }
            
            

            
        } catch (\Exception $e) {
           
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            
            session()->put('error', "Exception While Data Storing Please try again !");
           return Redirect::back();
        }



       return Redirect::back();
    }
    
    public static function insertCustomerLedger($invoice_id,$customer_id,$total_amount,$payment_type,$payment_mode,$status,$transaction_no,$description=null) {
        
        try{
            $reciept_no = self::generateRecieptNo();
            if(empty($reciept_no)){
                return false;
            }
            $newCustomerLedger = new CustomerLedger;
            $newCustomerLedger->invoice_id = $invoice_id;
            $newCustomerLedger->customer_id = $customer_id;
            $newCustomerLedger->reciept_no = $reciept_no;
            $newCustomerLedger->total_amount = $total_amount;
            $newCustomerLedger->description = $description;
            $newCustomerLedger->payment_type = $payment_type;
            $newCustomerLedger->payment_mode = $payment_mode;
            $newCustomerLedger->transaction_no = $transaction_no;
            $newCustomerLedger->status = $status;
            $newCustomerLedger->created_by = auth()->user()->email;
            if($newCustomerLedger->save()){
                return $reciept_no;
            }
        } catch (\Exception $e){
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
        }
        return false;
        
    }

    public static function update($request) {

        $id = $request->input('id');
        $name = htmlspecialchars(strip_tags($request->input('name')));
        $percentage = htmlspecialchars(strip_tags($request->input('percentage')));

        try {
            DB::beginTransaction();
            


            $course = Tax::find($id);
            $course->name = $name;
            $course->percentage = $percentage;
            $course->updated_by = auth()->user()->email;
            if ($course->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
               
                return true;
            } else {
                DB::rollback();
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
               
                session()->put('error', "Error Occured While Data Storing Please try again !");
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
           
            session()->put('error', "Exception While Data Storing Please try again !");
            return false;
        }



        return false;
    }
    
    
    
    //generate order id
    protected static function generateInvoiceId($count=0) {
        $code = "";
        
            Log::debug(__CLASS__."::".__FUNCTION__." called");
            $data = Invoice::whereYear('created_at', date('Y'))->count();

                $code = (($count+$data)+1)."/GST/".(date('m'))."/".(date('y'))."-".(date('y')+1);
			
			
			$checkExist = $data = Invoice::where('invoice_id', $code)->whereYear('created_at', date('Y'))->count();
			
			if($checkExist > 0){
				generateInvoiceId($checkExist);
			}
         
        return $code;
    }
    
    //generate order id
    protected static function generateRecieptNo() {
        $code = "";
        do {
            $code = 'R-'.substr(uniqid(mt_rand(), true) , 0, 10);
            $data = CustomerLedger::where('reciept_no', $code)->count();
        } while ($data > 0);
        return $code;
    }
    // Decement Product Quantity
    protected static function decrementProductQuantity($product_id,$quantity,$description) {
        $refillproduct = new ProductInventory;
            $refillproduct->product_id = $product_id;
            $refillproduct->quantity = $quantity;
            $refillproduct->description = $description;
            $refillproduct->type = 'OUT';
            
            $refillproduct->created_by = auth()->user()->email;
            

            if($refillproduct->save())
            {
               $updateQty = Product::where('id',$product_id)->decrement('quantity',$quantity);
               if(!$updateQty){
                   Log::error(__CLASS__."::".__FUNCTION__."Product Quantity Update failed for Product ");
                return false;
               }else{ 
                   Log::debug(__CLASS__."::".__FUNCTION__." Product dcemented successfully In Product ");
                   return true;
               }   
            }else{
                Log::error(__CLASS__."::".__FUNCTION__." Product dcemented failed for Product ");
                return false;
            } 
            return false;
        
    }
    
    //Increment Product Quantity
    protected static function incrementProductQuantity($product_id,$quantity,$description) {
         $refillproduct = new ProductInventory;
            $refillproduct->product_id = $product_id;
            $refillproduct->quantity = $quantity;
            $refillproduct->description = $description;
            $refillproduct->type = 'IN';
            
            $refillproduct->created_by = auth()->user()->email;
            

            if($refillproduct->save())
            {
               $updateQty = Product::where('id',$product_id)->increment('quantity',$quantity);
               if(!$updateQty){
                   Log::error(__CLASS__."::".__FUNCTION__."Product Quantity Update failed for Product ");
                return false;
               }else{ 
                   Log::debug(__CLASS__."::".__FUNCTION__." Product Refilled successfully In Product ");
                   return true;
               }   
            }else{
                Log::error(__CLASS__."::".__FUNCTION__." Product Refilling failed for Product ");
                return false;
            } 
            return false;
    }
    
    protected function reverseStock($invoice_id) {
        $orderProduct = InvoiceDetail::where('invoice_id',$invoice_id)->get();
        
        if(count($orderProduct) > 0){
            $proceed = 'YES';
            foreach ($orderProduct as $value){
                if(!self::incrementProductQuantity($value->product_core_id, $value->quantity, "On invoice $invoice_id Incrementing product quantity - $value->quantity")){
                    $proceed = 'NO';
                    break;
                }
            }
            if($proceed == 'YES'){
                return true;
            }
        }
        return false;
    }
    
    
    public static function deliveredUpdateProductCount($order_id) {
        $orderProduct = InvoiceDetail::where('invoice_id',$order_id)->get();
        
        if(count($orderProduct) > 0){
            $proceed = 'YES';
            foreach ($orderProduct as $value){
                $updateQty = Product::where('id',$value->product_core_id)->increment('ordered_qty',$value->quantity);
               if(!$updateQty){
                   Log::error(__CLASS__."::".__FUNCTION__."Invoice Product Ordred Quantity Update failed for Product id $value->product_core_id");
                 $proceed = 'NO';
                    break;
               }
            }
            if($proceed == 'YES'){
                return true;
            }
        }
        return false;
    }
    
    public static function saveInvoiceHistory($order_id,$status,$description) {
         $saveHistory = new InvoiceHistory();
            $saveHistory->invoice_id = $order_id;
            $saveHistory->status = $status;
            $saveHistory->description = $description;
            
            $saveHistory->updated_by = auth()->user()->email;
            

            if($saveHistory->save())
            {
                   Log::debug(__CLASS__."::".__FUNCTION__." Invoice History saved successfully with invoice id $order_id and status $status ");
                   return true;
            }else{
                Log::error(__CLASS__."::".__FUNCTION__." Invoice History saving failed  with invoice id $order_id and status $status");
                return false;
            } 
            return false;
    }
    
    
    
}