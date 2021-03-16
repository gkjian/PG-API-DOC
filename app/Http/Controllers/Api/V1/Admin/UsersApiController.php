<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\Payout;
use App\Models\TopUp;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource(User::with(['roles'])->get());
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource($user->load(['roles']));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function wallet($a)
    {
        //拿取所有的payout 和 top up
        $total_array = [];

        $total_top_up = 0;
        $total_payout = 0;
        $total_processing_fee = 0;
        $payout =  Payout::where('gate_id', $a)->get();
        $payout_arr =  [];
        foreach ($payout as $p) {

            if($p['status'] == 1){
                $total_payout += $p['amount'];
                $total_processing_fee += $p['processing_fee'];
            }
            
            array_push($payout_arr,$p);
        };

        $top_up = TopUp::where('gate_id', $a)->get();
        $top_up_arr =  [];
        foreach ($top_up as $t) {

            if($t['status'] == 7){
                $total_top_up += $t['amount'];
                $total_processing_fee += $t['processing_fee'];
            }
            
            array_push($top_up_arr,$t);
        };
        $total_array['wallet'] = $total_top_up - $total_payout;
        $total_array['total_top_up'] = $total_top_up;
        $total_array['total_payout'] = $total_payout;
        $total_array['processing_fee'] = $total_processing_fee;
        $total_array['payout_list'] = $payout_arr;
        $total_array['top_up_list'] = $top_up_arr;
        
        return $total_array;
    }
}
