@extends('layout.maketwo')


@section('left')

    {{ Former::hidden('id')->value($formdata['_id']) }}
    {{ Former::text('holidayDate','Date')->id('title') }}
    {{ Former::textarea('holidayDescription','Description')->class('form-control') }}

    {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
    {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop
@section('right')
@stop


@section('aux')

<style type="text/css">
#lyric{
    min-height: 350px;
    height: 400px;
}
</style>

{{ HTML::script('js/wysihtml5-0.3.0.min.js') }}
{{ HTML::script('js/parser_rules/advanced.js') }}

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


});

</script>

@stop