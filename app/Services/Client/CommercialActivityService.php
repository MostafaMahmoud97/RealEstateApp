<?php


namespace App\Services\Client;


use App\Models\CommercialActivities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CommercialActivityService
{
    public function index(){
        $user = Auth::user();
        $CommercialActivities = $user->CommercialActivities()->paginate(10);
        return Response::successResponse($CommercialActivities,__("commercial_activity_client.Commercial activities have been fetched success"));
    }

    public function store($request){
        $user_id = Auth::id();
        $CommercialActivity = CommercialActivities::create(array_merge($request->all(),["user_id"=>$user_id]));
        return Response::successResponse($CommercialActivity,__("commercial_activity_client.Commercial activity has been added success"));
    }

    public function show($id){
        $user_id = Auth::id();
        $CommercialActivity = CommercialActivities::where("user_id",$user_id)->find($id);
        if (!$CommercialActivity){
            return Response::errorResponse(__("commercial_activity_client.no commercial activity by this id"));
        }
        return Response::successResponse($CommercialActivity,__("commercial_activity_client.Commercial activity has been fetched success"));
    }

    public function update($id,$request){
        $user_id = Auth::id();
        $CommercialActivity = CommercialActivities::where("user_id",$user_id)->find($id);
        if (!$CommercialActivity){
            return Response::errorResponse(__("commercial_activity_client.no commercial activity by this id"));
        }
        $CommercialActivity = $CommercialActivity->update($request->all());
        return Response::successResponse($CommercialActivity,__("commercial_activity_client.Commercial activity has been updated success"));
    }

    public function delete($id){
        $user_id = Auth::id();
        $CommercialActivity = CommercialActivities::where("user_id",$user_id)->find($id);
        if (!$CommercialActivity){
            return Response::errorResponse(__("commercial_activity_client.no commercial activity by this id"));
        }
        $CommercialActivityCheck = CommercialActivities::where("user_id",$user_id)->whereHas("Units")->find($id);
        if ($CommercialActivityCheck){
            return Response::errorResponse(__("commercial_activity.you can't delete this commercial activity because it assigned to unit"));
        }

        $CommercialActivity->delete();
        return Response::successResponse([],__("commercial_activity_client.Commercial activity has been deleted success"));
    }
}
