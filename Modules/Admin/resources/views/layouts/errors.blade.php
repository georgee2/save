


	@if(\Session::has('success'))
    <div class="alert alert-success notification">
        <ul style="font-size: 20px;font-weight: bold;list-style-type: none;">
            <li><i class="fa fa-check-square-o"></i> {!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
	