@extends('larapoll::layouts.app')
@section('title')
Polls- Creation
@endsection
@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" rel="stylesheet" />
@endsection
@section('content')
<div class="container mx-auto" id="app">
    <section class="p-10 px-0">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('poll.home') }}">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('poll.index') }}">Polls</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-500" aria-current="page">Create</a>
            </li>
        </ol>
    </section>

    <div class="w-full">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">

            <div class="mb-6">
                <label class="block text-gray-700 text-lg font-bold mb-2 uppercase tracking-wide font-bold" for="question">
                    Question
                </label>
                <input v-model="question" placeholder="Who is the best football player in the world?" class="shadow appearance-none border rounded w-full py-4 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="text">
            </div>

            <div class="flex flex-wrap mb-6">
                <label class="block text-gray-700 text-lg font-bold mb-2 uppercase tracking-wide font-bold" for="options">
                    Options
                </label>
                <div v-for="(option, index) in options" class="w-full flex items-center border-b border-b-2 border-teal-500 py-2">
                    <input v-model="option.value" :placeholder="option.placeholder" class="appearance-none bg-transparent border-none block w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" />
                    <button @click.prevent="remove(index)" class="flex-shrink-0 border-transparent border-4 text-teal-500 hover:text-teal-800 text-sm py-1 px-2 rounded" type="button">
                        Remove
                    </button>
                </div>
                <div class="w-full flex items-center border-b border-b-2 border-teal-500 py-2">
                    <input v-model="newOption" class="appearance-none bg-transparent border-none block w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Luka Modric" aria-label="Full name">
                    <button @click.prevent="addNewOption" class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="button">
                        Add
                    </button>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                        Starts at
                    </label>
                    <input v-model="starts_at" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white localDates" type="text">
                    <p class="text-red-500 text-xs italic hidden">Please fill out this field.</p>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                        Ends at
                    </label>
                    <input v-model="ends_at" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 localDates" type="text">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button @click.prevent="save" class="bg-teal-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                    Create
                </button>
            </div>
        </form>
        <p class="text-center text-gray-500 text-xs">
            &copy;2020 Larapoll. All rights reserved.
        </p>
    </div>
</div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script>
        new Vue({
           el: '#app',
            computed:{
              filledOptions(){
                return this.options.map((option) => {
                    return option.value;
                } ).filter((option) => option);
              }
            },
            mounted(){
                $('.localDates').datetimepicker();
            },
            data(){
               return {
                    newOption: '',
                    question: '',
                    options: [
                        { value: '', placeholder: 'Cristiano Ronaldo'},
                        { value: '', placeholder: 'Lionel Messi'},
                    ],
                    canVisitors: false,
                   starts_at: '',
                   ends_at: ''
               }
            },
            methods:{
               addNewOption(){
                   if(this.newOption.length === 0){
                       alert('Invalid string');
                       return;
                   }
                   if(this.filledOptions.filter( option => option === this.newOption).length !== 0){
                       alert('Already Exists');
                       return;
                   }

                   this.options.push({
                       value: this.newOption,
                       placeholder: ''
                   });
                   this.newOption = '';
               },
                remove(index){
                    if(this.filledOptions.length <= 2){
                        alert('At least we should have 2 options!');
                        return;
                    }
                    this.options = this.options.map((option, localIndex) => {
                        if(localIndex === index){
                            return null;
                        }

                        return option
                    }).filter(option => option);
                },
                save(){
                   if(this.filledOptions.length < 2){
                       alert('At least we should have 2 options!');
                       return;
                   }

                   // POST TO STORE
                   axios.post("{{ route('poll.store') }}", {
                       question: this.question,
                       options: this.filledOptions,
                       starts_at: this.starts_at,
                       ends_at: this.ends_at,
                   })
                   .then((response) => {
                       console.log(response)
                   })
                   .catch((error) => {
                       console.log(error)
                   })
                }
            }
        });
    </script>
@endsection
