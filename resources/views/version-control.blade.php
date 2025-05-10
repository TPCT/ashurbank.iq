@if(isset($before_edit_link, $after_edit_link))
    <div style="height: 100vh; display: flex; justify-content: center">
        <iframe src="{{$before_edit_link}}" style="width: 75vw; zoom:0.75;"></iframe>
        <iframe src="{{$after_edit_link}}" style="width: 75vw; zoom:0.75;"></iframe>
    </div>
@endif