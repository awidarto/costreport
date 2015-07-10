@extends('layout.make')

@section('content')

<style type="text/css">
.act{
    cursor: pointer;
}

.pending{
    padding: 4px;
    background-color: yellow;
}

.canceled{
    padding: 4px;
    background-color: red;
    color:white;
}

.sold{
    padding: 4px;
    background-color: green;
    color:white;
}

th{
    border-right:thin solid #eee;
    border-top: thin solid #eee;
    vertical-align: top;
}

th:first-child{
    border-left:thin solid #eee;
}

.del,.upload,.upinv,.outlet,.action{
    cursor:pointer;
}

td.group{
    background-color: #AAA;
}

.ingrid.styled-select select{
    width:100px;
}

.table-responsive{
    overflow-x: auto;
}

th.action{
    min-width: 150px !important;
    max-width: 200px !important;
    width: 175px !important;
}

td i.fa{
    font-size: 18px;
    line-height: 20px;
}

td a{
    line-height: 22px;
}

td{
    font-size: 11px;
    padding: 4px 6px 6px 4px !important;
    hyphens:none !important;
}

select.input-sm {
    height: 30px;
    line-height: 30px;
    padding-top: 0px !important;
}

.panel-heading{
    font-size: 20px;
    font-weight: bold;
}

.tag{
    padding: 2px 4px;
    margin: 2px;
    background-color: #CCC;
    display:inline-block;
}

.calendar-date thead th{
    border: none;
}

.column-amt{
    text-align: right;
}

.column-nowrap{
    white-space: nowrap !important;
}

tr.row-underline {
    border-bottom: thin solid #BBB !important;
    background-color: #FFF;
}

tr.row-underline td{
    background-color: transparent;
}

tr.row-overline {
    border-top: thin solid #BBB !important;
    background-color: #FFF;
}

tr.row-overline td{
    background-color: transparent;
}

tr.row-doubleunderline {
    background-color: #FFF;
}

tr.row-doubleunderline td.column-amt{
    border-bottom: double #BBB !important;
    background-color: transparent;
}

</style>


{{--
<div class="row-fluid box">
   <div class="col-md-12 box-content">
        <table class="table table-condensed dataTable">--}}
<div class="container" style="padding-top:40px;">
    <div class="row">
        <div class="col-md-6 command-bar">

            @if(isset($can_add) && $can_add == true)
                <a href="{{ URL::to($addurl) }}" class="btn btn-sm btn-transparent btn-primary"><i class="fa fa-plus"></i> Add</a>
                <a href="{{ URL::to($importurl) }}" class="btn btn-sm btn-transparent btn-primary"><i class="fa fa-upload"></i> Excel</a>
            @endif

            <a class="btn btn-sm btn-info btn-transparent" id="download-xls"><i class="fa fa-download"></i> Excel</a>
            <a class="btn btn-sm btn-info btn-transparent" id="download-csv"><i class="fa fa-download"></i> CSV</a>

            <?php
                $in = Input::get();
                if(count($in) > 0){
                    $get = array();
                    foreach($in as $k=>$v){
                        $get[] = $k.'='.$v;
                    }
                    $print_url = $printlink.'?'.implode('&', $get);
                }else{
                    $print_url = $printlink;
                }
            ?>
            <a href="{{ URL::to($print_url) }}" target="_blank" class="btn btn-sm btn-transparent btn-primary"><i class="fa fa-print"></i> Print</a>

            @if(isset($is_report) && $is_report == true)
                {{ $report_action }}
            @endif
            @if(isset($is_additional_action) && $is_additional_action == true)
                {{ $additional_action }}
            @endif

         </div>
         <div class="col-md-6 command-bar">
            {{ $additional_filter }}

         </div>
    </div>
</div>
        <table class="table">

            <thead>

                <tr>
                    @foreach($heads as $head)
                        @if(is_array($head))
                            <th
                                @foreach($head[1] as $key=>$val)
                                    @if(!is_array($val))
                                        {{ $key }}="{{ $val }}"
                                    @endif
                                @endforeach
                            >
                            {{ $head[0] }}
                            </th>
                        @else
                        <th>
                            {{ $head }}
                        </th>
                        @endif
                    @endforeach
                </tr>
                @if(isset($secondheads) && !is_null($secondheads))
                    <tr>
                    @foreach($secondheads as $head)
                        @if(is_array($head))
                            <th
                                @foreach($head[1] as $key=>$val)
                                    @if($key != 'search')
                                        {{ $key }}="{{ $val }}"
                                    @endif
                                @endforeach
                            >
                            {{ $head[0] }}
                            </th>
                        @else
                        <th>
                            {{ $head }}
                        </th>
                        @endif
                    @endforeach
                    </tr>
                @endif
            </thead>

         <tbody>

            @foreach($table['aaData'] as $row)
                <?php
                    if(isset($row['extra']['rowclass'])){
                        $rowclass = $row['extra']['rowclass'];
                    }else{
                        $rowclass = '';
                    }
                    unset($row['extra']);
                    $f = 0;
                 ?>
                <tr class='{{ $rowclass }}' >
                    @foreach( $row as $col)
                        <td
                            @foreach($fields[$f][1] as $key=>$val)
                                {{ $key }}="{{ $val }}"
                            @endforeach
                        >
                            {{ $col }}
                        </td>
                        <?php
                            $f++;
                        ?>
                    @endforeach
                </tr>
            @endforeach
         </tbody>
        </table>


<script type="text/javascript">

    $(document).ready(function(){

    });
  </script>

@stop

@section('modals')

@stop