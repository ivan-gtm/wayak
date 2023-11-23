<?php

namespace App\Traits;

trait LocaleTrait
{

    public function getLocaleByCountry($country)
    {
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
            case 'fr':
            case 'be':
            case 'ch':
            case 'mc':
            case 'lu':
            case 'bj':
            case 'bf':
            case 'bi':
            case 'cm':
            case 'cf':
            case 'td':
            case 'km':
            case 'cg':
            case 'cd':
            case 'dj':
            case 'gq':
            case 'ga':
            case 'gn':
            case 'ci':
            case 'mg':
            case 'ml':
            case 'ne':
            case 'rw':
            case 'sn':
            case 'sc':
            case 'tg':
            case 'vu':
            case 'ht':
                return 'fr';
            case 'pt':
            case 'br':
            case 'ao':
            case 'mz':
            case 'cv':
            case 'gw':
            case 'st':
            case 'tl':
            case 'gq':
            case 'mo':
                return 'pt';
            default:
                return 'en';
        }
    }
}
