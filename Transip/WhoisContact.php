<?php

/**
 * This class models a WhoisContact
 *
 * @package Transip
 * @class WhoisContact
 * @author TransIP (support@transip.nl)
 */
class Transip_WhoisContact
{
	const TYPE_REGISTRANT = 'registrant';
	const TYPE_ADMINISTRATIVE = 'administrative';
	const TYPE_TECHNICAL = 'technical';

	/**
	 * The possible company types with their respective descriptions
	 *
	 * @var array
	 * @nosoap
	 */
	public static $possibleCompanyTypes = array (
	  'BV' => 'BV - Besloten Vennootschap',
	  'BVI/O' => 'BV i.o. - BV in oprichting',
	  'COOP' => 'Cooperatie',
	  'CV' => 'CV - Commanditaire Vennootschap',
	  'EENMANSZAAK' => 'Eenmanszaak',
	  'KERK' => 'Kerkgenootschap',
	  'NV' => 'NV - Naamloze Vennootschap',
	  'OWM' => 'Onderlinge Waarborg Maatschappij',
	  'REDR' => 'Rederij',
	  'STICHTING' => 'Stichting',
	  'VERENIGING' => 'Vereniging',
	  'VOF' => 'VoF - Vennootschap onder firma',
	  'BEG' => 'Buitenlandse EG vennootschap',
	  'BRO' => 'Buitenlandse rechtsvorm/onderneming',
	  'EESV' => 'Europees Economisch Samenwerkingsverband',
	  'ANDERS' => 'Anders',
	  '' => 'Geen',
	);

	/**
	 * The possible country codes with their respective english names
	 *
	 * @var array
	 * @nosoap
	 */
	public static $possibleCountryCodes = array (
	  'af' => 'Afghanistan',
	  'al' => 'Albania',
	  'dz' => 'Algeria',
	  'as' => 'American Samoa',
	  'ad' => 'Andorra',
	  'ao' => 'Angola',
	  'ai' => 'Anguilla',
	  'aq' => 'Antarctica',
	  'ag' => 'Antigua and Barbuda',
	  'ar' => 'Argentina',
	  'am' => 'Armenia',
	  'aw' => 'Aruba',
	  'au' => 'Australia',
	  'at' => 'Austria',
	  'az' => 'Azerbaijan',
	  'bs' => 'Bahamas',
	  'bh' => 'Bahrain',
	  'bd' => 'Bangladesh',
	  'bb' => 'Barbados',
	  'by' => 'Belarus',
	  'be' => 'Belgium',
	  'bz' => 'Belize',
	  'bj' => 'Benin',
	  'bm' => 'Bermuda',
	  'bt' => 'Bhutan',
	  'bo' => 'Bolivia',
	  'ba' => 'Bosnia and Herzegovina',
	  'bw' => 'Botswana',
	  'bv' => 'Bouvet Island',
	  'br' => 'Brazil',
	  'io' => 'British Indian Ocean Territory',
	  'bn' => 'Brunei Darussalem',
	  'bg' => 'Bulgaria',
	  'bf' => 'Burkina Faso',
	  'bi' => 'Burundi',
	  'kh' => 'Cambodia',
	  'cm' => 'Cameroon',
	  'ca' => 'Canada',
	  'cv' => 'Cape Verde',
	  'ky' => 'Cayman Islands',
	  'cf' => 'Central African Republic',
	  'td' => 'Chad',
	  'cl' => 'Chile',
	  'cn' => 'China',
	  'cx' => 'Christmas Island',
	  'cc' => 'Cocos (Keeling) Islands',
	  'co' => 'Colombia',
	  'km' => 'Comoros',
	  'cg' => 'Congo',
	  'cd' => 'Congo, the Democratic Republic of the',
	  'ck' => 'Cook Islands',
	  'cr' => 'Costa Rica',
	  'hr' => 'Croatia',
	  'cu' => 'Cuba',
	  'cy' => 'Cyprus',
	  'cz' => 'Czech Republic',
	  'ci' => 'Côte d\'Ivoire',
	  'dk' => 'Denmark',
	  'dj' => 'Djibouti',
	  'dm' => 'Dominica',
	  'do' => 'Dominican Republic',
	  'ec' => 'Ecuador',
	  'eg' => 'Egypt',
	  'sv' => 'El Salvador',
	  'gq' => 'Equatorial Guinea',
	  'er' => 'Eritrea',
	  'ee' => 'Estonia',
	  'et' => 'Ethiopia',
	  'fk' => 'Falkland Islands (Malvinas)',
	  'fo' => 'Faroe Islands',
	  'fj' => 'Fiji',
	  'fi' => 'Finland',
	  'fr' => 'France',
	  'gf' => 'French Guiana',
	  'pf' => 'French Polynesia',
	  'tf' => 'French Southern Territories',
	  'ga' => 'Gabon',
	  'gm' => 'Gambia',
	  'ge' => 'Georgia',
	  'de' => 'Germany',
	  'gh' => 'Ghana',
	  'gi' => 'Gibraltar',
	  'gr' => 'Greece',
	  'gl' => 'Greenland',
	  'gd' => 'Grenada',
	  'gp' => 'Guadeloupe',
	  'gu' => 'Guam',
	  'gt' => 'Guatemala',
	  'gg' => 'Guernsey',
	  'gn' => 'Guinea',
	  'gw' => 'Guinea-Bissau',
	  'gy' => 'Guyana',
	  'ht' => 'Haiti',
	  'hm' => 'Heard Island and McDonald Islands',
	  'va' => 'Holy See (Vatican City State)',
	  'hn' => 'Honduras',
	  'hk' => 'Hong Kong',
	  'hu' => 'Hungary',
	  'is' => 'Iceland',
	  'in' => 'India',
	  'id' => 'Indonesia',
	  'ir' => 'Iran, Islamic Republic of',
	  'iq' => 'Iraq',
	  'ie' => 'Ireland',
	  'im' => 'Isle of Man',
	  'il' => 'Israel',
	  'it' => 'Italy',
	  'jm' => 'Jamaica',
	  'jp' => 'Japan',
	  'je' => 'Jersey',
	  'jo' => 'Jordan',
	  'kz' => 'Kazakhstan',
	  'ke' => 'Kenya',
	  'ki' => 'Kiribati',
	  'kp' => 'Korea, Democratic People\'s Republic of',
	  'kr' => 'Korea, Republic of',
	  'kw' => 'Kuwait',
	  'kg' => 'Kyrgyzstan',
	  'la' => 'Lao People\'s Democratic Republic',
	  'lv' => 'Latvia',
	  'lb' => 'Lebanon',
	  'ls' => 'Lesotho',
	  'lr' => 'Liberia',
	  'ly' => 'Libyan Arab Jamahiriya',
	  'li' => 'Liechtenstein',
	  'lt' => 'Lithuania',
	  'lu' => 'Luxembourg',
	  'mo' => 'Macao',
	  'mk' => 'Macedonia, the former Yugoslav Republic of',
	  'mg' => 'Madagascar',
	  'mw' => 'Malawi',
	  'my' => 'Malaysia',
	  'mv' => 'Maldives',
	  'ml' => 'Mali',
	  'mt' => 'Malta',
	  'mh' => 'Marshall Islands',
	  'mq' => 'Martinique',
	  'mr' => 'Mauritania',
	  'mu' => 'Mauritius',
	  'yt' => 'Mayotte',
	  'mx' => 'Mexico',
	  'fm' => 'Micronesia, Federated States of',
	  'md' => 'Moldova',
	  'mc' => 'Monaco',
	  'mn' => 'Mongolia',
	  'me' => 'Montenegro',
	  'ms' => 'Montserrat',
	  'ma' => 'Morocco',
	  'mz' => 'Mozambique',
	  'mm' => 'Myanmar',
	  'na' => 'Namibia',
	  'nr' => 'Nauru',
	  'np' => 'Nepal',
	  'nl' => 'Netherlands',
	  'an' => 'Netherlands Antilles',
	  'nc' => 'New Caledonia',
	  'nz' => 'New Zealand',
	  'ni' => 'Nicaragua',
	  'ne' => 'Niger',
	  'ng' => 'Nigeria',
	  'nu' => 'Niue',
	  'nf' => 'Norfolk Island',
	  'mp' => 'Northern Mariana Islands',
	  'no' => 'Norway',
	  'om' => 'Oman',
	  'pk' => 'Pakistan',
	  'pw' => 'Palau',
	  'ps' => 'Palestinian Territory, Occupied',
	  'pa' => 'Panama',
	  'pg' => 'Papua New Guinea',
	  'py' => 'Paraguay',
	  'pe' => 'Peru',
	  'ph' => 'Philippines',
	  'pn' => 'Pitcairn',
	  'pl' => 'Poland',
	  'pt' => 'Portugal',
	  'pr' => 'Puerto Rico',
	  'qa' => 'Qatar',
	  'ro' => 'Romania',
	  'ru' => 'Russian Federation',
	  'rw' => 'Rwanda',
	  're' => 'Réunion',
	  'bl' => 'Saint Barthélemy',
	  'sh' => 'Saint Helena',
	  'kn' => 'Saint Kitts and Nevis',
	  'lc' => 'Saint Lucia',
	  'mf' => 'Saint Martin (French part)',
	  'pm' => 'Saint Pierre and Miquelon',
	  'vc' => 'Saint Vincent and the Grenadines',
	  'ws' => 'Samoa',
	  'sm' => 'San Marino',
	  'st' => 'Sao Tome and Principe',
	  'sa' => 'Saudi Arabia',
	  'sn' => 'Senegal',
	  'rs' => 'Serbia',
	  'sc' => 'Seychelles',
	  'sl' => 'Sierra Leone',
	  'sg' => 'Singapore',
	  'sk' => 'Slovakia',
	  'si' => 'Slovenia',
	  'sb' => 'Solomon Islands',
	  'so' => 'Somalia',
	  'za' => 'South Africa',
	  'gs' => 'South Georgia and the South Sandwich Islands',
	  'es' => 'Spain',
	  'lk' => 'Sri Lanka',
	  'sd' => 'Sudan',
	  'sr' => 'Suriname',
	  'sj' => 'Svalbard and Jan Mayen',
	  'sz' => 'Swaziland',
	  'se' => 'Sweden',
	  'ch' => 'Switzerland',
	  'sy' => 'Syrian Arab Republic',
	  'tw' => 'Taiwan, Province of China',
	  'tj' => 'Tajikistan',
	  'tz' => 'Tanzania, United Republic of',
	  'th' => 'Thailand',
	  'tl' => 'Timor-Leste',
	  'tg' => 'Togo',
	  'tk' => 'Tokelau',
	  'to' => 'Tonga',
	  'tt' => 'Trinidad and Tobago',
	  'tn' => 'Tunisia',
	  'tr' => 'Turkey',
	  'tm' => 'Turkmenistan',
	  'tc' => 'Turks and Caicos Islands',
	  'tv' => 'Tuvalu',
	  'ug' => 'Uganda',
	  'ua' => 'Ukraine',
	  'ae' => 'United Arab Emirates',
	  'gb' => 'United Kingdom',
	  'us' => 'United States',
	  'um' => 'United States Minor Outlying Islands',
	  'uy' => 'Uruguay',
	  'uz' => 'Uzbekistan',
	  'vu' => 'Vanuatu',
	  've' => 'Venezuela',
	  'vn' => 'Viet Nam',
	  'vg' => 'Virgin Islands, British',
	  'vi' => 'Virgin Islands, U.S.',
	  'wf' => 'Wallis and Futuna',
	  'eh' => 'Western Sahara',
	  'ye' => 'Yemen',
	  'zm' => 'Zambia',
	  'zw' => 'Zimbabwe',
	  'ax' => 'Åland Islands',
	);

	/**
	 * The type of this Contact, owner, administrative or technical
	 *
	 * @var string
	 */
	public $type;

	/**
	 * The firstName of this Contact
	 *
	 * @var string
	 */
	public $firstName;

	/**
	 * The middleName of this Contact
	 *
	 * @var string
	 */
	public $middleName;

	/**
	 * The lastName of this Contact
	 *
	 * @var string
	 */
	public $lastName;

	/**
	 * The companyName of this Contact, in case of a company
	 *
	 * @var string
	 */
	public $companyName;

	/**
	 * The kvk number of this Contact, in case of a company
	 *
	 * @var string
	 */
	public $companyKvk;

	/**
	 * The type number of this Contact, in case of a company
	 *
	 * @var string
	 */
	public $companyType;

	/**
	 * The street of the address of this Contact
	 *
	 * @var string
	 */
	public $street;

	/**
	 * The number part of the address of this Contact
	 *
	 * @var string
	 */
	public $number;

	/**
	 * The postalCode part of the address of this Contact
	 *
	 * @var string
	 */
	public $postalCode;

	/**
	 * The city part of the address of this Contact
	 *
	 * @var string
	 */
	public $city;

	/**
	 * The phoneNumber of this Contact
	 *
	 * @var string
	 */
	public $phoneNumber;

	/**
	 * The faxNumber of this Contact
	 *
	 * @var string
	 */
	public $faxNumber;

	/**
	 * The email of this Contact
	 *
	 * @var string
	 */
	public $email;

	/**
	 * The country of this Contact, one of the ISO country abbrevs, must be lowercase.
	 *
	 * @var string
	 */
	public $country;
}
