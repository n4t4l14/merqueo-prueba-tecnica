@extends('app')
@props([
    'teamPage' => true,
])
@section('header')
    <header class="flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-4">
        <nav class="max-w-[85rem] w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between" aria-label="Global">
            <div class="flex items-center justify-between">
                <a class="inline-flex items-center gap-x-2 text-xl font-semibold" href="#">
                    <img class="w-10 h-auto" src="{{$team['flag']}}" alt="Logo">
                    {{$team['name']}}
                </a>
            </div>
            <div id="navbar-image-and-text-2" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow sm:block">
                <div class="flex flex-col gap-5 mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:ps-5">
                    <a class="font-medium text-blue-500" href="#" aria-current="page">Landing</a>
                    <a class="font-medium text-gray-600 hover:text-gray-400" href="#">Account</a>
                    <a class="font-medium text-gray-600 hover:text-gray-400" href="#">Work</a>
                    <a class="font-medium text-gray-600 hover:text-gray-400" href="#">Blog</a>
                </div>
            </div>
        </nav>
    </header>
@endsection

@section('content')
    <div class="flex flex-row gap-x-10" id="playersPagination" data-url="{{ route('api.v1.players.index') }}">
        <div class="basis-8/12" x-data="playersPagination()" x-init="init()" @reload-table.window="changePage()">
            <!-- teams table -->
            <table class="min-w-full divide-y divide-gray-200">
                <caption class="text-left p-4">Jugadores</caption>
                <thead>
                <tr>
                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Nombres</th>
                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Nacionalidad</th>
                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Edad</th>
                    <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Posición</th>
                    <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase"># Camiseta</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <template x-for="item in teams" :key="item.id">
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800" >
                            <div class="flex-shrink-0 group block">
                                <div class="flex items-center">
                                    <img class="inline-block size-8 rounded-lg" :src="item.photo" alt="Player">
                                    <div class="ms-3">
                                        <h3 class="font-semibold text-gray-800" x-text="item.name">..</h3>
                                        <small class="text-sm font-medium text-gray-400" x-text="item.name + '@gmail.com'"></small>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 content-center" x-text="item.nationality"></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 content-center" x-text="item.age"></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 content-center" x-text="item.position"></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 content-center" x-text="item.shirt_number"></td>
{{--                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" x-text="item.match_lost"></td>--}}
                    </tr>
                </template>
                </tbody>
            </table>
            <!-- End teams table -->

            <!-- Pagination -->
            <nav class="flex items-center gap-x-1 justify-center">
                <button
                        type="button"
                        @click.prevent="changePage(pagination.current_page - 1)"
                        x-bind:disabled="1 == pagination.current_page"
                        class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                >
                    <svg aria-hidden="true" class="hidden flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    <span>Anterior</span>
                </button>
                <div class="flex items-center gap-x-1">
                    <template x-for="page in pagesNumber()">
                        <button
                                type="button"
                                @click.prevent="changePage(page)"
                                x-text="page"
                                class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" aria-current="page">
                        </button>
                    </template>
                </div>

                <button
                        type="button"
                        x-bind:disabled="pagination.last_page == pagination.current_page"
                        @click.prevent="changePage(pagination.current_page + 1)"
                        class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">
                    <span>Siguiente</span>
                    <svg aria-hidden="true" class="hidden flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </button>
            </nav>
            <!-- End Pagination -->

            <div
                    x-data="alert()"
                    x-init="init()"
                    x-show="show"
                    x-transition
                    :class="isSuccess ? successClasses : errorClasses"
                    @generate-alert.window="generate($event.detail)"
                    role="alert"
            >
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Success icon -->
                        <span x-show="isSuccess" class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 hover:cursor-pointer" @click="show = ! show">
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                        <path d="m9 12 2 2 4-4"></path>
                    </svg>
                </span>

                        <!-- Error icon -->
                        <span x-show="!isSuccess" class="inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800 hover:cursor-pointer" @click="show = ! show">
                  <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                  </svg>
                </span>
                        <!-- End Icon -->
                    </div>
                    <div class="ms-3">
                        <h3 class="text-gray-800 font-semibold" x-text="title">...</h3>
                        <p x-show="message != null" class="text-sm text-gray-700" x-text="message"></p>

                        <!-- Error list -->
                        <div x-show="!isSuccess" class="mt-2 text-sm text-red-700">
                            <ul class="list-disc space-y-1 ps-5">
                                <template x-for="(error, index) in errors">
                                    <li x-text="error"></li>
                                </template>
                            </ul>
                        </div>
                        <!-- End error list -->
                    </div>
                </div>
            </div>
        </div>

        <div class="basis-4/12">
            <div class="w-full bg-white border border-t-4 border-t-gray-800 shadow-sm rounded-xl">
                <div class="p-4 md:p-5" x-data="playerFormCreate()" x-init="init()">
                    <form method="post" enctype="multipart/form-data" @submit.prevent="postFormData()">
                        <h3 class="text-lg font-bold text-gray-800">
                            Nuevo Jugador
                        </h3>
                        <p class="mt-2 text-gray-500"></p>
                        <div>
                            <div class="max-w-sm space-y-3">
                                <div class="relative">
                                    <input
                                            x-model="form.name"
                                            placeholder="Nombres"
                                            class="peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="flex-shrink-0 size-4 text-gray-500">
                                            <path d="M8.5 4.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0ZM10 13c.552 0 1.01-.452.9-.994a5.002 5.002 0 0 0-9.802 0c-.109.542.35.994.902.994h8ZM12.5 3.5a.75.75 0 0 1 .75.75v1h1a.75.75 0 0 1 0 1.5h-1v1a.75.75 0 0 1-1.5 0v-1h-1a.75.75 0 0 1 0-1.5h1v-1a.75.75 0 0 1 .75-.75Z" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="relative">
                                    <input
                                            x-model="form.nationality"
                                            placeholder="Nacionalidad"
                                            class="peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="flex-shrink-0 size-4 text-gray-500">
                                            <path d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                                            <path d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                                        </svg>

                                    </div>
                                </div>

                                <div class="relative">
                                    <input
                                            type="number"
                                            x-model="form.age"
                                            placeholder="Edad"
                                            class="peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="flex-shrink-0 size-4 text-gray-500">
                                            <path d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                                            <path d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                                        </svg>

                                    </div>
                                </div>

                                <div class="relative">
                                    <input
                                            x-model="form.position"
                                            placeholder="Posición"
                                            class="peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="flex-shrink-0 size-4 text-gray-500">
                                            <path d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                                            <path d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                                        </svg>

                                    </div>
                                </div>

                                <div class="relative">
                                    <input
                                            type="number"
                                            x-model="form.shirt_number"
                                            placeholder="# Camiseta"
                                            class="peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="flex-shrink-0 size-4 text-gray-500">
                                            <path d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                                            <path d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                                        </svg>

                                    </div>
                                </div>

                                <div class="relative">
                                    <label for="file-input" class="sr-only">Selecciona Foto</label>
                                    <input type="file" name="file-input" id="file-input" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4">
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 md:p-5 text-right">
                            <button class=" mt-3 py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-800 text-white hover:bg-gray-700 disabled:opacity-50 disabled:pointer-events-none" href="#">
                                Crear
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function playersPagination() {
            return {
                path: document.getElementById('playersPagination').dataset.url,

                teams : [],
                pagination: {
                    current_page: 1,
                    per_page: 15,
                    last_page: null
                } ,
                offset: 4,
                pages : [],
                goto : null ,
                search : null ,

                goToPages(){
                    if(this.goto && this.goto  <= this.pagination.last_page) {
                        this.changePage(this.goto);
                    }
                },
                pagesNumber() {
                    if (!this.pagination.to) {
                        return [];
                    }

                    let from = this.pagination.current_page - this.offset;

                    if (from < 1) {
                        from = 1;
                    }
                    let to = from + (this.offset * 2);

                    if (to >= this.pagination.last_page) {

                        to = this.pagination.last_page;

                    }

                    let pagesArray = [];

                    for (let page = from; page <= to; page++) {
                        pagesArray.push(page);
                    }

                    return pagesArray;
                },
                changePage(page, perPage) {
                    let self = this;
                    page =  page ? page : localStorage.getItem('current_page' , page);
                    perPage = perPage ? perPage : localStorage.getItem('per_page' , perPage);

                    return fetch(this.buildUrl(page, perPage))
                        .then(function (response) {return response.json();})
                        .then(function (res) {
                            self.pagination = res.meta;
                            self.current_page = res.meta.current_page;
                            self.pages = res.meta.last_page;
                            self.teams = res.data;

                            self.goto = null;

                            localStorage.setItem('current_page' , page);
                            localStorage.setItem('per_page' , perPage);

                            return res;
                        })
                        .catch(console.error);

                },
                buildUrl(page = 1, perPage = 15){
                    const params = new URLSearchParams({
                        page : page ,
                        per_page: perPage,
                        'filters[team_id]': '{{$team['id']}}',
                    });

                    return this.path + '?' + params.toString();
                },
                init() {
                    this.changePage(this.pagination.current_page, this.pagination.per_page);
                }
            }
        }

        function playerFormCreate() {
            return {
                form: {
                    name: null,
                    nationality: null,
                    age: null,
                    position: null,
                    shirt_number: null,
                    team_id: '{{$team['id']}}'
                },

                selectFile(event) {
                    this.form.images = event.target.files[0];
                },

                postFormData() {
                    let self = this;
                    const data = new FormData()
                    data.append('name', this.form.name);
                    data.append('nationality', this.form.nationality);
                    data.append('age', this.form.age);
                    data.append('position', this.form.position);
                    data.append('shirt_number', this.form.shirt_number);
                    data.append('shirt_number', this.form.shirt_number);
                    data.append('team_id', this.form.team_id);

                    let inputFile = document.querySelector('input[type="file"]')
                    Array.from(inputFile.files).forEach((f) => {
                        data.append('photo', f)
                    })

                    let url = "{{route('api.v1.players.store')}}"
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: data
                    })
                        .then(r =>  r.json().then(data => ({ok:r.ok, status: r.status, body: data})))
                        .then((response) => {
                            if (! response.ok) {
                                let errors = response.body.errors;
                                self.$dispatch('generate-alert', {
                                    isSuccess: false,
                                    title: response.body.message,
                                    errors: Object.keys(errors).map((key) => errors[key][0])
                                });

                                return;
                            }

                            self.$dispatch('generate-alert', {isSuccess: true, title: 'Jugador creado con éxito!'});
                            self.$dispatch('reload-table');
                        }).catch(console.error);
                },

                init() {
                    // this.$watch('form.name', (value, oldValue) => console.log(value, oldValue));
                }
            }
        }

        function alert() {
            return {
                show: false,
                isSuccess: null,
                title: null,
                message: null,
                errors : [],
                successClasses: 'bg-teal-50 border-t-2 border-teal-500 text-teal-800 rounded-lg p-4',
                errorClasses: 'bg-red-50 border-t-2 border-red-500 text-red-800 rounded-lg p-4',

                generate(properties) {
                    this.show = true;
                    this.title = properties.title;
                    this.isSuccess = properties.isSuccess;
                    this.message = properties.message;
                    this.errors = properties.errors ? properties.errors : [];

                    setTimeout(() => { this.show = false }, 8000);
                },

                init() {}
            }
        }
    </script>
@endpush
