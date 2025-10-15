<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;


class ZegocloudController extends Controller
{
    public function createGroup($groupId, $name, $owner, $members, $avatar)
    {
        try {
            // Set your App ID and Server Secret
            $appId = env('ZEGOCLOUD_APP_ID');
            $serverSecret = env('ZEGOCLOUD_SERVER_SECRET');
            $signatureNonce = bin2hex(random_bytes(8)); // Generate a 16-bit hexadecimal random string
            $timestamp = time();

            $signature = generateZegoSignature($appId, $serverSecret, $signatureNonce, $timestamp);

            $url = "https://zim-api.zego.im/?Action=CreateGroup&AppId=$appId&Signature=$signature&SignatureNonce=$signatureNonce&SignatureVersion=2.0&Timestamp=$timestamp";

            // Prepare the request data
            $data = [
                'GroupId' => (string) $groupId,
                'GroupName' => $name,
                'GroupNotice' => 'group_notice',
                'GroupAvatar' => $avatar,
                'GroupOwner' => (string) 2,
                'UserId' => $members,  // Array of members
            ];

            // Send POST request using HTTP client
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $data);

            // Check the response
            if ($response->successful()) {
                return ([
                    'status' => true,
                    'data' => $response->json(),
                ]);
            } else {
                return ([
                    'status' => false,
                    'message' => $response->body(),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error Message ' . $e->getMessage());
            Log::error('Requesr Perameters ', request()->all());
            return response()->json([
                'status' => false,
                // 'message' => 'Failed to send OTP.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function InviteUsersIntoGroup($groupId, $members)
    {
        try {
            // Set your App ID and Server Secret
            $appId = env('ZEGOCLOUD_APP_ID');
            $serverSecret = env('ZEGOCLOUD_SERVER_SECRET');
            $signatureNonce = bin2hex(random_bytes(8)); // Generate a 16-bit hexadecimal random string
            $timestamp = time();

            $signature = generateZegoSignature($appId, $serverSecret, $signatureNonce, $timestamp);

            $url = "https://zim-api.zego.im/?Action=InviteUsersIntoGroup&AppId=$appId&Signature=$signature&SignatureNonce=$signatureNonce&SignatureVersion=2.0&Timestamp=$timestamp";

            // Prepare the request data
            foreach ($members as $memberId) {
                $groupMemberInfos[] = [
                    'UserId' => (string) $memberId, // Assuming you want "user_" prefix followed by member ID
                    'EnterGroupTime' => 0 // or any other logic to set EnterGroupTime
                ];
            }
            $data = [
                'FromUserId' => (string) auth()->user()->id,
                'GroupId' => (string) $groupId,
                'GroupMemberInfos' => $groupMemberInfos,  // Array of members
            ];

            // dd($data);
            // Send POST request using HTTP client
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $data);

            // dd($response->json());
            // Check the response
            if ($response->successful()) {
                return ([
                    'status' => true,
                    'data' => $response->json(),
                ]);
            } else {
                return ([
                    'status' => false,
                    'message' => $response->body(),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error Message ' . $e->getMessage());
            Log::error('Requesr Perameters ', request()->all());
            return response()->json([
                'status' => false,
                // 'message' => 'Failed to send OTP.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function KickoutGroupUser($groupId, $members)
    {
        try {
            // Set your App ID and Server Secret
            $appId = env('ZEGOCLOUD_APP_ID');
            $serverSecret = env('ZEGOCLOUD_SERVER_SECRET');
            $signatureNonce = bin2hex(random_bytes(8)); // Generate a 16-bit hexadecimal random string
            $timestamp = time();

            $signature = generateZegoSignature($appId, $serverSecret, $signatureNonce, $timestamp);

            $url = "https://zim-api.zego.im/?Action=KickoutGroupUser&AppId=$appId&Signature=$signature&SignatureNonce=$signatureNonce&SignatureVersion=2.0&Timestamp=$timestamp";

            // Prepare the request data
            $data = [
                'FromUserId' => (string) auth()->user()->id,
                'GroupId' => (string) $groupId,
                // "CustomReason"=>"reason",
                'UserId' => $members,  // Array of members
            ];
            // dd($data);
            // Send POST request using HTTP client
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $data);

            // Check the response
            if ($response->successful()) {
                return ([
                    'status' => true,
                    'data' => $response->json(),
                ]);
            } else {
                return ([
                    'status' => false,
                    'data' => $response->body(),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error Message ' . $e->getMessage());
            Log::error('Requesr Perameters ', request()->all());
            return response()->json([
                'status' => false,
                // 'message' => 'Failed to send OTP.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function QueryGroupMemberList($groupId)
    {
        try {
            // Set your App ID and Server Secret
            $appId = env('ZEGOCLOUD_APP_ID');
            $serverSecret = env('ZEGOCLOUD_SERVER_SECRET');
            $signatureNonce = bin2hex(random_bytes(8)); // Generate a 16-bit hexadecimal random string
            $timestamp = time();

            $signature = generateZegoSignature($appId, $serverSecret, $signatureNonce, $timestamp);

            $url = "https://zim-api.zego.im/?Action=QueryGroupMemberList&AppId=$appId&Signature=$signature&SignatureNonce=$signatureNonce&SignatureVersion=2.0&Timestamp=$timestamp";

            // Prepare the request data
            $data = [
                'GroupId' => (string) $groupId,
                'Limit' => 1000,
                'Next' => 0,  // Array of members
            ];
            // dd($data);
            // Send POST request using HTTP client
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $data);

            // Check the response
            if ($response->successful()) {
                return ([
                    'status' => true,
                    'data' => $response->json(),
                ]);
            } else {
                return ([
                    'status' => false,
                    'message' => $response->body(),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error Message ' . $e->getMessage());
            Log::error('Requesr Perameters ', request()->all());
            return response()->json([
                'status' => false,
                // 'message' => 'Failed to send OTP.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function DismissGroup($groupId)
    {
        try {
            // Set your App ID and Server Secret
            $appId = env('ZEGOCLOUD_APP_ID');
            $serverSecret = env('ZEGOCLOUD_SERVER_SECRET');
            $signatureNonce = bin2hex(random_bytes(8)); // Generate a 16-bit hexadecimal random string
            $timestamp = time();

            $signature = generateZegoSignature($appId, $serverSecret, $signatureNonce, $timestamp);

            $userId = (string) auth()->user()->id;
            $url = "https://zim-api.zego.im/?Action=DismissGroup&FromUserId=$userId&GroupId=$groupId&AppId=$appId&Signature=$signature&SignatureNonce=$signatureNonce&SignatureVersion=2.0&Timestamp=$timestamp";

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->get($url); // Changed from POST to GET if it's a GET request


            // Check the response
            if ($response->successful()) {
                return ([
                    'status' => true,
                    'data' => $response->json(),
                ]);
            } else {
                return ([
                    'status' => false,
                    'message' => $response->body(),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error Message ' . $e->getMessage());
            Log::error('Requesr Perameters ', request()->all());
            return response()->json([
                'status' => false,
                // 'message' => 'Failed to send OTP.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
