<div class="row">
    {{ Former::open_vertical($report_action)->method('get') }}
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        {{ Former::text('date_filter','Date Range')->id('date_filter')->class('search_init form-control input-sm filterdaterangepicker')->placeholder('pick date range')->value(Input::get('date_filter')) }}

        {{ Former::text('merchantName','Merchant')->class('form-control auto_merchant')->help('autocomplete, use to get merchant ID') }}
        {{ Former::hidden('merchantId','Merchant ID')->class('form-control auto_merchant')->id('merchant-id') }}

        {{ Form::submit('Generate',array('name'=>'submit','class'=>'btn btn-primary input-sm pull-right'))}}
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    </div>
    {{ Former::close()}}
</div>

<div id="print-modal" class="modal fade large" tabindex="-1" role="dialog" aria-labelledby="myPrintModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myPrintModalLabel">Print Selected Codes</span></h5>
    </div>
    <div class="modal-body" style="overflow:auto;" >
        <h6>Print options</h6>
        <?php
            $d = Prefs::getPrintDefault('asset');
        ?>
        <div style="border-bottom:thin solid #ccc;" class="row form-vertical clearfix">
            <div class="col-md-2">
                {{ Former::text('label_columns','Number of columns')->value($d->col)->id('label_columns')->class('form-control input-sm') }}
                {{ Former::text('label_res','Resolution')->value($d->res)->id('label_res')->class('form-control input-sm') }}
            </div>
            <div class="col-md-2">
                {{ Former::text('label_cell_height','Label height')->value($d->cell_height)->id('label_cell_height')->class('form-control input-sm') }}
                {{ Former::text('label_cell_width','Label width')->value($d->cell_width )->id('label_cell_width')->class('form-control input-sm') }}
            </div>
            <div class="col-md-2">
                {{ Former::text('label_margin_right','Label margin right')->value( $d->margin_right )->id('label_margin_right')->class('form-control input-sm') }}
                {{ Former::text('label_margin_bottom','Label margin bottom')->value( $d->margin_bottom )->id('label_margin_bottom')->class('form-control input-sm') }}
            </div>
            <div class="col-md-2">
                {{ Former::text('label_offset_right','Page left offset')->value('40')->id('label_offset_right')->class('form-control input-sm') }}
                {{ Former::text('label_offset_bottom','Page top offset')->value('20')->id('label_offset_bottom')->class('form-control input-sm') }}
            </div>
            <div class="col-md-2">
                {{ Former::text('font_size','Font size')->value( $d->font_size )->id('font_size')->class('form-control input-sm') }}
                {{ Former::select('code_type','Code type')->id('code_type')->options(array('qr'=>'QR','pdf417'=>'PDF417'), $d->code_type ) }}
            </div>
            <div class="col-md-2">
                <button id="label_default" class="form-control" >make default</button>
                <button id="label_refresh" class="form-control" >refresh</button>
            </div>
        </div>
        <input type="hidden" value="" id="session_name" />
        <input type="hidden" value="" id="label_id" />

        <div style="height:100%;width:100%;">
            <iframe id="label_frame" name="label_frame" width="100%" height="90%"
            marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto"
            title="Dialog Title">Your browser does not suppr</iframe>

        </div>
    </div>
    <div class="modal-footer" style="z-index:20000;">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-primary" id="do-print">Print</button>
    </div>
</div>

<style type="text/css">

.modal.large {
    width: 80%; /* respsonsive width */
    margin-left:-40%; /* width/2) */
}

.modal.large .modal-body{
    max-height: 800px;
    height: 500px;
    overflow: auto;
}

button#label_refresh{
    margin-top: 27px;
}

button#label_default{
    margin-top: 28px;
}

</style>

<script type="text/javascript">
    $(document).ready(function(){

        $('#label_refresh').on('click',function(){

            var sessionname = $('#session_name').val();

            var col = $('#label_columns').val();
            var res = $('#label_res').val();
            var cell_width = $('#label_cell_width').val();
            var cell_height = $('#label_cell_height').val();
            var margin_right = $('#label_margin_right').val();
            var margin_bottom = $('#label_margin_bottom').val();
            var font_size = $('#font_size').val();
            var code_type = $('#code_type').val();
            var offset_left = $('#label_offset_left').val();
            var offset_top = $('#label_offset_top').val();
            var src = '{{ URL::to('asset/printlabel')}}/' + sessionname + '/' + col + ':' + res + ':' + cell_width + ':' + cell_height + ':' + margin_right + ':' + margin_bottom + ':' + font_size + ':' + code_type + ':' + offset_left + ':' + offset_top;

            $('#label_frame').attr('src',src);

            e.preventDefault();
        });

        $('#print_barcodes').on('click',function(){

            var props = $('.selector:checked');
            var ids = [];
            $.each(props, function(index){
                ids.push( $(this).val() );
            });

            console.log(ids);

            if(ids.length > 0){
                $.post('{{ URL::to('ajax/sessionsave')}}',
                    {
                        data_array : ids
                    },
                    function(data){
                        if(data.result == 'OK'){
                            $('#session_name').val(data.sessionname);

                            var col = $('#label_columns').val();
                            var res = $('#label_res').val();
                            var cell_width = $('#label_cell_width').val();
                            var cell_height = $('#label_cell_height').val();
                            var margin_right = $('#label_margin_right').val();
                            var margin_bottom = $('#label_margin_bottom').val();
                            var font_size = $('#font_size').val();
                            var code_type = $('#code_type').val();
                            var offset_left = $('#label_offset_left').val();
                            var offset_top = $('#label_offset_top').val();
                            var src = '{{ URL::to('asset/printlabel')}}/' + data.sessionname + '/' + col + ':' + res + ':' + cell_width + ':' + cell_height + ':' + margin_right + ':' + margin_bottom + ':' + font_size + ':' + code_type + ':' + offset_left + ':' + offset_top;
                            $('#label_frame').attr('src',src);
                            $('#print-modal').modal('show');
                        }else{
                            $('#print-modal').modal('hide');
                        }
                    }
                    ,'json');

            }else{
                alert('No product selected.');
                $('#print-modal').modal('hide');
            }

        });

        $('.auto_merchant').autocomplete({
            source: base + 'ajax/merchant',
            select: function(event, ui){
                $('#merchant-id').val(ui.item.id);
            }
        });

        $('#do-print').click(function(){

            var pframe = document.getElementById('label_frame');
            var pframeWindow = pframe.contentWindow;
            pframeWindow.print();

        });

        $('#label_default').on('click',function(){
            var type = 'asset';
            var col = $('#label_columns').val();
            var res = $('#label_res').val();
            var cell_width = $('#label_cell_width').val();
            var cell_height = $('#label_cell_height').val();
            var margin_right = $('#label_margin_right').val();
            var margin_bottom = $('#label_margin_bottom').val();
            var font_size = $('#font_size').val();
            var code_type = $('#code_type').val();
            var offset_left = $('#label_offset_left').val();
            var offset_top = $('#label_offset_top').val();

            $.post('{{ URL::to('ajax/printdefault')}}',
                {
                    type : type,
                    col : col,
                    res : res,
                    cell_width : cell_width,
                    cell_height : cell_height,
                    margin_right : margin_right,
                    margin_bottom : margin_bottom,
                    font_size : font_size,
                    code_type : code_type,
                    offset_left : offset_left,
                    offset_top : offset_top
                },
                function(data){
                    if(data.result == 'OK'){
                        alert('Print parameters set as default');
                    }else{
                        alert('Print parameters failed to set default');
                    }
                }
                ,'json');
                e.preventDefault();

        });


        $('#do-assign').on('click',function(){
            var props = $('.selector:checked');
            var ids = [];
            $.each(props, function(index){
                ids.push( $(this).val() );
            });

            console.log(ids);

            if(ids.length > 0){
                $.post('{{ URL::to('ajax/assignoutlet')}}',
                    {
                        outlet : $('#assigned-category').val(),
                        product_ids : ids
                    },
                    function(data){
                        $('#assign-modal').modal('hide');
                        oTable.fnDraw();
                    }
                    ,'json');

            }else{
                alert('No product selected.');
                $('#assign-modal').modal('hide');
            }

        });

        $('#unassign-prop').on('click',function(){
            var props = $('.selector:checked');
            var ids = [];
            $.each(props, function(index){
                ids.push( $(this).val() );
            });

            console.log(ids);

            var answer = confirm('Are you sure you want to un-assign these Properties ?');

            console.log(answer);

            if (answer == true){

                $.post('{{ URL::to('ajax/unassign')}}',
                {
                    user_id : $('#assigned-agent-filter').val(),
                    prop_ids : ids
                },
                function(data){
                    oTable.fnDraw();
                }
                ,'json');

            }else{
                alert("Unassignment cancelled");
            }

        });

    });
</script>