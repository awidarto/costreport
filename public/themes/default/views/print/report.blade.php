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
    text-align: center;
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

@if(@additional_filter != '')
<div class="row">
    {{ $additional_filter }}
</div>
@endif

@foreach($tables as $table)

    {{ $table }}

@endforeach


<script type="text/javascript">

    $(document).ready(function(){
        window.print();
    });
  </script>

@stop

@section('modals')

@stop