@extends('public.index')

@section('content')
    <div class="row">

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
            Check In
        </button>
    </div>

    @include('components.store.locations.queue')

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Check In Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="{{ route('store.checkin') }}">

                        @csrf
                        <input type="hidden" name="storeUuid" value="{{ $storeUuid ?? null }}">
                        <input type="hidden" name="locationUuid" value="{{ $locationUuid ?? null }}">


                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="firstName">
                                First Name
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="firstName" name="first_name" type="text" placeholder="First Name">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="lastName">
                                Last Name
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="lastName" name="last_name" type="text" placeholder="Last Name">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                Email
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="email" name="email" type="email" placeholder="Email">
                        </div>

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                 role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                    @endif


                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">
                        Check in
                    </button>
                </div>
                </form>


            </div>
        </div>
    </div>
@endsection()
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script>
        const socket = io('http://localhost:4001', {transports: ['websocket']});
        socket.on('notification', function (data) {
            location.reload()
        });
    </script>
@endsection()
