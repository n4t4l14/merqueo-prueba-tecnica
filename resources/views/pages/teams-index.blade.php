@extends('app')
@props([
    'homePage' => true
])

@section('header')
    <header class="flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-4">
        <nav class="max-w-[85rem] w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between" aria-label="Global">
            <div class="flex items-center justify-between">
                <a class="flex-none" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-auto text-gray-600" width="100" height="100">
                        <path d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
                    </svg>
                </a>
            </div>
            <div class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow sm:block">
                <div x-data="runChampionship()" x-init="init()" class="flex flex-col gap-5 mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:ps-5">
                    <button class="font-medium text-gray-600" aria-current="page"  type="button" @click.prevent="sendRequest()">
                        Generar campeonato
                    </button>
                </div>
            </div>
        </nav>
    </header>
@endsection

@section('content')
    <div class="flex flex-row gap-x-10" id="teamsPagination" data-url="{{ route('api.v1.teams.index') }}">
        <div class="basis-8/12" x-data="teamsPagination()" x-init="init()" @reload-table.window="changePage()">
            <!-- teams table -->
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Equipo</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Tarjetas Rojas</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Tarjetas Amarillas</th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Total Goles</th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Partidos Ganados</th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Partidos Perdidos</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <template x-for="item in teams" :key="item.id">
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800" >
                                <div class="flex-shrink-0 group block">
                                    <div class="flex items-center">
                                        <img class="inline-block size-8 rounded-lg" :src="item.flag" alt="Team">
                                        <div class="ms-3">
                                            <a :href="getTeamUrl(item)">
                                                <h3 class="font-semibold text-gray-800" x-text="item.name">..</h3>
                                                <p class="text-sm font-medium text-gray-400 dark:text-neutral-500" x-text="item.name + '-team@gmail.com'"></p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" x-text="item.total_red_card"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" x-text="item.total_yellow_card"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" x-text="item.total_goals"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" x-text="item.match_won"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" x-text="item.match_lost"></td>
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

            <!-- Alert -->
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
            <!-- End Alert -->
        </div>

        <div class="basis-4/12">
            <div class="w-full bg-white border border-t-4 border-t-gray-800 shadow-sm rounded-xl grid grid-cols-1 divide-y">
                <!-- Team Form Create -->
                <div class="p-4 md:p-5" x-data="teamFormCreate()" x-init="init()">
                    <form method="post" enctype="multipart/form-data" @submit.prevent="postFormData()">
                        <h3 class="text-lg font-bold text-gray-800">
                            Nuevo Equipo
                        </h3>
                        <p class="mt-2 text-gray-500 dark:text-neutral-400"></p>
                        <div class="max-w-sm space-y-3">
                            <div class="relative">
                                <input
                                        x-model="form.name"
                                        placeholder="Ingrese nombre"
                                        class="peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="flex-shrink-0 size-4 text-gray-500 dark:text-neutral-500">
                                        <path fill-rule="evenodd" d="M7.628 1.349a.75.75 0 0 1 .744 0l1.247.712a.75.75 0 1 1-.744 1.303L8 2.864l-.875.5a.75.75 0 0 1-.744-1.303l1.247-.712ZM4.65 3.914a.75.75 0 0 1-.279 1.023L4.262 5l.11.063a.75.75 0 0 1-.744 1.302l-.13-.073A.75.75 0 0 1 2 6.25V5a.75.75 0 0 1 .378-.651l1.25-.714a.75.75 0 0 1 1.023.279Zm6.698 0a.75.75 0 0 1 1.023-.28l1.25.715A.75.75 0 0 1 14 5v1.25a.75.75 0 0 1-1.499.042l-.129.073a.75.75 0 0 1-.744-1.302l.11-.063-.11-.063a.75.75 0 0 1-.28-1.023ZM6.102 6.915a.75.75 0 0 1 1.023-.279l.875.5.875-.5a.75.75 0 0 1 .744 1.303l-.869.496v.815a.75.75 0 0 1-1.5 0v-.815l-.869-.496a.75.75 0 0 1-.28-1.024ZM2.75 9a.75.75 0 0 1 .75.75v.815l.872.498a.75.75 0 0 1-.744 1.303l-1.25-.715A.75.75 0 0 1 2 11V9.75A.75.75 0 0 1 2.75 9Zm10.5 0a.75.75 0 0 1 .75.75V11a.75.75 0 0 1-.378.651l-1.25.715a.75.75 0 0 1-.744-1.303l.872-.498V9.75a.75.75 0 0 1 .75-.75Zm-4.501 3.708.126-.072a.75.75 0 0 1 .744 1.303l-1.247.712a.75.75 0 0 1-.744 0L6.38 13.94a.75.75 0 0 1 .744-1.303l.126.072a.75.75 0 0 1 1.498 0Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="relative">
                                <label for="team-flag" class="sr-only">Selecciona bandera</label>
                                <input type="file" name="team-flag" id="team-flag" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4">
                            </div>
                        </div>
                        <div class="md:p-5 text-right">
                            <button class=" mt-3 py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-800 text-white hover:bg-gray-700 disabled:opacity-50 disabled:pointer-events-none" href="#">
                                Crear
                            </button>
                        </div>
                    </form>
                </div>
                <!-- End Team Form Create -->

                <!-- Team Bulk Load Form -->
                <div class="p-4 md:p-5" x-data="bulkLoadTeams()" x-init="init()">
                    <form method="post" enctype="multipart/form-data" @submit.prevent="postFormData()">
                        <p class="mb-2 text-gray-500">
                            Cargue masiva de equipos.

                            <small class="ml-2">
                                <a href="{{url('storage/teams_and_players_data_template.csv')}}" target="_blank" class="underline">
                                    (Plantilla <code>.csv</code>)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 inline">
                                        <path d="M6.22 8.72a.75.75 0 0 0 1.06 1.06l5.22-5.22v1.69a.75.75 0 0 0 1.5 0v-3.5a.75.75 0 0 0-.75-.75h-3.5a.75.75 0 0 0 0 1.5h1.69L6.22 8.72Z" />
                                        <path d="M3.5 6.75c0-.69.56-1.25 1.25-1.25H7A.75.75 0 0 0 7 4H4.75A2.75 2.75 0 0 0 2 6.75v4.5A2.75 2.75 0 0 0 4.75 14h4.5A2.75 2.75 0 0 0 12 11.25V9a.75.75 0 0 0-1.5 0v2.25c0 .69-.56 1.25-1.25 1.25h-4.5c-.69 0-1.25-.56-1.25-1.25v-4.5Z" />
                                    </svg>
                                </a>
                            </small>
                        </p>
                        <div class="max-w-sm space-y-3">
                            <div class="relative">
                                <label for="teams-csv-file" class="sr-only">Selecciona archivo CSV</label>
                                <input type="file" name="teams-csv-file" id="teams-csv-file" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4">
                            </div>
                        </div>
                        <div class="md:p-5 text-right">
                            <button class=" mt-3 py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-800 text-white hover:bg-gray-700 disabled:opacity-50 disabled:pointer-events-none">
                                Crear
                            </button>
                        </div>
                    </form>
                </div>
                <!-- End Team Bulk Load Form -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function runChampionship() {
            return {
                url: '{{route('api.v1.championships.generate-championship')}}',
                sendRequest() {
                    let self = this;

                    fetch(this.url, {
                        method: 'GET',
                        headers: {'Accept': 'application/json'}
                    })
                    .then(r =>  r.json().then(data => ({ok:r.ok, status: r.status, body: data})))
                    .then(function (response) {
                        if (! response.ok) {
                            self.$dispatch('generate-alert', {
                                isSuccess: false,
                                title: 'UPS! Fallo el proceso de creación',
                            });

                            return;
                        }

                        self.$dispatch('generate-alert', {isSuccess: true, title: 'Campeonato realizado con éxito!'});
                        self.$dispatch('reload-table');

                        return res;
                    })
                    .catch(console.error);
                },

                init () {}
            }
        }

        function teamsPagination() {
            return {
                path: document.getElementById('teamsPagination').dataset.url ,
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
                    });

                    return this.path + '?' + params.toString();
                },
                getTeamUrl(team) {
                    let baseUrl = "{{route('web.teams.show', ['teamId' => '%teamId%'])}}";
                    return baseUrl.replace("%teamId%", team.id)
                },
                init() {
                    this.changePage(this.pagination.current_page, this.pagination.per_page);
                }
            }
        }

        function teamFormCreate() {
            return {
                form: {
                    name: '',
                },

                postFormData() {
                    let self = this;
                    const data = new FormData()
                    data.append('name', this.form.name);
                    data.append('flag', document.getElementById('team-flag').files[0])

                    let url = "{{route('api.v1.teams.store')}}"
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

                        self.$dispatch('generate-alert', {isSuccess: true, title: 'Equipo creado con éxito!'});
                        self.$dispatch('reload-table');
                    }).catch(console.error);
                },

                init() {
                    // this.$watch('form.name', (value, oldValue) => console.log(value, oldValue));
                }
            }
        }

        function bulkLoadTeams() {
            return {
                postFormData() {
                    let self = this;
                    const data = new FormData()
                    data.append('csv-file', document.getElementById('teams-csv-file').files[0])

                    let url = "{{route('api.v1.teams.bulk-load')}}";
                    console.log(url);
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

                        self.$dispatch('generate-alert', {isSuccess: true, title: 'Cargue exitoso!'});
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
