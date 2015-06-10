@extends('layout.maketwo')


@section('left')

    {{ Former::hidden('id')->value($formdata['_id']) }}
    {{ Former::text('SKU','Asset Code') }}
    {{ Former::select('status')->options(array('inactive'=>'Inactive','active'=>'Active'))->label('Status') }}

    {{ Former::select('locationId','Location')->options( Assets::getLocation()->LocationToSelection('_id','name',true) ) }}
    {{ Former::text('itemDescription','Description') }}

    {{ Former::text('tags','Tags')->class('tag_keyword') }}

    {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')

    <h5>Pictures</h5>
    <?php
        $fupload = new Fupload();
    ?>

    {{ $fupload->id('imageupload')->title('Select Picture')->label('Upload Picture')
        ->url('upload/asset/rack')
        ->singlefile(false)
        ->prefix('asset')
        ->multi(true)->make($formdata) }}

@stop


@section('aux')

<script type="text/javascript">

$(document).ready(function() {

    $('.pick-a-color').pickAColor({
        showHexInput:false
    });

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });


});

</script>

@stop