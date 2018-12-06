<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Cookie;
use App\Links;
use App\Tracked;
use App\Visitors;
use App\Helpers\URLFactory;
use App\Http\Requests\CreateLink;

class Link extends Controller {
    public function cut(CreateLink $request) {
        $validation = $request->validated();
        
        $tracked = isset($validation['email']) ? true : false;
        $encoded = URLFactory::encode($validation['url'], $tracked);

        $cookie = null;
        
        if ($encoded['add_to_db']) {
            $added_link = Links::create([
                'hash'    => $encoded['code'],
                'link'    => $encoded['clean_origin'],
                'tracked' => $tracked
            ]);

            if ($tracked === true) {
                $added_id = $added_link->id;
    
                $session_id = isset($_COOKIE['SID']) ? $_COOKIE['SID'] : null;
    
                if ($session_id === null) {
                    $session_id = session_create_id('neopix-');
                    
                    Cookie::queue('SID', $session_id, 60 * 24 * 365);
                    //$cookie = Cookie::forever('SID', $session_id);
                }
                $hash = bin2hex(random_bytes(4));
        
                Tracked::create([
                    'email'     => $validation['email'],
                    'hash'      => $hash,
                    'unique_id' => $session_id,
                    'link_id'   => $added_id
                ]);

                $email_data = [
                    'url'       => url('/d/' . $hash),
                 ];

                 $email_to = $validation['email'];
                 

                Mail::send('email',  $email_data , function($message) use ($email_to) {
                    $message->to($email_to)->subject('LinkCutter latest cut');
                    $message->from('ilic.marko.05@live.com', 'LinkCutter');
                });
            }
        }


        $response = array();
        $response['success'] = true;
        $response['url'] = $encoded['url'];

        return response()->json($response, 200);
    }

    public function redirect($hash) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        // @TODO This can be improved, because `REMOTE_ADDR maybe hidden (behind a proxy).
        $ip_address = '178.149.203.210'; // 178.149.203.210
        $session_id = isset($_COOKIE['SID']) ? $_COOKIE['SID'] : null;

        $decoded = URLFactory::decode($hash);

        if ($decoded === null) {
            return redirect('/');
        }

        if ($decoded['tracked'] == false) {
            return redirect()->away($decoded['url']);
        }

        $skip = false;        
        $ip_browser_visit = Visitors::where('ip_address', '=', $ip_address)
                                    ->where('user_agent', '=', $user_agent)
                                    ->where('link_id', '=', $decoded['id'])
                                    ->join('links', 'link_id', '=', 'links.id')
                                    ->exists();
        
        // http://ipinfo.io/
        $ip_info = json_decode(file_get_contents('https://www.iplocate.io/api/lookup/'.$ip_address), true);

        if ($session_id === null || $ip_browser_visit === false) {
            if ($session_id === null) {
                $session_id = session_create_id('neopix-');
                
                Cookie::queue('SID', $session_id, 60 * 24 * 365);
            } 


            $visitor = Visitors::create([
                'ip_address'        => $ip_address,
                'unique_id'         => $session_id,
                'user_agent'        => $user_agent,
                'lat'               => $ip_info['latitude'],
                'lng'               => $ip_info['longitude'],
                'country'           => $ip_info['country'],
                'country_code'      => $ip_info['country_code'],
                'city'              => $ip_info['city'],
                'link_id'           => $decoded['id'],
                'unique_visit'      => 1
            ]);

            return redirect()->away($decoded['url']);
        }

        if ($session_id !== null) {
            $id_visited = Visitors::where('unique_id', '=', $session_id)
                                  ->where('user_agent', '=', $user_agent)
                                  ->where('link_id', '=', $decoded['id'])
                                  ->join('links', 'link_id', '=', 'links.id')
                                  ->exists();
            
            if ($id_visited) {
                $visitor = Visitors::create([
                    'ip_address'        => $ip_address,
                    'unique_id'         => $session_id,
                    'user_agent'        => $user_agent,
                    'lat'               => $ip_info['latitude'],
                    'lng'               => $ip_info['longitude'],
                    'country'           => $ip_info['country'],
                    'country_code'      => $ip_info['country_code'],
                    'city'              => $ip_info['city'],
                    'link_id'           => $decoded['id'],
                    'unique_visit'      => 0
                ]);

            } else {
                $visitor = Visitors::create([
                    'ip_address'        => $ip_address,
                    'unique_id'         => $session_id,
                    'user_agent'        => $user_agent,
                    'lat'               => $ip_info['latitude'],
                    'lng'               => $ip_info['longitude'],
                    'country'           => $ip_info['country'],
                    'country_code'      => $ip_info['country_code'],
                    'city'              => $ip_info['city'],
                    'link_id'           => $decoded['id'],
                    'unique_visit'      => 1
                ]);
            }
        }

        return redirect()->away($decoded['url']);
    }
}