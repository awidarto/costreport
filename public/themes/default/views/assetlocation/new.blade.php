@extends('layout.maketwo')

@section('left')

    {{ Former::text('name','Name') }}
    {{ Former::text('slug','Permalink')->id('permalink') }}
    {{ Former::text('venue','Venue') }}
    {{ Former::text('address','Address') }}
    {{ Former::text('phone','Phone') }}

    {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop
@section('right')
    <div class="row">
        <div class="col-md-6">
            {{ Former::text('latitude','Latitude') }}
        </div>
        <div class="col-md-6">
            {{ Former::text('longitude','Longitude') }}
        </div>
    </div>

    {{ Former::select('category')->options(Config::get('asset.location_category'))->label('Category') }}
    {{ Former::textarea('description','Description')->class('editor form-control') }}
    {{ Former::text('tags','Tags')->class('tag_keyword') }}

@stop

@section('aux')
<script type="text/javascript">

$(document).ready(function() {


    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

});

</script>

@stop