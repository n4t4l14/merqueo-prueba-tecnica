@extends('app')
@props([
    'gamePage' => true
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
        </nav>
    </header>
@endsection

@section('content')
    <div class="flex flex-row gap-x-10" id="gamesPagination" data-url="{{ route('api.v1.games.index') }}">
        <div class="basis-8/12" x-data="gamesPagination()" x-init="init()" @reload-table.window="changePage()">
            <!-- Games table -->
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Orden</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Ronda</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Partido</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Equipo A</th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Equipo B</th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Ganador</th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Perdedor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <template x-for="item in games">
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" x-text="item.id"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" x-text="item.round"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" x-text="item.order"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                <span x-text="item.team_name_a"></span>
                                <div class="mb-1">
                                  <span class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full">
                                    <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                                      <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                    <span x-text="'Goles ' + item.goals_a"></span>
                                  </span>
                                </div>

                                <div class="mb-1">
                                  <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                    <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                                      <path d="M12 9v4"></path>
                                      <path d="M12 17h.01"></path>
                                    </svg>
                                    <span x-text="'Tarjetas Rojas ' + item.red_card_a"></span>
                                  </span>
                                </div>

                                <div>
                                  <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                    <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                                      <path d="M12 9v4"></path>
                                      <path d="M12 17h.01"></path>
                                    </svg>
                                    <span x-text="'Tarjetas Amarillas ' + item.yellow_card_a"></span>
                                  </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                <span x-text="item.team_name_b"></span>
                                <div class="mb-1">
                                  <span class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full">
                                    <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                                      <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                    <span x-text="'Goles ' + item.goals_b"></span>
                                  </span>
                                </div>

                                <div class="mb-1">
                                  <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                    <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                                      <path d="M12 9v4"></path>
                                      <path d="M12 17h.01"></path>
                                    </svg>
                                    <span x-text="'Tarjetas Rojas ' + item.red_card_b"></span>
                                  </span>
                                </div>

                                <div>
                                  <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                    <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                                      <path d="M12 9v4"></path>
                                      <path d="M12 17h.01"></path>
                                    </svg>
                                    <span x-text="'Tarjetas Amarillas ' + item.yellow_card_b"></span>
                                  </span>
                                </div>

                            </td>
.                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" x-text="item.winning_team_name"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" x-text="item.losing_team_name"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <!-- End games table -->

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
        </div>
    </div>
@endsection

@push('scripts')
    <script>

        function gamesPagination() {
            return {
                path: document.getElementById('gamesPagination').dataset.url ,
                games : [],
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
                            self.games = res.data;

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
                init() {
                    this.changePage(this.pagination.current_page, this.pagination.per_page);
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
