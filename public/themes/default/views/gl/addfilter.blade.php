<?php
    $cm = date('0m', time());
    $cy = date('Y',time());
    $dperiod = $cy.$cm;
?>
{{Former::open_for_files_vertical(URL::to('gl'),'GET',array('class'=>''))}}
    <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <h5>Acc Period</h5>
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
            {{ Former::text('acc-period-from', '')
                    ->value(Input::get('acc-period-from',$dperiod))
                    ->class('form-control input-sm p-datepicker')
                    ->id('acc-period-from');
            }}

        </div>
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
            {{ Former::text('acc-period-to', '')
                    ->value(Input::get('acc-period-to',$dperiod))
                    ->class('form-control input-sm p-datepicker')
                    ->id('acc-period-to');
            }}
        </div>
    </div>

    <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <h5>Account</h5>
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
            {{ Former::select('acc-code-from', '')
                    ->options(Prefs::getCoa()->CoaToSelection('ACNT_CODE', 'ACNT_CODE', false ), Input::get('acc-code-from')  )
                    ->class('form-control form-white input-sm')
                    ->id('acc-code-from');
            }}

        </div>
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
            {{ Former::select('acc-code-to', '')
                    ->options(Prefs::getCoa()->CoaToSelection('ACNT_CODE', 'ACNT_CODE', false ), Input::get('acc-code-to') )
                    ->class('form-control form-white input-sm')
                    ->id('acc-code-to');
            }}
        </div>
    </div>

    {{ Form::submit('Generate',array('class'=>'btn btn-sm btn-primary pull-right'))}}

</form>

<span class="syncing" style="display:none;">Processing...</span>


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

        $('.p-datepicker').bootstrapDatepicker({
            startView: 1,
            minViewMode: 1,
            format: 'yyyy0mm'
        });

        $('#company-code').on('change',function(){
            oTable.draw();
        });

        $('#assign-product').on('click',function(e){
            $('#assign-modal').modal();
            e.preventDefault();
        });

        $('#do-generate').on('click',function(){
            oTable.draw();
            e.preventDefault();
        });

    });
</script>