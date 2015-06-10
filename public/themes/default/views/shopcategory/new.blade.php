@extends('layout.maketwo')

@section('left')

    {{ Former::text('name','Name')->id('title') }}
    {{ Former::text('slug','Permalink')->id('permalink') }}
    {{ Former::textarea('description','Description')->class('form-control') }}

    {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop
@section('right')
@stop


@section('aux')


{{ HTML::script('js/wysihtml5-0.3.0.min.js') }}
{{ HTML::script('js/parser_rules/advanced.js') }}

<style type="text/css">
#lyric{
    min-height: 350px;
    height: 400px;
}

</style>

<script type="text/javascript">

$(document).ready(function() {
    /*
    $('select').select2({
      width : 'resolve'
    });
    */

    $('#title').keyup(function(){
        var title = $('#title').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

    //$('#color_input').colorPicker();

});

</script>

@stop