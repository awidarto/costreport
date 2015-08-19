<?php
    $cm = date('0m', time());
    $cy = date('Y',time());
    $dperiod = $cy.$cm;
?>

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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

                    $companies = Prefs::getCompany()->CompanyToArray();

                    $cname = '';

                    foreach ($companies as $com) {
                        if($com->DB_CODE == $c){
                            $cname = $com->DESCR;
                        }
                    }
                ?>
                <h5>{{ $cname }}</h5>

            </div>
        </div>
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <h5>AFE</h5>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">

                <?php
                    $c = Input::get('acc-company');
                    if($c == ''){
                        $c = Config::get('lundin.default_company');
                    }

                    $afes = Prefs::getAfe($c)->AfeToArray();

                    $afename = '';

                    $f = Input::get('acc-afe');

                    foreach ($afes as $afe) {
                        if($afe->ANL_CODE == $f){
                            $afename = $afe->NAME;
                        }
                    }
                ?>
                <h5>{{ $afename }}</h5>

            </div>
        </div>

    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <h5>Period</h5>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                <h5>{{ Input::get('acc-period-from',$dperiod) }}</h5>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                <h5>{{ Input::get('acc-period-to',$dperiod) }}</h5>
            </div>
        </div>
    </div>


