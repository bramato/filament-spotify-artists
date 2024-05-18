<?php

namespace Bramato\FilamentSpotifyManager\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SpotifyWebAPI\Session as SpotifySession;
class SpotifyAuthController extends Controller
{
    public function redirect()
    {
        $session = new SpotifySession(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            env('SPOTIFY_REDIRECT_URI')
        );

        $options = [
            'scope' => [
                'user-read-email',
                'user-read-private',
                'user-library-read',
                'playlist-read-private',
            ],
        ];

        return redirect($session->getAuthorizeUrl($options));
    }

    public function callback(Request $request)
    {
        $session = new SpotifySession(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            env('SPOTIFY_REDIRECT_URI')
        );

        $session->requestAccessToken($request->input('code'));

        session([
            'spotify_access_token' => $session->getAccessToken(),
            'spotify_refresh_token' => $session->getRefreshToken(),
        ]);

        return redirect('/admin'); // Reindirizza dove necessario
    }
}