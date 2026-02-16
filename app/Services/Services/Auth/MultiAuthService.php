<?php
namespace App\Services\Services\Auth;
use App\Models\{Admin,User};
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class MultiAuthService {
    public function login(array $credentials, ?string $type = null): array
    {
        $guard = $type === 'admin' ? 'admin-api' : 'user-api';
        if ($token = Auth::guard($guard)->attempt($credentials)) {
            return [
                'token' => $token,
                'user' => Auth::guard($guard)->user(),
            ];
        }

        return [
            'error' => true,
        ];
    }
}
