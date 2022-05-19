
             
         @if ($message = Session::get('success'))

         <div class="alert alert-success alert-block">
         
             <button type="button" class="close" data-dismiss="alert">×</button>    
         
             <strong>{{ $message }}</strong>
         
         </div>
         
         @endif
         @if ($message = Session::get('failed'))
         
         <div class="alert alert-success alert-block">
         
             <button type="button" class="close" data-dismiss="alert">×</button>    
         
             <strong>{{ $message }}</strong>
         
         </div>
         
         @endif
         <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
            <table class="w-full whitespace-no-wrapw-full whitespace-no-wrap mt-6">
                        <thead>
                        <tr>
                            <th>
                                Status
                            </th>
                            <th>
                                Shopper Name
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Check-In
                            </th>
                            <th>
                                Check-Out
                            </th>
                              @if(\Auth::user())
                                <th>
                                    Action
                                </th>
                             @endif
                        </tr>
                        </thead>
                        <tbody>
                        @if( isset( $shoppers['active'] ) && is_iterable( $shoppers['active'] ) )
                            @if( count( $shoppers['active'] )  >= 1 )
                                @foreach( $shoppers['active'] as $shopper )
                                    <tr class="text-center">
                                        <x-shopper.listing :shopper="$shopper"/>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                        @if( isset( $shoppers['pending'] ) && is_iterable( $shoppers['pending'] ) )
                            @if( count( $shoppers['pending'] )  >= 1 )
                                @foreach( $shoppers['pending'] as $shopper )
                                    <tr class="text-center">
                                        <x-shopper.listing :shopper="$shopper"/>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                        @if( isset( $shoppers['completed'] ) && is_iterable( $shoppers['completed'] ) )
                            @if( count( $shoppers['completed'] )  >= 1 )
                                @foreach( $shoppers['completed'] as $shopper )
                                    <tr class="text-center">
                                        <x-shopper.listing :shopper="$shopper"/>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                        </tbody>
                    </table>
                             
                </div>
            </div>
        </div>
    </div>
  

