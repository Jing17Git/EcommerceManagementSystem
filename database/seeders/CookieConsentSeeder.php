<?php

namespace Database\Seeders;

use App\Models\CookieConsent;
use Illuminate\Database\Seeder;

class CookieConsentSeeder extends Seeder
{
    public function run(): void
    {
        CookieConsent::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'We use cookies',
                'message' => 'We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.',
                'accept_button_text' => 'Accept All',
                'decline_button_text' => 'Decline',
                'is_enabled' => true
            ]
        );
    }
}
