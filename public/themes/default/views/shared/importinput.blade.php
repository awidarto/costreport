@extends('layout.maketwo')


@section('left')

<h5>Import {{ $title }}</h5>

{{Former::open_for_files_vertical($submit,'POST',array('class'=>'custom addAttendeeForm'))}}
        {{ Former::file('inputfile','Select file ( .xls, .xlsx )') }}

        {{ Former::hidden( 'controller',$back ) }}
        {{ Former::hidden( 'importkey',$importkey ) }}
        <div class="row">
            <div class="col-md-4">
                {{ Former::text('headindex','Row containing header')->value(2) }}
                {{ Former::text('firstdata','Data starting at row')->value(3) }}
            </div>
        </div>

        {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

{{Former::close()}}

@stop

@section('aux')

<script type="text/javascript">


$(document).ready(function() {

});

</script>

@stop