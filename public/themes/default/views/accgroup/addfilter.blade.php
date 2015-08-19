<?php
    $cm = date('0m', time());
    $cy = date('Y',time());
    $dperiod = $cy.$cm;
?>
{{Former::open_for_files_vertical(URL::to($submit_url),'GET',array('class'=>''))}}
    <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <h5>Company</h5>
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <?php
                $c = Input::get('acc-company');
                if($c == ''){
                    $c = Config::get('lundin.default_company');
                }
            ?>
            {{ Former::select('acc-company', '')
                    ->options(Prefs::getCompany()->CompanyToSelection('DB_CODE', 'DESCR', false ),  $c )
                    ->class('form-control form-white input-sm')
                    ->id('acc-company');
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