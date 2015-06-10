@extends('layout.maketwo')

@section('left')
        <h4>Role</h4>

        {{ Former::hidden('id')->value($formdata['_id']) }}

        {{ Former::text('rolename','Role Name') }}

        {{ Former::textarea('description','Description') }}

        {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')
        <h4>Permission</h4>

        @foreach(Config::get('role.entities') as $e)
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <h6>{{ ucwords($e) }}</h6>
                <ul>
                    @foreach( Config::get('role.actions') as $a )
                        <li>
                            <label>
                                <input type="checkbox" name="{{ $e.'_'.$a }}" {{ ( isset($formdata[$e.'_'.$a]) && $formdata[$e.'_'.$a] == 'on')?'checked':'' }} > {{ $a }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

@stop

@section('modals')

@stop

@section('aux')

<script type="text/javascript">


$(document).ready(function() {


    $('.pick-a-color').pickAColor();

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

    $('#location').on('change',function(){
        var location = $('#location').val();
        console.log(location);

        $.post('{{ URL::to('asset/rack' ) }}',
            {
                loc : location
            },
            function(data){
                var opt = updateselector(data.html);
                $('#rack').html(opt);
            },'json'
        );

    })

    function updateselector(data){
        var opt = '';
        for(var k in data){
            opt += '<option value="' + k + '">' + data[k] +'</option>';
        }
        return opt;
    }


});

</script>

@stop