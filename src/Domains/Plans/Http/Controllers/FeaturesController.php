<?php

namespace Teckipro\Admin\Domains\Plans\Http\Controllers;


use Illuminate\Http\Request;
use Tamunoemi\Laraplans\Models\Plan;
use Tamunoemi\Laraplans\Models\PlanFeature;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Teckipro\Admin\Http\Controllers\OperationReport;
use Teckipro\Admin\Http\Requests\AddPlanFeaturesRequest;

class FeaturesController extends Controller
{

    public $operationReport;


    public function __construct(){
        $this->operationReport = new OperationReport();
    }


    public function index(){
          //list all features
      $resp = Plan::select('id','name')->get()->toArray();

      $plans = array();
      foreach ($resp as $key => $value) {
         $plans[''] = "select plan..";
         $plans[$value['id']] = $value['name'];
      }

      return view('teckiproadmin::plans.features.index',['plans'=>$plans]);

    }

    public function create(Request $request){
         $planId = $request->input('id');
         if(!$planId){ abort(404); }
         $details = Plan::select('id','name','description','price')->where('id',$planId)->get()->toArray()[0];
         return view('teckiproadmin::plans.features.create')->withPlanId($planId)->withDetails($details);

    }

    public function store(AddPlanFeaturesRequest $request){
        $validated = $request->validated();
        $code = $validated['code'];
        $planId = $validated['id'];
        $value = $validated['value'];


        try {
            //get the last sort_order of this very plan feature
        $Planfeature = new PlanFeature();
        $features = $Planfeature->where("plan_id",$planId)->pluck('sort_order');
        $sort_order = !empty($features) ? Arr::first(Arr::sortDesc($features)): 0;
        $sort_order = $sort_order+1;

        $data = array(
           'plan_id'=>$planId,
           'code'=>$code,
           'value'=>$value,
           'sort_order'=>(int)$sort_order
        );
        $Planfeature::firstOrCreate($data);

        return back()->with('success', __('teckiproadmin::operationreport.added_successfully'));

       } catch (\Illuminate\Database\QueryException  $e) {

         return back()->with('info', __("teckiproadmin::operationreport.db_record_exists"));

       }
    }

    public function show(){

    }

    public function delete(Request $request){
         $id = $request->input("id");
         $feature = PlanFeature::find($id);
         $feature->delete();
         return json_encode($this->operationReport->report("success", "Deleted successfully."));
    }


    public function getPlanFeaturesTablerows(Request $request){
        $planId = $request->input('id');
        $html='';
        $plans = PlanFeature::select('code','value','id')->where('plan_id',$planId)->get()->toArray();

        if(!empty($plans)){
              foreach ($plans as $key => $value) {
                $code = $value['code'];
                $v = $value['value'];
                $id = $value['id'];
                $remove = "<a class='remove text-danger' href='#' id='".$id."'><i class='bi bi-trash3-fill'></i></a>";
                $html.= "<tr><td>$code </td> <td>$v </td> <td>$remove</td></tr>";
              }

        }

        return json_encode($this->operationReport->report($html,'success'));

    }


}
