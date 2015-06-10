@extends('layout.maketwo')

@section('left')
        <h5>Ad Asset Info</h5>
        {{ Former::hidden('id')->value($formdata['_id']) }}

        {{ Former::text('itemDescription','Description') }}
        <div class="row">
            <div class="col-md-3">
                {{ Former::select('externalLink')->options(array('yes'=>'Yes','no'=>'No'))->label('Link to External URL') }}
            </div>
            <div class="col-md-9">
                {{ Former::text('extURL','External URL') }}
            </div>
        </div>

        {{ Former::select('status')->options(array('inactive'=>'Inactive','active'=>'Active','scheduled'=>'Scheduled'))->label('Status') }}

        {{-- Former::select('assetType','Device Type')->options( Assets::getType()->TypeToSelection('type','type',true) ) --}}
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                {{ Former::text('fromDate','From')->class('form-control eventdate')
                    ->id('fromDate')
                    //->data_format('dd-mm-yyyy')
                    ->append('<i class="fa fa-th"></i>') }}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                {{ Former::text('toDate','Until')->class('form-control eventdate')
                    ->id('toDate')
                    //->data_format('dd-mm-yyyy')
                    ->append('<i class="fa fa-th"></i>') }}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                {{ Former::select('isDefault')->options(array('yes'=>'Yes','no'=>'No'))->label('Set As Default Ad') }}
            </div>
        </div>

        <h5>Advertiser</h5>
        {{ Former::text('merchantName','Merchant')->class('form-control auto_merchant') }}
        {{ Former::text('merchantId','Merchant ID')->class('form-control auto_merchant')->id('merchant-id')->help('autocomplete, use to get merchant ID') }}

        {{ Former::text('tags','Tags')->class('tag_keyword') }}

        <h5>Advertorial</h5>
        {{ Former::textarea('advertorial','Advertorial Body')->class('editor')->rows(10)->columns(20) }}

        {{ Form::submit('Save',array('class'=>'btn btn-primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}

@stop

@section('right')


        <h5>Banner Image</h5>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                {{ Former::select('useImage')->label('Image Source')->options(array('linked'=>'Linked Image','upload'=>'Uploaded Image'))->label('Choose whether to use linked of uploaded image') }}
            </div>
        </div>
        <h6>Link to Image</h6>
        {{ Former::text('extImageURL','External Image URL')->help('Image URL eg: "http://some.domain/image.jpg"') }}


        <h6>Upload Image</h6>
        <?php
            $fupload = new Fupload();
        ?>
        {{ $fupload->id('imageupload')->title('Select Picture')->label('Upload Picture')
            ->url('upload/asset')
            ->singlefile(true)
            ->prefix('asset')
            ->multi(false)->make($formdata) }}


@stop

@section('modals')

@stop

@section('aux')
{{ HTML::style('css/summernote.css') }}
{{ HTML::style('css/summernote-bs3.css') }}

{{ HTML::script('js/summernote.min.js') }}

<script type="text/javascript">


$(document).ready(function() {


    $('.pick-a-color').pickAColor();

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

    $('.editor').summernote({
        height:500
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

    $('.auto_merchant').autocomplete({
        source: base + 'ajax/merchant',
        select: function(event, ui){
            $('#merchant-id').val(ui.item.id);
        }
    });

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