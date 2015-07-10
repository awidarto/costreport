@extends('layout.makeprint')

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
    border: none !important;
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
        window.print();
    });
  </script>

@stop

@section('modals')

@stop