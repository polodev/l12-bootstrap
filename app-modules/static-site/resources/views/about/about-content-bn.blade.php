{{-- Hero Section --}}
<section class="relative bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-800 dark:to-blue-800 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">ইকো ট্রাভেল সম্পর্কে</h1>
            <p class="text-xl md:text-2xl mb-8">২০০৭ সাল থেকে আপনার বিশ্বস্ত ভ্রমণ সহযোগী</p>
            <p class="text-lg">নিউজিল্যান্ড ভিত্তিক বহুজাতিক ভ্রমণ সংস্থা বিশ্বব্যাপী উপস্থিতি সহ</p>
        </div>
    </div>
</section>

{{-- Company Overview --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-6">আমাদের গল্প</h2>
                <div class="prose prose-lg text-gray-600 dark:text-gray-300">
                    <p class="mb-4">
                        ইকো ট্রাভেলস একটি নিউজিল্যান্ড ভিত্তিক বহুজাতিক ভ্রমণ সংস্থা যা ২০০৭ সাল থেকে গ্রাহকদের সেবা প্রদান করে আসছে। 
                        যা নিউজিল্যান্ডের মাউন্ট আলবার্টে একটি ছোট ভ্রমণ সেবা হিসেবে শুরু হয়েছিল, তা এখন একটি বিশ্বব্যাপী নেটওয়ার্কে 
                        পরিণত হয়েছে যা একাধিক দেশ ও মহাদেশে বিস্তৃত।
                    </p>
                    <p class="mb-4">
                        আজ আমরা নিউজিল্যান্ড, অস্ট্রেলিয়া, ভারত এবং বাংলাদেশে কাজ করি, শুধুমাত্র নিউজিল্যান্ডেই ১৭টি ফ্র্যাঞ্চাইজি 
                        শাখা রয়েছে। ব্যতিক্রমী সেবা এবং গুণমানের প্রতি আমাদের প্রতিশ্রুতি আমাদের ভ্রমণ শিল্পে একটি বিশ্বস্ত নাম 
                        করে তুলেছে।
                    </p>
                    <p>
                        আমরা সকল ধরনের গ্রাহকদের জন্য সাশ্রয়ী ভ্রমণ প্যাকেজ বজায় রাখার পাশাপাশি অতুলনীয় ভ্রমণ অভিজ্ঞতা 
                        প্রদানে বিশেষজ্ঞ, দেশে ও বিদেশে টেকসই পর্যটন শিল্পে অবদান রাখি।
                    </p>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">প্রতিষ্ঠানের বিশেষত্ব</h3>
                @php
                $highlights = [
                    ['year' => '২০০৭', 'milestone' => 'নিউজিল্যান্ডের মাউন্ট আলবার্টে প্রতিষ্ঠিত'],
                    ['year' => '২০১৩', 'milestone' => 'অস্ট্রেলিয়ায় সম্প্রসারণ'],
                    ['year' => '২০১৬', 'milestone' => 'ভারতীয় বাজারে প্রবেশ'],
                    ['year' => '২০২২', 'milestone' => 'বাংলাদেশে কার্যক্রম শুরু'],
                    ['year' => 'এখন', 'milestone' => 'নিউজিল্যান্ডে ১৭টি ফ্র্যাঞ্চাইজি শাখা']
                ];
                @endphp
                
                @foreach($highlights as $highlight)
                <div class="flex items-start space-x-4 mb-4">
                    <div class="bg-blue-600 text-white px-3 py-1 rounded-full font-semibold text-sm">
                        {{ $highlight['year'] }}
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 flex-1">{{ $highlight['milestone'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Mission, Vision, Values --}}
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">আমাদের লক্ষ্য ও উদ্দেশ্য</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">যে নীতিমালা আমাদের উৎকর্ষতার প্রতিশ্রুতিকে পরিচালিত করে</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Mission --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-6">🎯</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">আমাদের লক্ষ্য</h3>
                <p class="text-gray-600 dark:text-gray-300 text-lg italic">
                    "বিশ্বব্যাপী ভ্রমণ শিল্পে সর্বোত্তম সেবার অভিজ্ঞতা প্রদান করা।"
                </p>
            </div>

            {{-- Vision Objectives --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                <div class="text-4xl mb-6 text-center">👁️</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6 text-center">আমাদের দৃষ্টিভঙ্গি</h3>
                @php
                $visionPoints = [
                    'ভিন্নধর্মী কাস্টমাইজড সেবা প্রদান',
                    'সকল ধরনের গ্রাহকের জন্য সাশ্রয়ী ভ্রমণ পরিকল্পনা',
                    'দেশে ও বিদেশে টেকসই পর্যটন শিল্পে অবদান'
                ];
                @endphp
                
                @foreach($visionPoints as $point)
                <div class="flex items-start space-x-3 mb-4">
                    <div class="text-blue-600 dark:text-blue-400 mt-1">✓</div>
                    <p class="text-gray-600 dark:text-gray-300">{{ $point }}</p>
                </div>
                @endforeach
            </div>

            {{-- Values --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-6">💎</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">আমাদের মূল্যবোধ</h3>
                <div class="space-y-3 text-gray-600 dark:text-gray-300">
                    <p><strong>উৎকর্ষতা:</strong> ব্যতিক্রমী সেবা ও গুণমান</p>
                    <p><strong>সাশ্রয়ী:</strong> অর্থের সর্বোত্তম মূল্য</p>
                    <p><strong>টেকসই:</strong> দায়িত্বশীল পর্যটন</p>
                    <p><strong>বিশ্বাস:</strong> স্মরণীয় ভ্রমণ যাত্রা</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Global Presence --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">বিশ্বব্যাপী উপস্থিতি</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">একাধিক দেশ ও মহাদেশে গ্রাহকদের সেবা প্রদান</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $countries = [
                [
                    'name' => 'নিউজিল্যান্ড',
                    'flag' => '🇳🇿',
                    'established' => '২০০৭',
                    'branches' => '১৭টি ফ্র্যাঞ্চাইজি শাখা',
                    'status' => 'প্রধান কার্যালয়'
                ],
                [
                    'name' => 'অস্ট্রেলিয়া',
                    'flag' => '🇦🇺',
                    'established' => '২০১৩',
                    'branches' => 'একাধিক অবস্থান',
                    'status' => 'আঞ্চলিক অফিস'
                ],
                [
                    'name' => 'ভারত',
                    'flag' => '🇮🇳',
                    'established' => '২০১৬',
                    'branches' => 'সেবা কেন্দ্র',
                    'status' => 'আঞ্চলিক অফিস'
                ],
                [
                    'name' => 'বাংলাদেশ',
                    'flag' => '🇧🇩',
                    'established' => '২০২২',
                    'branches' => 'ক্রমবর্ধমান নেটওয়ার্ক',
                    'status' => 'সর্বশেষ সংযোজন'
                ]
            ];
            @endphp

            @foreach($countries as $country)
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg text-center hover:shadow-lg transition-shadow">
                <div class="text-5xl mb-4">{{ $country['flag'] }}</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $country['name'] }}</h3>
                <p class="text-sm text-blue-600 dark:text-blue-400 mb-2">{{ $country['status'] }}</p>
                <p class="text-gray-600 dark:text-gray-300 text-sm mb-1">প্রতিষ্ঠিত {{ $country['established'] }}</p>
                <p class="text-gray-500 dark:text-gray-400 text-xs">{{ $country['branches'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Contact Information --}}
<section class="py-16 bg-gradient-to-r from-blue-600 to-green-600 dark:from-blue-800 dark:to-green-800 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">যোগাযোগ করুন</h2>
            <p class="text-xl">আপনার পরবর্তী অ্যাডভেঞ্চার শুরু করতে প্রস্তুত?</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="text-4xl mb-4">🏢</div>
                <h3 class="text-xl font-semibold mb-2">বাংলাদেশ অফিস</h3>
                <p class="text-sm opacity-90">হাউস ৩, রোড ১৬, সেক্টর ১১</p>
                <p class="text-sm opacity-90">উত্তরা, ঢাকা - ১২৩০, বাংলাদেশ</p>
            </div>
            
            <div class="text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-xl font-semibold mb-2">ফোন</h3>
                <p class="text-lg">+৮৮০৯৬৪৭৬৬৮৮২২</p>
            </div>
            
            <div class="text-center">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-xl font-semibold mb-2">ইমেইল</h3>
                <p class="text-lg">info@ecotravelsonline.com.bd</p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                আজই যোগাযোগ করুন
            </a>
        </div>
    </div>
</section>