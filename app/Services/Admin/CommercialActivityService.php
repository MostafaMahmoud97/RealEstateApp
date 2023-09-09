<?php


namespace App\Services\Admin;


use App\Models\CommercialActivities;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class CommercialActivityService
{
    public function index($user_id){
        $user = User::find($user_id);
        if (!$user){
            return Response::errorResponse(__("commercial_activity.no user by this id"));
        }

        $CommercialActivities = $user->CommercialActivities()->paginate(10);
        return Response::successResponse($CommercialActivities,__("commercial_activity.Commercial activities have been fetched success"));
    }

    public function store($request){
        $user = User::find($request->user_id);
        if (!$user){
            return Response::errorResponse(__("commercial_activity.no user by this id"));
        }
        $CommercialActivity = CommercialActivities::create($request->all());
        return Response::successResponse($CommercialActivity,__("commercial_activity.Commercial activity has been added success"));
    }

    public function update($id,$request){
        $CommercialActivity = CommercialActivities::where("user_id",$request->user_id)->find($id);
        if (!$CommercialActivity){
            return Response::errorResponse(__("commercial_activity.no commercial activity by this id"));
        }
        $CommercialActivity = $CommercialActivity->update($request->all());
        return Response::successResponse($CommercialActivity,__("commercial_activity.Commercial activity has been updated success"));
    }

    public function show($id){
        $CommercialActivity = CommercialActivities::find($id);
        if (!$CommercialActivity){
            return Response::errorResponse(__("commercial_activity.no commercial activity by this id"));
        }
        return Response::successResponse($CommercialActivity,__("commercial_activity.Commercial activity has been fetched success"));
    }

    public function delete($id){
        $CommercialActivity = CommercialActivities::find($id);
        if (!$CommercialActivity){
            return Response::errorResponse(__("commercial_activity.no commercial activity by this id"));
        }
        $CommercialActivity->delete();
        return Response::successResponse([],__("commercial_activity.Commercial activity has been deleted success"));
    }
}
