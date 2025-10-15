<?php
use Illuminate\Support\Str;
use App\Models\Group;
use App\Models\UserFriend;
use App\Models\User;
use App\Models\KycDocument;
use Illuminate\Support\Facades\Http;


if (!function_exists('generate_otp')) {
    function generate_otp() {
        return rand(100000, 999999);
    }
}

if (! function_exists('send_sms')) {
    /**
     * Send SMS using SMS Point API.
     *
     * @param string $to The recipient phone number.
     * @param string $msg The message to send.
     * @return array The response from the SMS API.
     */
    function send_sms($phone, $msg)
    {
        $phone = str_replace("-", '', $phone);
        $ptn = "/^0/";  // Regex
        $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
        $rpltxt = "92";  // Replacement string
        $phone = preg_replace($ptn, $rpltxt, $str);

        // Prepare the API URL and parameters
        $apiUrl = 'https://www.smspoint.pk/api/sendSMS/';

        // API parameters
        $params = [
            'userName' => 'nosolo',
            'password' => 'Lahore123',
            'ClientID' => 'nosolo',
            'mask' => '8827',
            'msg' => $msg, // Dynamic message from user input
            'to' => $phone,   // Dynamic recipient from user input
            'language' => 'English', // Language can also be dynamic if needed
        ];

        // dd($params);
        // Send the GET request to the API endpoint
        $response = Http::get($apiUrl, $params);

        // Check if the response was successful
        if ($response->successful()) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('sendNotification')) {
    function sendNotification($message , $user_id , $user_id2 = null) {

        return true;
    }
}

if (!function_exists('getUniqueIdForUsers')) {
    function getUniqueIdForUsers() {
        do {
            $userUniqueId = strtoupper(Str::random(16));
        } while (UserFriend::where('friend_unique_id', $userUniqueId)->exists());

        return $userUniqueId;
    }
}

if (!function_exists('getUniqueIdForGroups')) {
    function getUniqueIdForGroups() {
        do {
            $GroupUniqueId = strtoupper(Str::random(16));
        } while (Group::where('group_unique_id', $GroupUniqueId)->exists());

        return $GroupUniqueId;
    }
}

if (!function_exists('generateZegoSignature')) {
    function generateZegoSignature($appId, $serverSecret, $signatureNonce, $timestamp)
    {
        $str = $appId . $signatureNonce . $serverSecret . $timestamp;
        return md5($str);
    }
}

if (!function_exists('kycDocTypes')) {
    function kycDocTypes(){
        return ['cnic_front', 'cnic_back', 'electricity_bill', 'selfie'];
    }
}

if (!function_exists('getUserTimezone')) {
    function getUserTimezone()
    {
        // Get the user's IP address
        $ip = request()->ip(); // Get the user's IP address
        // $ip = "198.51.100.14"; // Get the user's IP address

        // Make a request to the ip-api.com API
        $response = Http::get("http://ip-api.com/json/{$ip}");

        if ($response->successful()) {
            // Parse the response to get the region data (country, region, city)
            $data = $response->json();
            $country = $data['country'] ?? 'Country not found';
            $region = $data['regionName'] ?? 'Region not found';
            $city = $data['city'] ?? 'City not found';

            return response()->json([
                'status' => true,
                'ip' => $ip,
                'country' => $country,
                'region' => $region,
                'city' => $city,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Unable to get region data',
            ]);
        }
        return response()->json(['status' => false,'error' => 'Unable to get timezone']);
    }
}

if (!function_exists('checkKyc')) {
    function checkKyc(){
        return false;
    }
}

if (!function_exists('getUserData')) {
    function getUserData($id){
        $user = User::with([
                'habits' => function ($q) {
                    $q->select('habits.parent_id', 'habits.id AS answer_id');
                },
                'interests' => function ($q) {
                    $q->select('habits.id AS answer_id');
                },
                'images' => function ($q) {
                    $q->select('id', 'image', 'user_id')
                        ->selectRaw("CASE
                            WHEN image LIKE '%://%' THEN image
                            ELSE CONCAT('" . url('/public/storage') . "/', image)
                        END AS image"); // Check if the image URL already has a scheme (http or https)
                }
            ])
                ->where('id', $id)
                ->selectRaw("* , CASE
                WHEN image LIKE '%://%' THEN image
                ELSE CONCAT('" . url('/public/storage') . "/', image)
            END AS image")
                ->first();

            // Remove 'pivot' from the response and convert 'interests' to a comma-separated string
            if ($user) {
                // Remove 'pivot' field from habits and interests relationships
                $user->setHidden(['interests', 'habits']);

                // Convert 'interests & habit' collection to an array and then to a comma-separated string
                $habits = [];
                if ($user->habits) {
                    foreach ($user->habits as $key => $habit) {
                        $habits[$key]['parent_id'] = $habit->parent_id;
                        $habits[$key]['answer_id'] = $habit->answer_id;
                    }
                    $user->habbit = $habits;
                }

                $interests = [];
                if ($user->interests) {
                    foreach ($user->interests as $interest) {
                        $interests[] = $interest->answer_id;
                    }
                    $user->interest = $interests;
                }

                // Optionally, if you want to include the KYC documents as a comma-separated string or formatted output
                $user->kyc_doc_types = kycDocTypes();
                $user->check_kyc = checkKyc();

                $kycDocuments = KycDocument::where('user_id', $user->id)
                    ->whereIn('id', function ($query) use ($user) {
                        $query->selectRaw('MAX(id)')
                            ->from('kyc_documents')
                            ->where('user_id', $user->id)
                            ->groupBy('document_type');
                    })
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($document) {
                        // Attach the base URL to the document_path
                        $document->document_path = url('/public/storage') . '/' . $document->document_path;
                        return $document;
                    });

                $user->kyc_documents = $kycDocuments;
                $user->blocked_user_ids = $user->blockedUsers()->pluck('blocked_user_id');;
            }
        return $user;
    }
}
