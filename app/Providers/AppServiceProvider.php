<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        Validator::extend('custom_location', function ($attribute, $value, $parameters, $validator) {
            // Check if the location starts with "K" or "k"
            if (strtolower(substr($value, 0, 1)) !== 'k') {
                return false;
            }

            $k = intval(substr($value, 1)); // Extracting the numeric part after 'K'
            if (!($k > -1 && $k <= 48)) {
                return false;
            }

            return true;
        });

        Validator::extend('ncr_chainages', function ($attribute, $value, $parameters, $validator) {
            // Split the input value by comma or space
            $chainages = preg_split('/[\s,]+/', $value);

            // Check each chainage individually
            foreach ($chainages as $chainage) {
                // Trim any whitespace
                $chainage = trim($chainage);

                // Check if the chainage starts with "K" or "k" followed by digits
                if (!preg_match('/^K\d+$/', $chainage, $matches)) {
                    return ['error' => 'Invalid chainage format', 'chainage' => $chainage];
                }

                // Extract the numeric part after 'K'
                $k = intval(substr($chainage, 1));

                // Check if the numeric part is within the range K0 to K48
                if (!($k >= 0 && $k <= 48)) {
                    return ['error' => 'Chainage out of range', 'chainage' => $chainage];
                }
            }

            return true;
        });


        Validator::extend('comma_separator', function ($attribute, $value, $parameters, $validator) {
            // Split the value by comma
            $chainages = preg_split('/,\s*(?=\bK)/', $value);

            // Check if any chainages are separated by a comma and space
            if (count($chainages) > 1) {
                return false; // Chainages are separated by a comma and space
            }

            // Check if any chainages are not followed by a comma
            if (preg_match('/\bK[^,]*\b(?![\s,])/', $value)) {
                return false; // Chainages are not separated by a comma
            }

            return true; // All chainages are separated by commas and spaces
        });

    }
}
