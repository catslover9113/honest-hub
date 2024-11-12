<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
            <div class="shrink-0">
    <a href="{{ auth()->check() ? route('dashboard') : route('user.index') }}">
        <img src="{{ asset('/images/logo.jpg') }}" alt="HonestHub Logo" class="h-10 w-auto">
        <span class="text-xl font-semibold text-gray-800 dark:text-gray-200 ml-2">HonestHub</span>
    </a>
</div>

            </div>

            <div class="flex items-center w-full sm:w-auto justify-center sm:ml-4">
                <form action="{{ route('product.search') }}" method="GET" class="flex items-center w-full sm:w-auto">
                    <input type="text" name="query" placeholder="ابحث عن المنتجات..." class="form-control w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md text-gray-700">
                    <button type="submit" class="btn btn-primary ms-2 px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700">بحث</button>
                </form>
            </div>

            <div class="hidden sm:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">التسجيل</a>
                @else
                    <div class="relative">
                        <button onclick="toggleMenu()" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 focus:outline-none">
                            {{ Auth::user()->name }}
                            <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                        <div id="logout-menu" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 py-1 hidden">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200">تسجيل الخروج</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex sm:hidden items-center">
                <button onclick="toggleMenu()" class="text-gray-500 dark:text-gray-400 focus:outline-none">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Script for Menu Toggle -->
<script>
    function toggleMenu() {
        var menu = document.getElementById('logout-menu');
        menu.classList.toggle('hidden');
    }
</script>


