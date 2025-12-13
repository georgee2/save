@if (count($data) > 0)        
  <table  class="table table-striped table-bordered dt-responsive datatable-buttons" style="border-collapse: collapse; border-spacing: 0; width: 100% !important;">
   
    <thead>
      <tr>
          @foreach($data[0] as $key => $value)

            <th>{{$key}}</th>

          @endforeach
          @if(!empty($urls) && !(count($urls) == 1 && array_key_exists('add', $urls)))
            <th class="noPrint">#Actions</th>
          @endif
      </tr>
    </thead>


    <tbody>
      <!-- For loop Rows-->
      @foreach($data as $i => $v)


      <!-- To get key-->
        <?php 
          foreach ($v as $key => $value) {
              $currKey = $value;
              break;                    
          }
        ?>
      <tr>

        <!-- For loop To print Rows-->
        @foreach($v as $kay => $val)
            <td>
            @if($kay == 'Logo')
              @if($val == "N/A")
              N/A
              @else
              <a  data-lightbox="{{url('/storage'.$val)}}" href="{{url('/storage'.$val)}}">
              <img style="width:100%;height: 90px" src="{{url('/storage'.$val)}}">
            </a>
              @endif

            @elseif($kay == 'Image')
            @if($val == "N/A")
              N/A
              @else
              <a  data-lightbox="{{url('/storage'.$val)}}" href="{{url('/storage'.$val)}}">
              <img style="width:100%;height: 90px" src="{{url('/storage'.$val)}}">
              </a>
            @endif

            @else
            {{$val}}
            @endif
          </td>
        @endforeach


  <!-- To check urls button without add-->
  @if(!empty($urls) && !(count($urls) == 1 && array_key_exists('add', $urls)))
    <td>


      <!-- show button-->
       @if(isset($urls['create']))

                        <form method="POST" >
                            @csrf    
                            <button formaction="{{$urls['create']}}/{{ $currKey }}" class="btn btn-pink btn-sm" type="submit"><i class="fa fa-plus"></i> Create</button>
                          </form>

       @endif

      <!-- show button-->
       @if(isset($urls['preview']))

       <a href="{{$urls['preview']}}/{{ $currKey }}" class="btn btn-pink btn-sm mr-2"><i class="fa fa-file"></i> Preview </a>

       @endif

      <!-- show button-->
       @if(isset($urls['show']))

       <a href="{{$urls['show']}}/{{ $currKey }}" class="btn btn-primary btn-sm mr-2"><i class="fa fa-eye"></i> Show </a>

       @endif

       <!-- update button-->        
      @if(isset($urls['update']))
      <a href="{{$urls['update']}}/{{ $currKey }}" class="btn btn-warning btn-sm mr-2"><i class="fa fa-pencil"></i> Update </a>
             
       @endif


       <!-- show button-->
       @if(isset($urls['showicon']))

       <a href="{{$urls['showicon']}}/{{ $currKey }}" class="btn btn-primary btn-sm mr-2"><i class="fa fa-eye"></i></a>

       @endif

       <!-- update button-->        
      @if(isset($urls['updateicon']))
      <a href="{{$urls['updateicon']}}/{{ $currKey }}" class="btn btn-warning btn-sm mr-2"><i class="fa fa-pencil"></i> </a>
             
       @endif

       <!-- delete button-->
        @if(isset($urls['deleteicon']))

        <a style="color:white;" data-toggle="modal" data-target=".bs-example-modal-lg_{{$currKey}}" class="btn btn-danger btn-sm"><i style="color:white;" class="fa fa-trash-o"></i>  </a>


        <div class="modal fade bs-example-modal-lg_{{$currKey}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                          <br>
                          <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                          <br><br><p>You Want to Delete This Row</p>
                        </div>
                        <br>
                        <div class="modal-footer">
                        <form method="POST" >
                            @csrf    
                            <button formaction="{{$urls['deleteicon']}}/{{ $currKey }}" class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash-o"></i> Delete</button>
                          </form>
                        </div>

                      </div>
                    </div>
                  </div>

        @endif





        <!-- delete button-->
        @if(isset($urls['delete']))

        <a style="color:white;" data-toggle="modal" data-target=".bs-example-modal-lg_{{$currKey}}" class="btn btn-danger btn-sm"><i style="color:white;" class="fa fa-trash-o"></i> Delete </a>


        <div class="modal fade bs-example-modal-lg_{{$currKey}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                          <br>
                          <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                          <br><br><p>You Want to Delete This Row</p>
                        </div>
                        <br>
                        <div class="modal-footer">
                        <form method="POST" >
                            @csrf    
                            <button formaction="{{$urls['delete']}}/{{ $currKey }}" class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash-o"></i> Delete</button>
                          </form>
                        </div>

                      </div>
                    </div>
                  </div>

        @endif

        <!-- Restore button-->
        @if(isset($urls['restore']))

        <a style="color:white;" data-toggle="modal" data-target=".bs-example-modal-lg_re_{{$currKey}}" class="btn btn-success btn-sm"><i style="color:white;" class="fa fa-history"></i> Restore </a>


        <div class="modal fade bs-example-modal-lg_re_{{$currKey}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                          <br>
                          <p>Are you Sure ?!</p><br><i style="color: #6fd088" class="fa fa-history fa-5x"></i> 
                          <br><br><p>You Want to Restore This Row</p>
                        </div>
                        <br>
                        <div class="modal-footer">
                        <form method="POST" >
                            @csrf    
                            <button formaction="{{$urls['restore']}}/{{ $currKey }}" class="btn btn-success btn-sm" type="submit"><i class="fa fa-history"></i> Restore</button>
                          </form>
                        </div>

                      </div>
                    </div>
                  </div>

        @endif

        <!-- user button-->
       @if(isset($urls['user']))

       <a href="{{$urls['user']}}/{{ $currKey }}" class="btn btn-success btn-sm ml-2"><i class="mdi mdi-account-box-outline"></i></a>

       @endif


       <!-- show button-->
       @if(isset($urls['mail']))

                        <form method="POST" class="mr-2 ml-2" >
                            @csrf    
                            <button formaction="{{$urls['mail']}}/{{ $currKey }}" class="btn btn-pink btn-sm" type="submit"><i class="fa fa-mail"></i> Send</button>
                          </form>

       @endif

  </td>

  @endif
      </tr>
      @endforeach

                              
      
    </tbody>
  </table>

@else
  <div>No Records Found</div>
@endif

