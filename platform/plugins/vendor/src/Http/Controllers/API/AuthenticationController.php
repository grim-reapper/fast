<?php

namespace Fast\Vendor\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\Vendor\Http\Requests\LoginRequest;
use Fast\Vendor\Http\Requests\RegisterRequest;
use Fast\Vendor\Notifications\API\ConfirmEmailNotification;
use Fast\Vendor\Repositories\Interfaces\VendorInterface;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\Token;

class AuthenticationController extends Controller
{
    use RegistersUsers;

    /**
     * @var VendorInterface
     */
    protected $vendorRepository;

    /**
     * AuthenticationController constructor.
     *
     * @param VendorInterface $vendorRepository
     */
    public function __construct(VendorInterface $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    /**
     * Register
     *
     * @bodyParam first_name string required The name of the user.
     * @bodyParam last_name string required The name of the user.
     * @bodyParam email string required The email of the user.
     * @bodyParam phone string required The phone of the user.
     * @bodyParam password string  required The password of user to create.
     *
     * @response {
     * "error": false,
     * "data": null,
     * "message": "Registered successfully! We sent an email to you to verify your account!"
     * }
     * @response 422 {
     * "message": "The given data was invalid.",
     * "errors": {
     *     "first_name": [
     *         "The first name field is required."
     *     ],
     *     "last_name": [
     *         "The last name field is required."
     *     ],
     *     "email": [
     *         "The email field is required."
     *     ],
     *     "password": [
     *         "The password field is required."
     *     ]
     *   }
     * }
     *
     * @group Authentication
     *
     * @param RegisterRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function register(RegisterRequest $request, BaseHttpResponse $response)
    {
        $request->merge(['password' => bcrypt($request->input('password'))]);

        $vendor = $this->vendorRepository->create($request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'password',
        ]));

        $token = Hash::make(Str::random(32));

        $vendor->email_verify_token = $token;
        $vendor->save();

        $vendor->notify(new ConfirmEmailNotification($token));

        return $response
            ->setMessage(__('Registered successfully! We sent an email to you to verify your account!'));
    }

    /**
     * Login
     *
     * @bodyParam login string required The email/phone of the user.
     * @bodyParam password string required The password of user to create.
     *
     * @response {
     * "error": false,
     * "data": {
     *    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0xxx"
     * },
     * "message": null
     * }
     *
     * @group Authentication
     *
     * @param LoginRequest $request
     * @param BaseHttpResponse $response
     *
     * @return BaseHttpResponse
     */
    public function login(LoginRequest $request, BaseHttpResponse $response)
    {
        if (Auth::guard('vendor')->attempt([
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            $token = Auth::guard('vendor')->user()->createToken('Laravel Password Grant Client')->accessToken;

            return $response
                ->setData(['token' => $token]);
        }

        return $response
            ->setError()
            ->setCode(422)
            ->setMessage(__('Email or password is not correct!'));
    }

    /**
     * Logout
     *
     * @group Authentication
     * @authenticated
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function logout(Request $request, BaseHttpResponse $response)
    {
        /**
         * @var Token $token
         */
        $token = $request->user()->token();
        $token->revoke();

        return $response
            ->setMessage(__('You have been successfully logged out!'));
    }
}
