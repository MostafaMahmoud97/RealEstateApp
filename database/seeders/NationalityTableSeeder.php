<?php

namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NationalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Nationalites = [
            [
                "title_en" => "Afghan",
                "title_ar" => "أفغاني",
            ],[
                "title_en" => "Albanian",
                "title_ar" => "ألباني",
            ],[
                "title_en" => "Algerian",
                "title_ar" => "جزائري",
            ],[
                "title_en" => "American",
                "title_ar" => "أمريكي",
            ],[
                "title_en" => "Andorran",
                "title_ar" => "أندوري",
            ],[
                "title_en" => "Angolan",
                "title_ar" => "أنغولي",
            ],[
                "title_en" => "Antiguans",
                "title_ar" => "انتيغوا",
            ],[
                "title_en" => "Argentinean",
                "title_ar" => "أرجنتيني",
            ],[
                "title_en" => "Armenian",
                "title_ar" => "أرميني",
            ],[
                "title_en" => "Australian",
                "title_ar" => "أسترالي",
            ],[
                "title_en" => "Austrian",
                "title_ar" => "نمساوي",
            ],[
                "title_en" => "Azerbaijani",
                "title_ar" => "أذربيجاني",
            ],[
                "title_en" => "Bahamian",
                "title_ar" => "باهامى",
            ],[
                "title_en" => "Bahraini",
                "title_ar" => "بحريني",
            ],[
                "title_en" => "Bangladeshi",
                "title_ar" => "بنجلاديشي",
            ],[
                "title_en" => "Barbadian",
                "title_ar" => "باربادوسي",
            ],[
                "title_en" => "Barbudans",
                "title_ar" => "بربودا",
            ],[
                "title_en" => "Batswana",
                "title_ar" => "بوتسواني",
            ],[
                "title_en" => "Belarusian",
                "title_ar" => "بيلاروسي",
            ],[
                "title_en" => "Belgian",
                "title_ar" => "بلجيكي",
            ],[
                "title_en" => "Belizean",
                "title_ar" => "بليزي",
            ],[
                "title_en" => "Beninese",
                "title_ar" => "بنيني",
            ],[
                "title_en" => "Bhutanese",
                "title_ar" => "بوتاني",
            ],[
                "title_en" => "Bolivian",
                "title_ar" => "بوليفي",
            ],[
                "title_en" => "Bosnian",
                "title_ar" => "بوسني",
            ],[
                "title_en" => "Brazilian",
                "title_ar" => "برازيلي",
            ],[
                "title_en" => "British",
                "title_ar" => "بريطاني",
            ],[
                "title_en" => "Bruneian",
                "title_ar" => "بروناى",
            ],[
                "title_en" => "Bulgarian",
                "title_ar" => "بلغاري",
            ],[
                "title_en" => "Burkinabe",
                "title_ar" => "بوركيني",
            ],[
                "title_en" => "Burmese",
                "title_ar" => "بورمي",
            ],[
                "title_en" => "Burundian",
                "title_ar" => "بوروندي",
            ],[
                "title_en" => "Cambodian",
                "title_ar" => "كمبودي",
            ],[
                "title_en" => "Cameroonian",
                "title_ar" => "كاميروني",
            ],[
                "title_en" => "Canadian",
                "title_ar" => "كندي",
            ],[
                "title_en" => "Cape Verdean",
                "title_ar" => "الرأس الأخضر",
            ],[
                "title_en" => "Central African",
                "title_ar" => "وسط أفريقيا",
            ],[
                "title_en" => "Chadian",
                "title_ar" => "تشادي",
            ],[
                "title_en" => "Chilean",
                "title_ar" => "شيلي",
            ],[
                "title_en" => "Chinese",
                "title_ar" => "صينى",
            ],[
                "title_en" => "Colombian",
                "title_ar" => "كولومبي",
            ],[
                "title_en" => "Comoran",
                "title_ar" => "جزر القمر",
            ],[
                "title_en" => "Congolese",
                "title_ar" => "كونغولي",
            ],[
                "title_en" => "Costa Rican",
                "title_ar" => "كوستاريكي",
            ],[
                "title_en" => "Croatian",
                "title_ar" => "كرواتية",
            ],[
                "title_en" => "Cuban",
                "title_ar" => "كوبي",
            ],[
                "title_en" => "Cypriot",
                "title_ar" => "قبرصي",
            ],[
                "title_en" => "Czech",
                "title_ar" => "تشيكي",
            ],[
                "title_en" => "Danish",
                "title_ar" => "دانماركي",
            ],[
                "title_en" => "Djibouti",
                "title_ar" => "جيبوتي",
            ],[
                "title_en" => "Dominican",
                "title_ar" => "دومينيكاني",
            ],[
                "title_en" => "Dutch",
                "title_ar" => "هولندي",
            ],[
                "title_en" => "East Timorese",
                "title_ar" => "تيموري شرقي",
            ],[
                "title_en" => "Ecuadorean",
                "title_ar" => "اكوادوري",
            ],[
                "title_en" => "Egyptian",
                "title_ar" => "مصري",
            ],[
                "title_en" => "Emirian",
                "title_ar" => "إماراتي",
            ],[
                "title_en" => "Equatorial Guinean",
                "title_ar" => "غيني  استوائي",
            ],[
                "title_en" => "Eritrean",
                "title_ar" => "إريتري",
            ],[
                "title_en" => "Estonian",
                "title_ar" => "إستوني",
            ],[
                "title_en" => "Ethiopian",
                "title_ar" => "حبشي",
            ],[
                "title_en" => "Fijian",
                "title_ar" => "فيجي",
            ],[
                "title_en" => "Filipino",
                "title_ar" => "فلبيني",
            ],[
                "title_en" => "Finnish",
                "title_ar" => "فنلندي",
            ],[
                "title_en" => "French",
                "title_ar" => "فرنسي",
            ],[
                "title_en" => "Gabonese",
                "title_ar" => "جابوني",
            ],[
                "title_en" => "Gambian",
                "title_ar" => "غامبيي",
            ],[
                "title_en" => "Georgian",
                "title_ar" => "جورجي",
            ],[
                "title_en" => "German",
                "title_ar" => "ألماني",
            ],[
                "title_en" => "Ghanaian",
                "title_ar" => "غاني",
            ],[
                "title_en" => "Greek",
                "title_ar" => "إغريقي",
            ],[
                "title_en" => "Grenadian",
                "title_ar" => "جرينادي",
            ],[
                "title_en" => "Guatemalan",
                "title_ar" => "غواتيمالي",
            ],[
                "title_en" => "Guinea-Bissauan",
                "title_ar" => "غيني بيساوي",
            ],[
                "title_en" => "Guinean",
                "title_ar" => "غيني",
            ],[
                "title_en" => "Guyanese",
                "title_ar" => "جوياني",
            ],[
                "title_en" => "Haitian",
                "title_ar" => "هايتي",
            ],[
                "title_en" => "Herzegovinian",
                "title_ar" => "هرسكي",
            ],[
                "title_en" => "Honduran",
                "title_ar" => "هندوراسي",
            ],[
                "title_en" => "Hungarian",
                "title_ar" => "هنغاري",
            ],[
                "title_en" => "Icelander",
                "title_ar" => "إيسلندي",
            ],[
                "title_en" => "Indian",
                "title_ar" => "هندي",
            ],[
                "title_en" => "Indonesian",
                "title_ar" => "إندونيسي",
            ],[
                "title_en" => "Iranian",
                "title_ar" => "إيراني",
            ],[
                "title_en" => "Iraqi",
                "title_ar" => "عراقي",
            ],[
                "title_en" => "Irish",
                "title_ar" => "إيرلندي",
            ],[
                "title_en" => "Italian",
                "title_ar" => "إيطالي",
            ],[
                "title_en" => "Ivorian",
                "title_ar" => "إفواري",
            ],[
                "title_en" => "Jamaican",
                "title_ar" => "جامايكي",
            ],[
                "title_en" => "Japanese",
                "title_ar" => "ياباني",
            ],[
                "title_en" => "Jordanian",
                "title_ar" => "أردني",
            ],[
                "title_en" => "Kazakhstani",
                "title_ar" => "كازاخستاني",
            ],[
                "title_en" => "Kenyan",
                "title_ar" => "كيني",
            ],[
                "title_en" => "Kittian and Nevisian",
                "title_ar" => "كيتياني ونيفيسياني",
            ],[
                "title_en" => "Kuwaiti",
                "title_ar" => "كويتي",
            ],[
                "title_en" => "Kyrgyz",
                "title_ar" => "قيرغيزستان",
            ],[
                "title_en" => "Laotian",
                "title_ar" => "لاوسي",
            ],[
                "title_en" => "Latvian",
                "title_ar" => "لاتفي",
            ],[
                "title_en" => "Lebanese",
                "title_ar" => "لبناني",
            ],[
                "title_en" => "Liberian",
                "title_ar" => "ليبيري",
            ],[
                "title_en" => "Libyan",
                "title_ar" => "ليبي",
            ],[
                "title_en" => "Liechtensteiner",
                "title_ar" => "ليختنشتايني",
            ],[
                "title_en" => "Lithuanian",
                "title_ar" => "لتواني",
            ],[
                "title_en" => "Luxembourger",
                "title_ar" => "لكسمبرغي",
            ],[
                "title_en" => "Macedonian",
                "title_ar" => "مقدوني",
            ],[
                "title_en" => "Malagasy",
                "title_ar" => "مدغشقري",
            ],[
                "title_en" => "Malawian",
                "title_ar" => "مالاوى",
            ],[
                "title_en" => "Malaysian",
                "title_ar" => "ماليزي",
            ],[
                "title_en" => "Maldivan",
                "title_ar" => "مالديفي",
            ],[
                "title_en" => "Malian",
                "title_ar" => "مالي",
            ],[
                "title_en" => "Maltese",
                "title_ar" => "مالطي",
            ],[
                "title_en" => "Marshallese",
                "title_ar" => "مارشالي",
            ],[
                "title_en" => "Mauritanian",
                "title_ar" => "موريتاني",
            ],[
                "title_en" => "Mauritian",
                "title_ar" => "موريشيوسي",
            ],[
                "title_en" => "Mexican",
                "title_ar" => "مكسيكي",
            ],[
                "title_en" => "Micronesian",
                "title_ar" => "ميكرونيزي",
            ],[
                "title_en" => "Moldovan",
                "title_ar" => "مولدوفي",
            ],[
                "title_en" => "Monacan",
                "title_ar" => "موناكو",
            ],[
                "title_en" => "Mongolian",
                "title_ar" => "منغولي",
            ],[
                "title_en" => "Moroccan",
                "title_ar" => "مغربي",
            ],[
                "title_en" => "Mosotho",
                "title_ar" => "ليسوتو",
            ],[
                "title_en" => "Motswana",
                "title_ar" => "لتسواني",
            ],[
                "title_en" => "Mozambican",
                "title_ar" => "موزمبيقي",
            ],[
                "title_en" => "Namibian",
                "title_ar" => "ناميبي",
            ],[
                "title_en" => "Nauruan",
                "title_ar" => "ناورو",
            ],[
                "title_en" => "Nepalese",
                "title_ar" => "نيبالي",
            ],[
                "title_en" => "New Zealander",
                "title_ar" => "نيوزيلندي",
            ],[
                "title_en" => "Ni-Vanuatu",
                "title_ar" => "ني فانواتي",
            ],[
                "title_en" => "Nicaraguan",
                "title_ar" => "نيكاراغوا",
            ],[
                "title_en" => "Nigerien",
                "title_ar" => "نيجري",
            ],[
                "title_en" => "North Korean",
                "title_ar" => "كوري شمالي",
            ],[
                "title_en" => "Northern Irish",
                "title_ar" => "إيرلندي شمالي",
            ],[
                "title_en" => "Norwegian",
                "title_ar" => "نرويجي",
            ],[
                "title_en" => "Omani",
                "title_ar" => "عماني",
            ],[
                "title_en" => "Pakistani",
                "title_ar" => "باكستاني",
            ],[
                "title_en" => "Palauan",
                "title_ar" => "بالاوي",
            ],[
                "title_en" => "Palestinian",
                "title_ar" => "فلسطيني",
            ],[
                "title_en" => "Panamanian",
                "title_ar" => "بنمي",
            ],[
                "title_en" => "Papua New Guinean",
                "title_ar" => "بابوا غينيا الجديدة",
            ],[
                "title_en" => "Paraguayan",
                "title_ar" => "باراغواياني",
            ],[
                "title_en" => "Peruvian",
                "title_ar" => "بيروفي",
            ],[
                "title_en" => "Polish",
                "title_ar" => "بولندي",
            ],[
                "title_en" => "Portuguese",
                "title_ar" => "برتغالي",
            ],[
                "title_en" => "Qatari",
                "title_ar" => "قطري",
            ],[
                "title_en" => "Romanian",
                "title_ar" => "روماني",
            ],[
                "title_en" => "Russian",
                "title_ar" => "روسي",
            ],[
                "title_en" => "Rwandan",
                "title_ar" => "رواندي",
            ],[
                "title_en" => "Saint Lucian",
                "title_ar" => "لوسياني",
            ],[
                "title_en" => "Salvadoran",
                "title_ar" => "سلفادوري",
            ],[
                "title_en" => "Samoan",
                "title_ar" => "ساموايان",
            ],[
                "title_en" => "San Marinese",
                "title_ar" => "سان مارينيز",
            ],[
                "title_en" => "Sao Tomean",
                "title_ar" => "ساو توميان",
            ],[
                "title_en" => "Saudi",
                "title_ar" => "سعودي",
            ],[
                "title_en" => "Scottish",
                "title_ar" => "سكتلندي",
            ],[
                "title_en" => "Senegalese",
                "title_ar" => "سنغالي",
            ],[
                "title_en" => "Serbian",
                "title_ar" => "صربي",
            ],[
                "title_en" => "Seychellois",
                "title_ar" => "سيشلي",
            ],[
                "title_en" => "Sierra Leonean",
                "title_ar" => "سيرا ليوني",
            ],[
                "title_en" => "Singaporean",
                "title_ar" => "سنغافوري",
            ],[
                "title_en" => "Slovakian",
                "title_ar" => "سلوفاكي",
            ],[
                "title_en" => "Slovenian",
                "title_ar" => "سلوفيني",
            ],[
                "title_en" => "Solomon Islander",
                "title_ar" => "جزر سليمان",
            ],[
                "title_en" => "Somali",
                "title_ar" => "صومالي",
            ],[
                "title_en" => "South African",
                "title_ar" => "جنوب افريقيي",
            ],[
                "title_en" => "South Korean",
                "title_ar" => "كوري جنوبي",
            ],[
                "title_en" => "Spanish",
                "title_ar" => "إسباني",
            ],[
                "title_en" => "Sri Lankan",
                "title_ar" => "سري لانكي",
            ],[
                "title_en" => "Sudanese",
                "title_ar" => "سوداني",
            ],[
                "title_en" => "Surinamer",
                "title_ar" => "سورينامي",
            ],[
                "title_en" => "Swazi",
                "title_ar" => "سوازي",
            ],[
                "title_en" => "Swedish",
                "title_ar" => "سويدي",
            ],[
                "title_en" => "Swiss",
                "title_ar" => "سويسري",
            ],[
                "title_en" => "Syrian",
                "title_ar" => "سوري",
            ],[
                "title_en" => "Taiwanese",
                "title_ar" => "تايواني",
            ],[
                "title_en" => "Tajik",
                "title_ar" => "طاجيكي",
            ],[
                "title_en" => "Tanzanian",
                "title_ar" => "تنزاني",
            ],[
                "title_en" => "Thai",
                "title_ar" => "التايلاندي",
            ],[
                "title_en" => "Togolese",
                "title_ar" => "توغواني",
            ],[
                "title_en" => "Tongan",
                "title_ar" => "تونجاني",
            ],[
                "title_en" => "Trinidadian or Tobagonian",
                "title_ar" => "ترينيدادي أو توباغوني",
            ],[
                "title_en" => "Tunisian",
                "title_ar" => "تونسي",
            ],[
                "title_en" => "Turkish",
                "title_ar" => "تركي",
            ],[
                "title_en" => "Tuvaluan",
                "title_ar" => "توفالي",
            ],[
                "title_en" => "Ugandan",
                "title_ar" => "أوغندي",
            ],[
                "title_en" => "Ukrainian",
                "title_ar" => "أوكراني",
            ],[
                "title_en" => "Uruguayan",
                "title_ar" => "أوروجواي",
            ],[
                "title_en" => "Uzbekistani",
                "title_ar" => "أوزبكستاني",
            ],[
                "title_en" => "Venezuelan",
                "title_ar" => "فنزويلي",
            ],[
                "title_en" => "Vietnamese",
                "title_ar" => "فيتنامي",
            ],[
                "title_en" => "Welsh",
                "title_ar" => "ويلزي",
            ],[
                "title_en" => "Yemenite",
                "title_ar" => "يمني",
            ],[
                "title_en" => "Zambian",
                "title_ar" => "زامبي",
            ],[
                "title_en" => "Zimbabwean",
                "title_ar" => "زيمبابوي",
            ]
        ];

        Nationality::truncate();
        foreach ($Nationalites as $nationality){
            Nationality::create($nationality);
        }
    }
}
