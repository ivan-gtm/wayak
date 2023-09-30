<?php

namespace App\Traits;

trait LocaleTrait {

    public function getLocaleByCountry($country) {
        switch ($country) {
            case 'us':
            case 'ca':
                return 'en';
            case 'es':
            case 'mx':
            case 'co':
            case 'ar':
            case 'bo':
            case 'ch':
            case 'cu':
            case 'do':
            case 'sv':
            case 'hn':
            case 'ni':
            case 'pe':
            case 'uy':
            case 've':
            case 'py':
            case 'pa':
            case 'gt':
            case 'pr':
            case 'gq':
                return 'es';
            default:
                return 'en';
        }
    }
}
