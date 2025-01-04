<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Http\Requests\Auth\OrganizationLoginRequest;
use App\Http\Requests\Auth\OrganizationRegisterRequest;
use App\Http\Resources\Organization\OrganizationResource;
use App\Models\Organization;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

/**
 * @tags Авторизация
 */
class AuthController extends Controller
{
    /** Регистрация */
    public function register(OrganizationRegisterRequest $request): JsonResponse
    {
        /** @var Organization $organization */
        $organization = Organization::query()->create([
            'name' => $request->organizationDto->name,
            'inn' => $request->organizationDto->inn,
            'password' => $request->validated('password'),
        ]);

        $organization->assignRole(RolesEnum::ADMIN);

        return new JsonResponse([
            'status' => true,
            'access_token' => $organization->createToken($organization->inn)->plainTextToken,
            'type' => 'Bearer',
        ]);
    }

    /** Логин */
    public function login(OrganizationLoginRequest $request): JsonResponse
    {
        $organization = Organization::query()->firstWhere('inn', $request->validated('inn'));

        if (!is_null($organization) && Hash::check($request->validated('password'), $organization->password)) {
            return new JsonResponse([
                'status' => true,
                'access_token' => $organization->createToken($organization->inn)->plainTextToken,
                'type' => 'Bearer',
            ]);
        }

        return new JsonResponse([
            'status' => false,
        ], 404);
    }

    /** Данные об аккаунте */
    public function me(AuthManager $authManager): JsonResource
    {
        return new OrganizationResource($authManager->user());
    }
}
