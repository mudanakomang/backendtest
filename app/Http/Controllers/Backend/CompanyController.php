<?php

namespace App\Http\Controllers\Backend;

use App\Models\Company;
use App\Models\Postcode;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Config;

class CompanyController extends Controller
{
    //
    private function getRoute() {
        return 'company';
    }

    protected function validator($data=[],$type){
        if ($type=='create'){
            return Validator::make($data,[
                'name'=>'required|string|max:255',
                'email'=>'required|email|max:255|unique:companies,email'.$data['id'],
                'postcode'=>'required|digits:7',
                'prefecture_id'=>'required',
                'city'=>'required|string|max:255',
                'local'=>'required|string|max:255',
                'street_address'=>'max:255',
                'business_hour'=>'max:255',
                'regular_holiday'=>'max:255',
                'phone'=>'max:14',
                'fax'=>'max:14',
                'url'=>'max:255',
                'license_number'=>'max:255',
                'image'=>'required|mimes:jpg,bmp,png|dimensions:max_width=1280,max_height=720|max:25000'
            ]);
        }else{
            return Validator::make($data,[
                'name'=>'required|string|max:255',
                'email'=>'required|email|max:255|unique:companies,email,' . $data['id'],
                'postcode'=>'required|digits:7',
                'prefecture_id'=>'required',
                'city'=>'required|string|max:255',
                'local'=>'required|string|max:255',
                'street_address'=>'max:255',
                'business_hour'=>'max:255',
                'regular_holiday'=>'max:255',
                'phone'=>'max:14',
                'fax'=>'max:14',
                'url'=>'max:255',
                'license_number'=>'max:255',
                'image'=>'mimes:jpeg,bmp,png,jpg|dimensions:max_width=1280,max_height=720|max:25000'
            ]);
        }

    }

    public function index(){
        return view('backend.companies.index');
    }

    public function add(){
        $company = new Company();
        $company->form_action=$this->getRoute().'.create';
        $company->page_title='Company Add Page';
        $company->page_type='create';
        return view('backend.companies.form',['company'=>$company]);
    }

    public function create(Request $request){
        $newCompany=$request->all();
        $this->validator($newCompany,'create')->validate();
       try{
         $company=Company::create($newCompany);
         if ($company){
             if ($request->file('image')){
                 $file=$request->file('image');
                 $ext=$file->getClientOriginalExtension();
                 $filename='image_'.$company->id.'.'.$ext;
                 $file->move(public_path('uploads/files/'),$filename);
                 $company->update(['image'=>$filename]);
             }
             return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_CREATE_MESSAGE'));
         }else{
             return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
         }
       }catch (Exception $e){
           return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
        }
    }

    public function edit($id){
        $company=Company::find($id);
        $company->form_action = $this->getRoute() . '.update';
        $company->page_title = 'Company Edit Page';
        $company->page_type = 'edit';
        return view('backend.companies.form', [
            'company' => $company
        ]);
    }

    public function update(Request $request){
           $newCompany=$request->all();
           $this->validator($newCompany, 'update')->validate();
           try{
               $currentCompany=Company::find($request->get('id'));
               $currentCompany->update($newCompany);
               if ($currentCompany){
                   if ($request->has('image')){
                       $file=$request->file('image');
                       $ext=$file->getClientOriginalExtension();
                       $filename='image_'.$currentCompany->id.'.'.$ext;
                       $file->move(public_path('uploads/files/'),$filename);
                       $currentCompany->update(['image'=>$filename]);
                   }
                   return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_CREATE_MESSAGE'));

               }else{
                   return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
               }
           } catch (Exception $e){
               return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
           }


    }

    public function delete(Request $request){
        try {
            $company = Company::find($request->get('id'));
            unlink(public_path('uploads/files/').'/'.$company->image);
            $company->delete();
            return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_DELETE_MESSAGE'));
        } catch (Exception $e) {
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_DELETE_MESSAGE'));
        }
    }

    public function postCodeCheck(Request $request){
        $postcode=Postcode::where('postcode',$request->postcode)->first();
        if ($postcode){
            $prefecture=Prefecture::where('display_name',$postcode->prefecture)->first();
            $data=[];
            $data['prefecture_id']=$prefecture->id;
            $data['city']=$postcode->city;
            $data['local']=$postcode->local;
            return response($data);
        }else{
            return response('error');
        }


    }
}
