<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreReceiverRequest;
use App\Http\Requests\Api\UpdateReceiverRequest;
use App\Models\Receiver;
use Illuminate\Http\Request;

class ReceiverController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        // show receivers saved by this sender (you can extend to global contacts)
        $receivers = Receiver::where(function($q) use ($user){
            $q->whereNull('user_id')->orWhere('user_id', $user->id);
        })->paginate(20);

        return response()->json(['status'=>true,'message'=>'Receivers list','data'=>$receivers]);
    }

    public function store(StoreReceiverRequest $request)
    {
        $data = $request->validated();
        // optional: attach to user
        $data['user_id'] = $request->user()->id;
        $receiver = Receiver::create($data);

        return response()->json(['status'=>true,'message'=>'Receiver created','data'=>$receiver], 201);
    }

    public function show(Request $request, Receiver $receiver)
    {
        // optionally check visibility: if tied to another user and not public, block
        if ($receiver->user_id && $receiver->user_id !== $request->user()->id) {
            return response()->json(['status'=>false,'message'=>'Unauthorized'],403);
        }
        return response()->json(['status'=>true,'message'=>'Receiver detail','data'=>$receiver]);
    }

    public function update(UpdateReceiverRequest $request, Receiver $receiver)
    {
        if ($receiver->user_id !== $request->user()->id) {
            return response()->json(['status'=>false,'message'=>'Unauthorized'],403);
        }
        $receiver->update($request->validated());
        return response()->json(['status'=>true,'message'=>'Receiver updated','data'=>$receiver]);
    }

    public function destroy(Request $request, Receiver $receiver)
    {
        if ($receiver->user_id !== $request->user()->id) {
            return response()->json(['status'=>false,'message'=>'Unauthorized'],403);
        }
        $receiver->delete();
        return response()->json(['status'=>true,'message'=>'Receiver deleted']);
    }
}
