<?php

namespace Modules\UserData\Helpers;

class CountryListWithCountryCode
{
    /**
     * Get array of countries with country name, mobile code, and ISO 3166-1 alpha-3 code
     *
     * @return array
     */
    public static function getCountries(): array
    {
        return [
            'AFG' => ['name' => 'Afghanistan', 'code' => '+93'],
            'ALB' => ['name' => 'Albania', 'code' => '+355'],
            'DZA' => ['name' => 'Algeria', 'code' => '+213'],
            'ASM' => ['name' => 'American Samoa', 'code' => '+1684'],
            'AND' => ['name' => 'Andorra', 'code' => '+376'],
            'AGO' => ['name' => 'Angola', 'code' => '+244'],
            'AIA' => ['name' => 'Anguilla', 'code' => '+1264'],
            'ATA' => ['name' => 'Antarctica', 'code' => '+672'],
            'ATG' => ['name' => 'Antigua and Barbuda', 'code' => '+1268'],
            'ARG' => ['name' => 'Argentina', 'code' => '+54'],
            'ARM' => ['name' => 'Armenia', 'code' => '+374'],
            'ABW' => ['name' => 'Aruba', 'code' => '+297'],
            'AUS' => ['name' => 'Australia', 'code' => '+61'],
            'AUT' => ['name' => 'Austria', 'code' => '+43'],
            'AZE' => ['name' => 'Azerbaijan', 'code' => '+994'],
            'BHS' => ['name' => 'Bahamas', 'code' => '+1242'],
            'BHR' => ['name' => 'Bahrain', 'code' => '+973'],
            'BGD' => ['name' => 'Bangladesh', 'code' => '+880'],
            'BRB' => ['name' => 'Barbados', 'code' => '+1246'],
            'BLR' => ['name' => 'Belarus', 'code' => '+375'],
            'BEL' => ['name' => 'Belgium', 'code' => '+32'],
            'BLZ' => ['name' => 'Belize', 'code' => '+501'],
            'BEN' => ['name' => 'Benin', 'code' => '+229'],
            'BMU' => ['name' => 'Bermuda', 'code' => '+1441'],
            'BTN' => ['name' => 'Bhutan', 'code' => '+975'],
            'BOL' => ['name' => 'Bolivia', 'code' => '+591'],
            'BIH' => ['name' => 'Bosnia and Herzegovina', 'code' => '+387'],
            'BWA' => ['name' => 'Botswana', 'code' => '+267'],
            'BRA' => ['name' => 'Brazil', 'code' => '+55'],
            'IOT' => ['name' => 'British Indian Ocean Territory', 'code' => '+246'],
            'BRN' => ['name' => 'Brunei Darussalam', 'code' => '+673'],
            'BGR' => ['name' => 'Bulgaria', 'code' => '+359'],
            'BFA' => ['name' => 'Burkina Faso', 'code' => '+226'],
            'BDI' => ['name' => 'Burundi', 'code' => '+257'],
            'CPV' => ['name' => 'Cape Verde', 'code' => '+238'],
            'KHM' => ['name' => 'Cambodia', 'code' => '+855'],
            'CMR' => ['name' => 'Cameroon', 'code' => '+237'],
            'CAN' => ['name' => 'Canada', 'code' => '+1'],
            'CYM' => ['name' => 'Cayman Islands', 'code' => '+1345'],
            'CAF' => ['name' => 'Central African Republic', 'code' => '+236'],
            'TCD' => ['name' => 'Chad', 'code' => '+235'],
            'CHL' => ['name' => 'Chile', 'code' => '+56'],
            'CHN' => ['name' => 'China', 'code' => '+86'],
            'CXR' => ['name' => 'Christmas Island', 'code' => '+61'],
            'CCK' => ['name' => 'Cocos (Keeling) Islands', 'code' => '+61'],
            'COL' => ['name' => 'Colombia', 'code' => '+57'],
            'COM' => ['name' => 'Comoros', 'code' => '+269'],
            'COG' => ['name' => 'Congo', 'code' => '+242'],
            'COD' => ['name' => 'Congo, Democratic Republic', 'code' => '+243'],
            'COK' => ['name' => 'Cook Islands', 'code' => '+682'],
            'CRI' => ['name' => 'Costa Rica', 'code' => '+506'],
            'CIV' => ['name' => 'Cote d\'Ivoire', 'code' => '+225'],
            'HRV' => ['name' => 'Croatia', 'code' => '+385'],
            'CUB' => ['name' => 'Cuba', 'code' => '+53'],
            'CUW' => ['name' => 'Curaçao', 'code' => '+599'],
            'CYP' => ['name' => 'Cyprus', 'code' => '+357'],
            'CZE' => ['name' => 'Czech Republic', 'code' => '+420'],
            'DNK' => ['name' => 'Denmark', 'code' => '+45'],
            'DJI' => ['name' => 'Djibouti', 'code' => '+253'],
            'DMA' => ['name' => 'Dominica', 'code' => '+1767'],
            'DOM' => ['name' => 'Dominican Republic', 'code' => '+1849'],
            'ECU' => ['name' => 'Ecuador', 'code' => '+593'],
            'EGY' => ['name' => 'Egypt', 'code' => '+20'],
            'SLV' => ['name' => 'El Salvador', 'code' => '+503'],
            'GNQ' => ['name' => 'Equatorial Guinea', 'code' => '+240'],
            'ERI' => ['name' => 'Eritrea', 'code' => '+291'],
            'EST' => ['name' => 'Estonia', 'code' => '+372'],
            'ETH' => ['name' => 'Ethiopia', 'code' => '+251'],
            'FLK' => ['name' => 'Falkland Islands', 'code' => '+500'],
            'FRO' => ['name' => 'Faroe Islands', 'code' => '+298'],
            'FJI' => ['name' => 'Fiji', 'code' => '+679'],
            'FIN' => ['name' => 'Finland', 'code' => '+358'],
            'FRA' => ['name' => 'France', 'code' => '+33'],
            'GUF' => ['name' => 'French Guiana', 'code' => '+594'],
            'PYF' => ['name' => 'French Polynesia', 'code' => '+689'],
            'GAB' => ['name' => 'Gabon', 'code' => '+241'],
            'GMB' => ['name' => 'Gambia', 'code' => '+220'],
            'GEO' => ['name' => 'Georgia', 'code' => '+995'],
            'DEU' => ['name' => 'Germany', 'code' => '+49'],
            'GHA' => ['name' => 'Ghana', 'code' => '+233'],
            'GIB' => ['name' => 'Gibraltar', 'code' => '+350'],
            'GRC' => ['name' => 'Greece', 'code' => '+30'],
            'GRL' => ['name' => 'Greenland', 'code' => '+299'],
            'GRD' => ['name' => 'Grenada', 'code' => '+1473'],
            'GLP' => ['name' => 'Guadeloupe', 'code' => '+590'],
            'GUM' => ['name' => 'Guam', 'code' => '+1671'],
            'GTM' => ['name' => 'Guatemala', 'code' => '+502'],
            'GGY' => ['name' => 'Guernsey', 'code' => '+44'],
            'GIN' => ['name' => 'Guinea', 'code' => '+224'],
            'GNB' => ['name' => 'Guinea-Bissau', 'code' => '+245'],
            'GUY' => ['name' => 'Guyana', 'code' => '+592'],
            'HTI' => ['name' => 'Haiti', 'code' => '+509'],
            'VAT' => ['name' => 'Holy See (Vatican City)', 'code' => '+39'],
            'HND' => ['name' => 'Honduras', 'code' => '+504'],
            'HKG' => ['name' => 'Hong Kong', 'code' => '+852'],
            'HUN' => ['name' => 'Hungary', 'code' => '+36'],
            'ISL' => ['name' => 'Iceland', 'code' => '+354'],
            'IND' => ['name' => 'India', 'code' => '+91'],
            'IDN' => ['name' => 'Indonesia', 'code' => '+62'],
            'IRN' => ['name' => 'Iran', 'code' => '+98'],
            'IRQ' => ['name' => 'Iraq', 'code' => '+964'],
            'IRL' => ['name' => 'Ireland', 'code' => '+353'],
            'IMN' => ['name' => 'Isle of Man', 'code' => '+44'],
            'ISR' => ['name' => 'Israel', 'code' => '+972'],
            'ITA' => ['name' => 'Italy', 'code' => '+39'],
            'JAM' => ['name' => 'Jamaica', 'code' => '+1876'],
            'JPN' => ['name' => 'Japan', 'code' => '+81'],
            'JEY' => ['name' => 'Jersey', 'code' => '+44'],
            'JOR' => ['name' => 'Jordan', 'code' => '+962'],
            'KAZ' => ['name' => 'Kazakhstan', 'code' => '+7'],
            'KEN' => ['name' => 'Kenya', 'code' => '+254'],
            'KIR' => ['name' => 'Kiribati', 'code' => '+686'],
            'PRK' => ['name' => 'Korea, Democratic People\'s Republic of', 'code' => '+850'],
            'KOR' => ['name' => 'Korea, Republic of', 'code' => '+82'],
            'KWT' => ['name' => 'Kuwait', 'code' => '+965'],
            'KGZ' => ['name' => 'Kyrgyzstan', 'code' => '+996'],
            'LAO' => ['name' => 'Laos', 'code' => '+856'],
            'LVA' => ['name' => 'Latvia', 'code' => '+371'],
            'LBN' => ['name' => 'Lebanon', 'code' => '+961'],
            'LSO' => ['name' => 'Lesotho', 'code' => '+266'],
            'LBR' => ['name' => 'Liberia', 'code' => '+231'],
            'LBY' => ['name' => 'Libya', 'code' => '+218'],
            'LIE' => ['name' => 'Liechtenstein', 'code' => '+423'],
            'LTU' => ['name' => 'Lithuania', 'code' => '+370'],
            'LUX' => ['name' => 'Luxembourg', 'code' => '+352'],
            'MAC' => ['name' => 'Macao', 'code' => '+853'],
            'MKD' => ['name' => 'Macedonia', 'code' => '+389'],
            'MDG' => ['name' => 'Madagascar', 'code' => '+261'],
            'MWI' => ['name' => 'Malawi', 'code' => '+265'],
            'MYS' => ['name' => 'Malaysia', 'code' => '+60'],
            'MDV' => ['name' => 'Maldives', 'code' => '+960'],
            'MLI' => ['name' => 'Mali', 'code' => '+223'],
            'MLT' => ['name' => 'Malta', 'code' => '+356'],
            'MHL' => ['name' => 'Marshall Islands', 'code' => '+692'],
            'MTQ' => ['name' => 'Martinique', 'code' => '+596'],
            'MRT' => ['name' => 'Mauritania', 'code' => '+222'],
            'MUS' => ['name' => 'Mauritius', 'code' => '+230'],
            'MYT' => ['name' => 'Mayotte', 'code' => '+262'],
            'MEX' => ['name' => 'Mexico', 'code' => '+52'],
            'FSM' => ['name' => 'Micronesia', 'code' => '+691'],
            'MDA' => ['name' => 'Moldova', 'code' => '+373'],
            'MCO' => ['name' => 'Monaco', 'code' => '+377'],
            'MNG' => ['name' => 'Mongolia', 'code' => '+976'],
            'MNE' => ['name' => 'Montenegro', 'code' => '+382'],
            'MSR' => ['name' => 'Montserrat', 'code' => '+1664'],
            'MAR' => ['name' => 'Morocco', 'code' => '+212'],
            'MOZ' => ['name' => 'Mozambique', 'code' => '+258'],
            'MMR' => ['name' => 'Myanmar', 'code' => '+95'],
            'NAM' => ['name' => 'Namibia', 'code' => '+264'],
            'NRU' => ['name' => 'Nauru', 'code' => '+674'],
            'NPL' => ['name' => 'Nepal', 'code' => '+977'],
            'NLD' => ['name' => 'Netherlands', 'code' => '+31'],
            'NCL' => ['name' => 'New Caledonia', 'code' => '+687'],
            'NZL' => ['name' => 'New Zealand', 'code' => '+64'],
            'NIC' => ['name' => 'Nicaragua', 'code' => '+505'],
            'NER' => ['name' => 'Niger', 'code' => '+227'],
            'NGA' => ['name' => 'Nigeria', 'code' => '+234'],
            'NIU' => ['name' => 'Niue', 'code' => '+683'],
            'NFK' => ['name' => 'Norfolk Island', 'code' => '+672'],
            'MNP' => ['name' => 'Northern Mariana Islands', 'code' => '+1670'],
            'NOR' => ['name' => 'Norway', 'code' => '+47'],
            'OMN' => ['name' => 'Oman', 'code' => '+968'],
            'PAK' => ['name' => 'Pakistan', 'code' => '+92'],
            'PLW' => ['name' => 'Palau', 'code' => '+680'],
            'PSE' => ['name' => 'Palestine', 'code' => '+970'],
            'PAN' => ['name' => 'Panama', 'code' => '+507'],
            'PNG' => ['name' => 'Papua New Guinea', 'code' => '+675'],
            'PRY' => ['name' => 'Paraguay', 'code' => '+595'],
            'PER' => ['name' => 'Peru', 'code' => '+51'],
            'PHL' => ['name' => 'Philippines', 'code' => '+63'],
            'PCN' => ['name' => 'Pitcairn', 'code' => '+64'],
            'POL' => ['name' => 'Poland', 'code' => '+48'],
            'PRT' => ['name' => 'Portugal', 'code' => '+351'],
            'PRI' => ['name' => 'Puerto Rico', 'code' => '+1787'],
            'QAT' => ['name' => 'Qatar', 'code' => '+974'],
            'REU' => ['name' => 'Réunion', 'code' => '+262'],
            'ROU' => ['name' => 'Romania', 'code' => '+40'],
            'RUS' => ['name' => 'Russia', 'code' => '+7'],
            'RWA' => ['name' => 'Rwanda', 'code' => '+250'],
            'BLM' => ['name' => 'Saint Barthélemy', 'code' => '+590'],
            'SHN' => ['name' => 'Saint Helena', 'code' => '+290'],
            'KNA' => ['name' => 'Saint Kitts and Nevis', 'code' => '+1869'],
            'LCA' => ['name' => 'Saint Lucia', 'code' => '+1758'],
            'MAF' => ['name' => 'Saint Martin (French)', 'code' => '+590'],
            'SPM' => ['name' => 'Saint Pierre and Miquelon', 'code' => '+508'],
            'VCT' => ['name' => 'Saint Vincent and the Grenadines', 'code' => '+1784'],
            'WSM' => ['name' => 'Samoa', 'code' => '+685'],
            'SMR' => ['name' => 'San Marino', 'code' => '+378'],
            'STP' => ['name' => 'Sao Tome and Principe', 'code' => '+239'],
            'SAU' => ['name' => 'Saudi Arabia', 'code' => '+966'],
            'SEN' => ['name' => 'Senegal', 'code' => '+221'],
            'SRB' => ['name' => 'Serbia', 'code' => '+381'],
            'SYC' => ['name' => 'Seychelles', 'code' => '+248'],
            'SLE' => ['name' => 'Sierra Leone', 'code' => '+232'],
            'SGP' => ['name' => 'Singapore', 'code' => '+65'],
            'SXM' => ['name' => 'Sint Maarten (Dutch)', 'code' => '+1721'],
            'SVK' => ['name' => 'Slovakia', 'code' => '+421'],
            'SVN' => ['name' => 'Slovenia', 'code' => '+386'],
            'SLB' => ['name' => 'Solomon Islands', 'code' => '+677'],
            'SOM' => ['name' => 'Somalia', 'code' => '+252'],
            'ZAF' => ['name' => 'South Africa', 'code' => '+27'],
            'SGS' => ['name' => 'South Georgia and South Sandwich Islands', 'code' => '+500'],
            'SSD' => ['name' => 'South Sudan', 'code' => '+211'],
            'ESP' => ['name' => 'Spain', 'code' => '+34'],
            'LKA' => ['name' => 'Sri Lanka', 'code' => '+94'],
            'SDN' => ['name' => 'Sudan', 'code' => '+249'],
            'SUR' => ['name' => 'Suriname', 'code' => '+597'],
            'SJM' => ['name' => 'Svalbard and Jan Mayen', 'code' => '+47'],
            'SWZ' => ['name' => 'Swaziland', 'code' => '+268'],
            'SWE' => ['name' => 'Sweden', 'code' => '+46'],
            'CHE' => ['name' => 'Switzerland', 'code' => '+41'],
            'SYR' => ['name' => 'Syria', 'code' => '+963'],
            'TWN' => ['name' => 'Taiwan', 'code' => '+886'],
            'TJK' => ['name' => 'Tajikistan', 'code' => '+992'],
            'TZA' => ['name' => 'Tanzania', 'code' => '+255'],
            'THA' => ['name' => 'Thailand', 'code' => '+66'],
            'TLS' => ['name' => 'Timor-Leste', 'code' => '+670'],
            'TGO' => ['name' => 'Togo', 'code' => '+228'],
            'TKL' => ['name' => 'Tokelau', 'code' => '+690'],
            'TON' => ['name' => 'Tonga', 'code' => '+676'],
            'TTO' => ['name' => 'Trinidad and Tobago', 'code' => '+1868'],
            'TUN' => ['name' => 'Tunisia', 'code' => '+216'],
            'TUR' => ['name' => 'Turkey', 'code' => '+90'],
            'TKM' => ['name' => 'Turkmenistan', 'code' => '+993'],
            'TCA' => ['name' => 'Turks and Caicos Islands', 'code' => '+1649'],
            'TUV' => ['name' => 'Tuvalu', 'code' => '+688'],
            'UGA' => ['name' => 'Uganda', 'code' => '+256'],
            'UKR' => ['name' => 'Ukraine', 'code' => '+380'],
            'ARE' => ['name' => 'United Arab Emirates', 'code' => '+971'],
            'GBR' => ['name' => 'United Kingdom', 'code' => '+44'],
            'USA' => ['name' => 'United States', 'code' => '+1'],
            'UMI' => ['name' => 'United States Minor Outlying Islands', 'code' => '+1'],
            'URY' => ['name' => 'Uruguay', 'code' => '+598'],
            'UZB' => ['name' => 'Uzbekistan', 'code' => '+998'],
            'VUT' => ['name' => 'Vanuatu', 'code' => '+678'],
            'VEN' => ['name' => 'Venezuela', 'code' => '+58'],
            'VNM' => ['name' => 'Vietnam', 'code' => '+84'],
            'VGB' => ['name' => 'Virgin Islands (British)', 'code' => '+1284'],
            'VIR' => ['name' => 'Virgin Islands (U.S.)', 'code' => '+1340'],
            'WLF' => ['name' => 'Wallis and Futuna', 'code' => '+681'],
            'ESH' => ['name' => 'Western Sahara', 'code' => '+212'],
            'YEM' => ['name' => 'Yemen', 'code' => '+967'],
            'ZMB' => ['name' => 'Zambia', 'code' => '+260'],
            'ZWE' => ['name' => 'Zimbabwe', 'code' => '+263']
        ];
    }

    /**
     * Get country options for select dropdown
     *
     * @return array
     */
    public static function getCountryOptions(): array
    {
        $countries = self::getCountries();
        $options = [];
        
        foreach ($countries as $alpha3 => $country) {
            $options[$alpha3] = $country['name'] . ' (' . $country['code'] . ')';
        }
        
        return $options;
    }

    /**
     * Get country code by alpha-3 code
     *
     * @param string $alpha3
     * @return string|null
     */
    public static function getCountryCode(string $alpha3): ?string
    {
        $countries = self::getCountries();
        return $countries[$alpha3]['code'] ?? null;
    }

    /**
     * Get country name by alpha-3 code
     *
     * @param string $alpha3
     * @return string|null
     */
    public static function getCountryName(string $alpha3): ?string
    {
        $countries = self::getCountries();
        return $countries[$alpha3]['name'] ?? null;
    }

    /**
     * Get alpha-3 code by country code
     *
     * @param string $countryCode
     * @return string|null
     */
    public static function getAlpha3ByCode(string $countryCode): ?string
    {
        $countries = self::getCountries();
        
        foreach ($countries as $alpha3 => $country) {
            if ($country['code'] === $countryCode) {
                return $alpha3;
            }
        }
        
        return null;
    }
}