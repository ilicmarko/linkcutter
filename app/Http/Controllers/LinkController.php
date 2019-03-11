<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkShorteningRequest;
use App\Link;
use Illuminate\Support\MessageBag;

class LinkController extends Controller
{
    public function store(LinkShorteningRequest $request)
    {
        $request->validated();
        $url = request('url');

        try {
            $hash = URLFactory::generateShortLink(
                $url,
                request('is_tracked'),
                request('hash')
            );
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return response()
            ->json([
                'hash'  => $hash,
                'url'   => url($hash),
                'stats' => $this->calculateStats($url,$hash)
            ]);
    }

    private function calculateStats($url, $hash)
    {
        $diff = strlen($url) - strlen($hash);
        return [
            'length'    => $diff,
            'ration'    => $diff * strlen($url) * 100,
        ];
    }

    public function redirect(Link $link)
    {
        $long_url = $link->link;

        URLFactory::registerClick($link, request());
        return redirect()->to($long_url, 301);
    }

    public function linkVisits(Link $link)
    {
        $data = [];
        $series = [];
        $visits = $link->visits()->get()->toArray();

        foreach ($visits as $visit) {
            $series[] = $visit['lat'];
            $series[] = $visit['lng'];
            $series[] = 10;
        }
        $data[] = [
            'link', $series
        ];
        return response()->json($data);
    }

    public function destroy(Link $link)
    {
        try {
            $link->delete();
            return back()->with('success_msg', 'You have successfully delete your link!');
        } catch (\Exception $e) {
            $errors = new MessageBag();
            $errors->add('delete_error', 'Something went wrong!');

            return back()->withErrors($errors);
        }
    }
}
