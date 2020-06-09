
 @include('direction')
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" defer />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js" defer></script>
  <style type="text/css">
    btn {
      padding-right: 10px;
    }
    label
    {
      color:#d84f57;
    }
    table.dataTable.no-footer {
    border-bottom: 1px solid #ddd;
    
}
.table-bordered th, .table-bordered td {
    border-bottom: 1px solid #dee2e6;
}
#trip-select{
  float:right;
}
#trip-select div:last-of-type{
    float:right;
}
#trip-select div:first-of-type{
    float:left;
}
table
{
    clear:both;
}
#bus-select,#trip-select{
  width:250px;
color:'red';
}
#select-boxes{
  float:right;
}

  </style>

        <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Booking History
                    <div id='select-boxes'>
                      <select id='bus-select'></select>
                      <select id='trip-select'> </select>
                      <button id="getlist" class='btn btn-sm btn-danger'>Get</button>
                    </div>
                </div>
                
                  
            <div class="card-body">
            
            <table class="table table-bordered" id="laravel_datatable">
               <thead>
                    <tr>

                     
                      <th>From</th>
                     <th>To</th>
                     <th>Count</th>
                     <th>Booking Time</th>
                     <th>Ticket Date</th>
                     <th>Booked By</th>

                  </tr>
               </thead>
               <tbody id='detail'>
                {{-- @foreach($book_history as $user)
                 <tr>
                  
                 </tr>
                 @endforeach --}}
               </tbody>
               
            </table>
          </div>
                </div>
            </div>
      </div>
   </div> 
</div>
 <script type="text/javascript">
  $(document).ready(function() {
    	

      $('#bus-select').select2({
    			placeholder:'select bus',
    			ajax:{
    				url:"{{ route('getBuses') }}",
    				type:'get',
    				dataType:'json',
    				delay:250,
    				data:function(params){
    					return {
    						bus_id:params.term
    					};
    				},
    				processResults:function(data){
    					return {
    						results:$.map(data.items,function(val,i){
                  console.log(val.bus_id,i)
    							return {id:val.bus_id,text:val.bus_id}
    						}),
    					};
    				},
    			}
    	});
         $('#trip-select').select2({
    			placeholder:'select Trip',
    			ajax:{
    				url:"{{ route('getTrips') }}",
    				type:'get',
    				dataType:'json',
    				delay:250,
    				data:function(params){
    					return {
    						trip_id:params.term
    					};
    				},
    				processResults:function(data){
    					return {
    						results:$.map(data.items,function(val,i){
                  console.log(val.trip_id,i)
    							return {id:val.trip_id,text:val.trip_id}
    						}),
    					};
    				},
    			}
    	});

      //load details
       $('#getlist').on('click',function loadData(){
        bus_id = $('#bus-select').val();
        trip_id = $('#trip-select').val();
           $.ajax({
           type:'POST',
           url:"{{ route('bookings.count') }}",
           data:{
             trip_id:trip_id,
             bus_id:bus_id,
             },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success:function(data){
             $('#detail').html("")
             $('#detail').append(data)
           },
   });
        
           
   });


  });

 </script>