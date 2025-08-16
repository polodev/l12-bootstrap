{{-- Hero Section --}}
<section class="relative bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-800 dark:to-blue-800 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">About Eco Travel</h1>
            <p class="text-xl md:text-2xl mb-8">Your trusted travel partner since 2007</p>
            <p class="text-lg">New Zealand-based multinational travel agency with global presence</p>
        </div>
    </div>
</section>

{{-- Company Overview --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-6">Our Story</h2>
                <div class="prose prose-lg text-gray-600 dark:text-gray-300">
                    <p class="mb-4">
                        Eco Travels is a New Zealand-based multinational travel agency that has been serving customers since 2007. 
                        What started as a small travel service in Mt Albert, New Zealand, has grown into a global network spanning 
                        multiple countries and continents.
                    </p>
                    <p class="mb-4">
                        Today, we operate in New Zealand, Australia, India, and Bangladesh, with 17 franchise branches across 
                        New Zealand alone. Our commitment to exceptional service and quality has made us a trusted name in 
                        the travel industry.
                    </p>
                    <p>
                        We specialize in providing unparalleled travel experiences while maintaining affordable travel packages 
                        for all kinds of customers, contributing towards sustainable tourism industry both home and abroad.
                    </p>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Company Highlights</h3>
                @php
                $highlights = [
                    ['year' => '2007', 'milestone' => 'Founded in Mt Albert, New Zealand'],
                    ['year' => '2013', 'milestone' => 'Expanded to Australia'],
                    ['year' => '2016', 'milestone' => 'Entered Indian market'],
                    ['year' => '2022', 'milestone' => 'Launched operations in Bangladesh'],
                    ['year' => 'Now', 'milestone' => '17 franchise branches across New Zealand']
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Our Mission & Vision</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Guiding principles that drive our commitment to excellence</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Mission --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-6">🎯</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Our Mission</h3>
                <p class="text-gray-600 dark:text-gray-300 text-lg italic">
                    "To provide best service Experience towards Travel Industry All over the World."
                </p>
            </div>

            {{-- Vision Objectives --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                <div class="text-4xl mb-6 text-center">👁️</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6 text-center">Our Vision</h3>
                @php
                $visionPoints = [
                    'Deliver differentiated customized service',
                    'Affordable travels plan for all kinds of customers',
                    'Contribution towards sustainable tourism industry home and abroad'
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
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Our Values</h3>
                <div class="space-y-3 text-gray-600 dark:text-gray-300">
                    <p><strong>Excellence:</strong> Exceptional service and quality</p>
                    <p><strong>Affordability:</strong> Best value for money</p>
                    <p><strong>Sustainability:</strong> Responsible tourism</p>
                    <p><strong>Trust:</strong> Memorable travel journeys</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Global Presence --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Global Presence</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Serving customers across multiple countries and continents</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $countries = [
                [
                    'name' => 'New Zealand',
                    'flag' => '🇳🇿',
                    'established' => '2007',
                    'branches' => '17 Franchise Branches',
                    'status' => 'Headquarters'
                ],
                [
                    'name' => 'Australia',
                    'flag' => '🇦🇺',
                    'established' => '2013',
                    'branches' => 'Multiple Locations',
                    'status' => 'Regional Office'
                ],
                [
                    'name' => 'India',
                    'flag' => '🇮🇳',
                    'established' => '2016',
                    'branches' => 'Service Centers',
                    'status' => 'Regional Office'
                ],
                [
                    'name' => 'Bangladesh',
                    'flag' => '🇧🇩',
                    'established' => '2022',
                    'branches' => 'Growing Network',
                    'status' => 'Latest Addition'
                ]
            ];
            @endphp

            @foreach($countries as $country)
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg text-center hover:shadow-lg transition-shadow">
                <div class="text-5xl mb-4">{{ $country['flag'] }}</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $country['name'] }}</h3>
                <p class="text-sm text-blue-600 dark:text-blue-400 mb-2">{{ $country['status'] }}</p>
                <p class="text-gray-600 dark:text-gray-300 text-sm mb-1">Est. {{ $country['established'] }}</p>
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
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Get in Touch</h2>
            <p class="text-xl">Ready to start your next adventure?</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="text-4xl mb-4">🏢</div>
                <h3 class="text-xl font-semibold mb-2">Bangladesh Office</h3>
                <p class="text-sm opacity-90">House 3, Road 16, Sector 11</p>
                <p class="text-sm opacity-90">Uttara, Dhaka - 1230, Bangladesh</p>
            </div>
            
            <div class="text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-xl font-semibold mb-2">Phone</h3>
                <p class="text-lg">+8809647668822</p>
            </div>
            
            <div class="text-center">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-xl font-semibold mb-2">Email</h3>
                <p class="text-lg">info@ecotravelsonline.com.bd</p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                Contact Us Today
            </a>
        </div>
    </div>
</section>