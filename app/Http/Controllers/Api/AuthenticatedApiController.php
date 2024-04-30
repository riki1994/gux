<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AmiiboService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class AuthenticatedApiController extends Controller
{
    private $amiiboApi;
    public function __construct(AmiiboService $amiiboService)
    {
        $this->amiiboApi = $amiiboService;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws GuzzleException
     */
    public function me(Request $request)
    {
        $params = $request->validate([
            'id' => 'string|nullable',
            'amiiboSeries' => 'string|nullable',
            'character' => 'string|nullable',
            'gameSeries' => 'string|nullable',
            'head' => 'string|nullable',
            'image' => 'string|nullable',
            'name' => 'string|nullable',
            'release' => 'string|nullable',
            'tail' => 'string|nullable',
            'type' => 'string|nullable',
        ]);

        try {
            $amiibo = $this->amiiboApi->getAmiibo($params);
            $amiibo = json_decode($amiibo, true);
        } catch (GuzzleException $e) {
            $amiibo = [
                'amiibo' => [
                    'error' => 'Error fetching amiibo data.',
                    'details' => $e->getMessage()
                ]
            ];
        }

        return response()
            ->json([
                'user' => auth('api')->user(),
                ...$amiibo,
            ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout(true);

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh(true, true));
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
