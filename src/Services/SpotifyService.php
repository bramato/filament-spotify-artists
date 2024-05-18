<?php

namespace Bramato\FilamentSpotifyManager\Services;

use Bramato\FilamentSpotifyManager\Models\Album;
use Bramato\FilamentSpotifyManager\Models\Artist;
use Bramato\FilamentSpotifyManager\Models\Song;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyService
{
    protected $api;

    public function __construct()
    {
        $session = new Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            env('SPOTIFY_REDIRECT_URI')
        );

        if (session()->has('spotify_access_token')) {
            $session->setAccessToken(session('spotify_access_token'));
            $session->setRefreshToken(session('spotify_refresh_token'));

            if ($session->refreshAccessToken()) {
                session(['spotify_access_token' => $session->getAccessToken()]);
            }
        } else {
            $options = [
                'scope' => [
                    'user-read-email',
                    'user-read-private',
                    'user-library-read',
                    'playlist-read-private',
                ],
            ];

            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
        }

        $this->api = new SpotifyWebAPI();
        $this->api->setAccessToken($session->getAccessToken());
    }

    public function getArtistData($spotifyId, User $user)
    {
        $artist = $this->api->getArtist($spotifyId);

        $artistModel = Artist::updateOrCreate(
            ['spotify_id' => $spotifyId],
            [
                'name' => $artist->name,
                'genre' => $artist->genres[0] ?? null,
                'image_url' => $artist->images[0]->url ?? null,
            ]
        );

        $user->artists()->syncWithoutDetaching([$artistModel->id]);

        $this->getArtistAlbums($artistModel, $spotifyId);

        return $artistModel;
    }

    protected function getArtistAlbums(Artist $artist, $spotifyId)
    {
        $albums = $this->api->getArtistAlbums($spotifyId)->items;

        foreach ($albums as $album) {
            $albumModel = Album::updateOrCreate(
                ['spotify_id' => $album->id],
                [
                    'artist_id' => $artist->id,
                    'name' => $album->name,
                    'release_date' => $album->release_date,
                    'cover_url' => $album->images[0]->url ?? null,
                ]
            );

            $this->getAlbumTracks($albumModel, $album->id);
        }
    }

    protected function getAlbumTracks(Album $album, $spotifyId)
    {
        $tracks = $this->api->getAlbumTracks($spotifyId)->items;

        foreach ($tracks as $track) {
            Song::updateOrCreate(
                ['spotify_id' => $track->id],
                [
                    'album_id' => $album->id,
                    'name' => $track->name,
                    'duration_ms' => $track->duration_ms,
                ]
            );
        }
    }
}