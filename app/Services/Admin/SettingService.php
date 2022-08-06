<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingService
 *
 * @author singh
 */

namespace App\Services\Admin;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
class SettingService {
    //put your code here
    
    public static function update($request) {
        DB::beginTransaction();
      $header_logo = '';
      $header_logo_diamond = '';
      $header_logo_old = '';
      $header_logo_old_diamond = '';
      $home_about_image = '';
      $home_about_image_old = '';
      $footer_logo = '';
      $footer_logo_old = '';
      $favicon_old = '';
      $favicon = '';
      $home_video_image = '';
      $home_video_image_old = '';
        
        try{
            
            $proceed = 'Yes';
            
              
              if(!empty($request->input('buisness_name'))){
                  $extra['name'] = 'Buisness Name';
                  $extra['value'] = $request->input('buisness_name');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'buisness_name'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('affiliation_no'))){
                  $extra['name'] = 'Affiliation No';
                  $extra['value'] = $request->input('affiliation_no');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'affiliation_no'], $extra)){
                      $proceed = 'No';
                  }
              }
             
              if(!empty($request->input('contact_address'))){
                  $extra['name'] = 'contact address';
                  $extra['value'] = $request->input('contact_address');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'contact_address'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('school_code'))){
                  $extra['name'] = 'School code';
                  $extra['value'] = $request->input('school_code');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'school_code'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('contact_pin_code'))){
                  $extra['name'] = 'Contact Pin Code';
                  $extra['value'] = $request->input('contact_pin_code');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'contact_pin_code'], $extra)){
                      $proceed = 'No';
                  }
              }
              
              if(!empty($request->input('contact_phone'))){
                  $extra['name'] = 'contact phone';
                  $extra['value'] = $request->input('contact_phone');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'contact_phone'], $extra)){
                      $proceed = 'No';
                  }
              }
              
              if(!empty($request->input('fax'))){
                  $extra['name'] = 'contact fax';
                  $extra['value'] = $request->input('fax');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'fax'], $extra)){
                      $proceed = 'No';
                  }
              }
              
              if(!empty($request->input('contact_email'))){
                  $extra['name'] = 'contact email';
                  $extra['value'] = $request->input('contact_email');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'contact_email'], $extra)){
                      $proceed = 'No';
                  }
              }
              
              if(!empty($request->input('website'))){
                  $extra['name'] = 'website';
                  $extra['value'] = $request->input('website');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'website'], $extra)){
                      $proceed = 'No';
                  }
              }
              
              if(!empty($request->input('facebook'))){
                  $extra['name'] = 'facebook';
                  $extra['value'] = $request->input('facebook');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'facebook'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('whatsapp'))){
                  $extra['name'] = 'whatsapp';
                  $extra['value'] = $request->input('whatsapp');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'whatsapp'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('twitter'))){
                  $extra['name'] = 'twitter';
                  $extra['value'] = $request->input('twitter');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'twitter'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('twitter_screen_name'))){
                  $extra['name'] = 'twitter screen name';
                  $extra['value'] = $request->input('twitter_screen_name');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'twitter_screen_name'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('twitter_max_tweets'))){
                  $extra['name'] = 'twitter max tweets';
                  $extra['value'] = $request->input('twitter_max_tweets');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'twitter_max_tweets'], $extra)){
                      $proceed = 'No';
                  }
              }
              
              if(!empty($request->input('instagram'))){
                  $extra['name'] = 'instagram';
                  $extra['value'] = $request->input('instagram');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'instagram'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('linkedin'))){
                  $extra['name'] = 'linkedin';
                  $extra['value'] = $request->input('linkedin');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'linkedin'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('youtube'))){
                  $extra['name'] = 'youtube';
                  $extra['value'] = $request->input('youtube');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'youtube'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('invoice_declaration'))){
                  $extra['name'] = 'invoice declaration';
                  $extra['value'] = $request->input('invoice_declaration');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'invoice_declaration'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('map_url'))){
                  $extra['name'] = 'map url';
                  $extra['value'] = $request->input('map_url');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'map_url'], $extra)){
                      $proceed = 'No';
                  }
              }
              
              if(!empty($request->input('footer_short_text'))){
                  $extra['name'] = 'footer short text';
                  $extra['value'] = $request->input('footer_short_text');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'footer_short_text'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('no_of_students'))){
                  $extra['name'] = 'no of students';
                  $extra['value'] = $request->input('no_of_students');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'no_of_students'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('no_of_customers'))){
                  $extra['name'] = 'no of happy customers';
                  $extra['value'] = $request->input('no_of_customers');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'no_of_customers'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('no_of_teacher'))){
                  $extra['name'] = 'no of teacher';
                  $extra['value'] = $request->input('no_of_teacher');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'no_of_teacher'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('no_of_awards'))){
                  $extra['name'] = 'no of awards';
                  $extra['value'] = $request->input('no_of_awards');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'no_of_awards'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('no_of_trophy'))){
                  $extra['name'] = 'no of trophy';
                  $extra['value'] = $request->input('no_of_trophy');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'no_of_trophy'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('opening_hours'))){
                  $extra['name'] = 'opening hours';
                  $extra['value'] = $request->input('opening_hours');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'opening_hours'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('welcome_marquee'))){
                  $extra['name'] = 'welcome marquee';
                  $extra['value'] = $request->input('welcome_marquee');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'welcome_marquee'], $extra)){
                      $proceed = 'No';
                  }
              }
              
              if(!empty($request->input('copyright'))){
                  $extra['name'] = 'copyright';
                  $extra['value'] = $request->input('copyright');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'copyright'], $extra)){
                      $proceed = 'No';
                  }
              }
              
              if(!empty($request->input('custom_css_codes'))){
                  $extra['name'] = 'custom css codes';
                  $extra['value'] = $request->input('custom_css_codes');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'custom_css_codes'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('custom_js_codes'))){
                  $extra['name'] = 'custom js codes';
                  $extra['value'] = $request->input('custom_js_codes');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'custom_js_codes'], $extra)){
                      $proceed = 'No';
                  }
              }
              if($request->hasFile('header_logo_diamond')){
                $header_logo_diamond = uploadImage($request->file('header_logo_diamond'), 'logo','header_logo_diamond');
                $header_logo_old_diamond = SetttingValue('header_logo_diamond');
                if ($header_logo_diamond && !empty($header_logo_diamond)) {
                    $extra['name'] = 'header logo diamond';
                    $extra['value'] = $header_logo_diamond;
                    $extra['created_by'] = Auth::user()->email;
                    $extra['updated_by'] = Auth::user()->email;

                    if (!Setting::updateOrCreate(['key' => 'header_logo_diamond'], $extra)) {
                        $proceed = 'No';
                    }
                }
            }
              if($request->hasFile('header_logo')){
                $header_logo = uploadImage($request->file('header_logo'), 'logo','header_logo');
                $header_logo_old = SetttingValue('header_logo');
                if ($header_logo && !empty($header_logo)) {
                    $extra['name'] = 'header logo';
                    $extra['value'] = $header_logo;
                    $extra['created_by'] = Auth::user()->email;
                    $extra['updated_by'] = Auth::user()->email;

                    if (!Setting::updateOrCreate(['key' => 'header_logo'], $extra)) {
                        $proceed = 'No';
                    }
                }
            }
            
              if($request->hasFile('footer_logo')){
                $footer_logo = uploadImage($request->file('footer_logo'), 'logo','footer_logo');
                $footer_logo_old = SetttingValue('footer_logo');
                if ($footer_logo && !empty($footer_logo)) {
                    $extra['name'] = 'footer logo';
                    $extra['value'] = $footer_logo;
                    $extra['created_by'] = Auth::user()->email;
                    $extra['updated_by'] = Auth::user()->email;

                    if (!Setting::updateOrCreate(['key' => 'footer_logo'], $extra)) {
                        $proceed = 'No';
                    }
                }
            }
            
            if($request->hasFile('invoice_logo')){
                $footer_logo = uploadImage($request->file('invoice_logo'), 'logo','invoice_logo');
                $footer_logo_old = SetttingValue('invoice_logo');
                if ($footer_logo && !empty($footer_logo)) {
                    $extra['name'] = 'invoice logo';
                    $extra['value'] = $footer_logo;
                    $extra['created_by'] = Auth::user()->email;
                    $extra['updated_by'] = Auth::user()->email;

                    if (!Setting::updateOrCreate(['key' => 'invoice_logo'], $extra)) {
                        $proceed = 'No';
                    }
                }
            }
            
              if($request->hasFile('favicon')){
                $favicon = uploadImage($request->file('favicon'), 'logo','favicon');
                $favicon_old = SetttingValue('favicon');
                if ($favicon && !empty($favicon)) {
                    $extra['name'] = 'favicon';
                    $extra['value'] = $favicon;
                    $extra['created_by'] = Auth::user()->email;
                    $extra['updated_by'] = Auth::user()->email;

                    if (!Setting::updateOrCreate(['key' => 'favicon'], $extra)) {
                        $proceed = 'No';
                    }
                }
            }
              
              
            if(!empty($request->input('state'))){
                  $extra['name'] = 'State';
                  $extra['value'] = $request->input('state');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'state'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('state_code'))){
                  $extra['name'] = 'State Code';
                  $extra['value'] = $request->input('state_code');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'state_code'], $extra)){
                      $proceed = 'No';
                  }
              }
              
              if(!empty($request->input('contact_phone'))){
                  $extra['name'] = 'contact phone';
                  $extra['value'] = $request->input('contact_phone');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'contact_phone'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('gstin'))){
                  $extra['name'] = 'GSTIN Number';
                  $extra['value'] = $request->input('gstin');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'gstin'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('company_pan'))){
                  $extra['name'] = 'Company Pan Number';
                  $extra['value'] = $request->input('company_pan');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'company_pan'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('company_bank_name'))){
                  $extra['name'] = 'Company Bank Number';
                  $extra['value'] = $request->input('company_bank_name');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'company_bank_name'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('company_bank_branch'))){
                  $extra['name'] = 'Company Bank Branch';
                  $extra['value'] = $request->input('company_bank_branch');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'company_bank_branch'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('company_bank_account'))){
                  $extra['name'] = 'Company Bank Account Number';
                  $extra['value'] = $request->input('company_bank_account');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'company_bank_account'], $extra)){
                      $proceed = 'No';
                  }
              }
              if(!empty($request->input('company_bank_ifsc'))){
                  $extra['name'] = 'Company Bank IFSC code';
                  $extra['value'] = $request->input('company_bank_ifsc');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'company_bank_ifsc'], $extra)){
                      $proceed = 'No';
                  }
              }
              
              #######################################
              # Home page about us settings
              #######################################
            
            if(!empty($request->input('home_about_section'))){
                  $extra['name'] = 'Home Page About Section Show or Hide';
                  $extra['value'] = $request->input('home_about_section');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'home_about_section'], $extra)){
                      $proceed = 'No';
                  }
              } 
            
            if($request->hasFile('home_about_image')){
                $home_about_image = uploadImage($request->file('home_about_image'), 'home_page','about_image');
                $home_about_image_old = SetttingValue('home_about_image');
                if ($home_about_image && !empty($home_about_image)) {
                    $extra['name'] = 'Home about image';
                    $extra['value'] = $home_about_image;
                    $extra['created_by'] = Auth::user()->email;
                    $extra['updated_by'] = Auth::user()->email;

                    if (!Setting::updateOrCreate(['key' => 'home_about_image'], $extra)) {
                        $proceed = 'No';
                    }
                }
            }
            
            
            if(!empty($request->input('home_about_title'))){
                  $extra['name'] = 'Home Page About Title';
                  $extra['value'] = $request->input('home_about_title');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'home_about_title'], $extra)){
                      $proceed = 'No';
                  }
              } 
              
              if(!empty($request->input('home_about_description'))){
                  $extra['name'] = 'Home Page About Description';
                  $extra['value'] = $request->input('home_about_description');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'home_about_description'], $extra)){
                      $proceed = 'No';
                  }
              } 
              
            #######################################
            # Home page counter settings
            #######################################
              
            if(!empty($request->input('home_counter_section'))){
                  $extra['name'] = 'Home Page Counter Section';
                  $extra['value'] = $request->input('home_counter_section');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'home_counter_section'], $extra)){
                      $proceed = 'No';
                  }
              } 
              
              if($request->hasFile('home_video_image')){
                $home_video_image = uploadImage($request->file('home_video_image'), 'home_page','video_image');
                $home_video_image_old = SetttingValue('home_video_image');
                if ($home_video_image && !empty($home_video_image)) {
                    $extra['name'] = 'Home video image';
                    $extra['value'] = $home_video_image;
                    $extra['created_by'] = Auth::user()->email;
                    $extra['updated_by'] = Auth::user()->email;

                    if (!Setting::updateOrCreate(['key' => 'home_video_image'], $extra)) {
                        $proceed = 'No';
                    }
                }
            }
              
            if(!empty($request->input('home_counter_title'))){
                  $extra['name'] = 'Home Page Counter Section Title';
                  $extra['value'] = $request->input('home_counter_title');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'home_counter_title'], $extra)){
                      $proceed = 'No';
                  }
              } 
            if(!empty($request->input('home_counter_description'))){
                  $extra['name'] = 'Home Page Counter Section Description';
                  $extra['value'] = $request->input('home_counter_description');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'home_counter_description'], $extra)){
                      $proceed = 'No';
                  }
              } 
              
            #######################################
            # Home page video presentation section settings
            #######################################
              
            if(!empty($request->input('home_video_section'))){
                  $extra['name'] = 'Home Page Video Presentation Section';
                  $extra['value'] = $request->input('home_video_section');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'home_video_section'], $extra)){
                      $proceed = 'No';
                  }
              } 
            if(!empty($request->input('home_video_embed_link'))){
                  $extra['name'] = 'Home Page Video Embed Link';
                  $extra['value'] = $request->input('home_video_embed_link');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'home_video_embed_link'], $extra)){
                      $proceed = 'No';
                  }
              } 
            if(!empty($request->input('home_video_title'))){
                  $extra['name'] = 'Home Page Video Presentation Section Title';
                  $extra['value'] = $request->input('home_video_title');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'home_video_title'], $extra)){
                      $proceed = 'No';
                  }
              } 
            if(!empty($request->input('home_video_description'))){
                  $extra['name'] = 'Home Page Video Presentation Section Description';
                  $extra['value'] = $request->input('home_video_description');
                  $extra['created_by'] = Auth::user()->email;
                  $extra['updated_by'] = Auth::user()->email;
                  
                  if(!Setting::updateOrCreate(['key' => 'home_video_description'], $extra)){
                      $proceed = 'No';
                  }
              } 
              
              
              
              
              
            if($proceed == 'Yes')
            {
                DB::commit();
                Log::debug(__CLASS__."::".__FUNCTION__." Settings Updated successfully for Settings");
                session()->put("success","Settings Updated Successfully");
                if(!empty($header_logo_old) && file_exists(public_path().'/'.$header_logo_old)){
                unlink(public_path().'/'.$header_logo_old);
            }
                if(!empty($header_logo_old_diamond) && file_exists(public_path().'/'.$header_logo_old_diamond)){
                unlink(public_path().'/'.$header_logo_old_diamond);
            }
            if(!empty($footer_logo_old) && file_exists(public_path().'/'.$footer_logo_old)){
                unlink(public_path().'/'.$footer_logo_old);
            }
            if(!empty($favicon_old) && file_exists(public_path().'/'.$favicon_old)){
                unlink(public_path().'/'.$favicon_old);
            }
            if(!empty($home_about_image_old) && file_exists(public_path().'/'.$home_about_image_old)){
                unlink(public_path().'/'.$home_about_image_old);
            }
            if(!empty($home_video_image_old) && file_exists(public_path().'/'.$home_video_image_old)){
                unlink(public_path().'/'.$home_video_image_old);
            }
                       
            }else{
                Log::error(__CLASS__."::".__FUNCTION__." Language details saving failed for Settings");
                
                session()->put("error","Oops Some error occured !!");
            }
        }catch(\Exception $e){
            DB::rollback();
            Log::error(__CLASS__."::".__FUNCTION__." Exception :: ".$e->getTraceAsString());
            session()->put("error"," Exception Occured ".$e->getMessage());
            if(!empty($header_logo) && file_exists(public_path().'/'.$header_logo)){
                unlink(public_path().'/'.$header_logo);
            }
            if(!empty($header_logo_diamond) && file_exists(public_path().'/'.$header_logo_diamond)){
                unlink(public_path().'/'.$header_logo_diamond);
            }
            if(!empty($footer_logo) && file_exists(public_path().'/'.$footer_logo)){
                unlink(public_path().'/'.$footer_logo);
            }
            if(!empty($favicon) && file_exists(public_path().'/'.$favicon)){
                unlink(public_path().'/'.$favicon);
            }
            if(!empty($home_about_image) && file_exists(public_path().'/'.$home_about_image)){
                unlink(public_path().'/'.$home_about_image);
            }
            if(!empty($home_video_image) && file_exists(public_path().'/'.$home_video_image)){
                unlink(public_path().'/'.$home_video_image);
            }
            return Redirect::back();
        }
        
        
        
        return Redirect::back();
    }
    
}
