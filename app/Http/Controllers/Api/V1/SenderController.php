<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateSenderProfileRequest;
use App\Models\SenderProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SenderController extends Controller
{
    public function profile(Request $r)
    {
        $user = $r->user();
        $profile = $user->senderProfile()->first();
        return response()->json(['status'=>true,'message'=>'Sender profile retrieved','data'=>['user'=>$user,'profile'=>$profile]]);
    }

    public function updateProfile(UpdateSenderProfileRequest $r)
    {
        $user = $r->user();
        $data = $r->validated();

        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->fill(collect($data)->only(['name','phone'])->toArray());
        $user->save();

        // update or create sender profile
        $profileData = collect($data)->only(['business_name','pickup_address','contact_person'])->toArray();
        $profile = SenderProfile::updateOrCreate(['user_id'=>$user->id], $profileData);

        return response()->json(['status'=>true,'message'=>'Profile updated','data'=>['user'=>$user,'profile'=>$profile]]);
    }
}
