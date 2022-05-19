<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if( isset($location['location_name']))
                {{ __( $location['location_name'] . ' Shoppers') }}
            @endif
            <button style="float:right" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Limit
            </button>

        </h2>
    </x-slot>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Change Store limit</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="{{ route('store.location.update',['id'=>$location["id"]]) }}">
                        <input type="hidden" value="PUT" name="_method">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="firstName">
                                Limit
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="limit" name="limit" type="text" value="<?=$location['shopper_limit']?>"
                                placeholder="Limit">
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
                        Change
                    </button>
                </div>
                </form>


            </div>
        </div>
    </div>

    @include('components.store.locations.queue')

    </div>
    </div>
    </div>
    </div>
    @if ($message = Session::get('success'))
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
        <script>
            const socket = io('http://localhost:4001', {transports: ['websocket']});
            socket.emit('notification', 'Emit');
        </script>
    @endif
</x-app-layout>
