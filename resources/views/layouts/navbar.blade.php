<header class="mb-12">
    <div class="flex bg-white top-0 inset-x-0 z-100 h-20 items-center border-b">
        <div class="w-full max-w-screen-xl relative mx-auto px-6">
            <div class="flex items-center -mx-6">
                <div class="lg:w-1/4 xl:w-1/7 pl-6 pr-6 lg:pr-8">
                    <div class="flex items-center">
                        <a class="antialiased block ml-6 lg:mr-4 text-2xl text-secondary font-semibold font-sans tracking-wide" href="{{ url('/threads') }}">
                            <i class="fab fa-laravel fa-lg text-redFire"></i> {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                </div>
                <div class="flex flex-grow lg:w-3/4 xl:w-4/5">
                    <div class="w-full lg:px-6 xl:w-3/4 xl:px-12">
                        <div class="relative">
                            <input type="text" placeholder="Search The forum .." class="transition focus:outline-none border  focus:bg-white placeholder-primary-600 rounded-full py-2 pr-4 pl-10 block w-full appearance-none leading-normal ds-input"></input>
                            <div class="pointer-events-none absolute inset-y-0 left-0 pl-4 flex items-center">
                                <span class="fas fa-search fill-current pointer-events-none text-gray-600 w-4 h-4"></span>
                            </div>
                        </div>
                    </div>
                    @guest
                    <div class="flex flex-row items-center">
                        <a href="{{ route('register') }}" class="block antialiased mr-6 font-medium text-red-500 tracking-wide hover:text-red-400">
                            Become a member
                        </a>
                        <a href="{{ route('login') }}" class="block antialiased font-medium text-gray-700 tracking-wide hover:text-gray-600">
                            Sign In
                        </a>
                    </div>
                    @endguest
                    <div class="hidden lg:flex lg:items-center  xl:w-1/4 px-20" v-if="this.signdIn">
                        <user-notifications class="mr-3" ></user-notifications>
                        <account-dropdown></account-dropdown>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
