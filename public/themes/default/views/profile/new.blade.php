@extends('layout.maketwo')


@section('left')
        <h5>User Info</h5>

        {{ Former::select('salutation')->options(Config::get('kickstart.salutation'))->label('Salutation') }}
        {{ Former::text('firstname','First Name') }}
        {{ Former::text('lastname','Last Name') }}
        {{ Former::text('mobile','Mobile') }}

        {{ Former::text('address_1','Address') }}
        {{ Former::text('address_2',' ') }}
        {{ Former::text('city','City') }}

        {{ Former::text('state','State / Province') }}

        {{ Former::select('countryOfOrigin')->id('country')->options(Config::get('country.countries'))->label('Country of Origin') }}

        {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')
        {{ Former::text('email','Email') }}

        {{ Former::password('pass','Password')->help('Leave blank for no changes') }}
        {{ Former::password('repass','Repeat Password') }}

        {{ Former::select('roleId')->options(Prefs::getRole()->RoleToSelection('_id','rolename' ) )->label('Role')}}

        <h5>Avatar</h5>
        <?php
            $fupload = new Fupload();
        ?>

        {{ $fupload->id('photoupload')->title('Select Photo')->label('Upload Photo')
            ->url('upload/avatar')
            ->singlefile(true)
            ->prefix('photo')
            ->multi(false)->make() }}

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


});

</script>

@stop