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
    font-size: 12px;
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

</style>


{{--
<div class="row-fluid box">
   <div class="col-md-12 box-content">
        <table class="table table-condensed dataTable">--}}
<div class="container" style="padding-top:40px;">
    <div class="row">
        <div class="col-md-6 command-bar">

            @if(isset($can_add) && $can_add == true)
                <a href="{{ URL::to($addurl) }}" class="btn btn-transparent btn-primary"><i class="fa fa-plus"></i> Add</a>
                <a href="{{ URL::to($importurl) }}" class="btn btn-transparent btn-primary"><i class="fa fa-upload"></i> Excel</a>
            @endif

            <a class="btn btn-info btn-transparent" id="download-xls"><i class="fa fa-download"></i> Excel</a>
            <a class="btn btn-info btn-transparent" id="download-csv"><i class="fa fa-download"></i> CSV</a>

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
        <table class="table table-striped mg-t dataTable">

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

            <?php
                $form = new Former();
            ?>

            <thead id="searchinput">
                <tr>
                <?php $index = -1 ;?>
                @foreach($heads as $in)
                    @if( $in[0] != 'select_all' && $in[0] != '')
                        @if(isset($in[1]['search']) && $in[1]['search'] == true)
                            @if(isset($in[1]['date']) && $in[1]['date'])
                                <td>
                                    <div id="{{ $index }}" class="input-append datepickersearch">
                                        <input id="{{ $index }}" name="search_{{$in[0]}}" data-format="dd-MM-yyyy" class="search_init form-control input-sm dateinput" type="text" placeholder="{{$in[0]}}" ></input>
                                        <span class="add-on">
                                            <i data-time-icon="fa fa-clock" data-date-icon="fa fa-calendar">
                                            </i>
                                        </span>
                                    </div>

                                </td>
                            @elseif(isset($in[1]['datetime']) && $in[1]['datetime'])
                                <td>
                                    <div id="{{ $index }}" class="input-append datetimepickersearch">
                                        <input id="{{ $index }}" name="search_{{$in[0]}}" data-format="dd-MM-yyyy hh:mm:ss" class="search_init form-control input-sm datetimeinput" type="text" placeholder="{{$in[0]}}" ></input>
                                        <span class="add-on">
                                            <i data-time-icon="fa fa-clock" data-date-icon="fa fa-calendar">
                                            </i>
                                        </span>
                                    </div>
                                </td>
                            @elseif(isset($in[1]['daterange']) && $in[1]['daterange'])
                                <td>
                                    <div class="input-append datetimerangepickersearch">
                                        <input id="{{ $index }}" name="search_{{$in[0]}}" class="search_init form-control input-sm daterangespicker" type="text" placeholder="{{$in[0]}}" />
                                    </div>
                                </td>
                            @elseif(isset($in[1]['datetimerange']) && $in[1]['datetimerange'])
                                <td>
                                    <div class="input-append datetimerangepickersearch">
                                        <input id="{{ $index }}" name="search_{{$in[0]}}" class="search_init form-control input-sm datetimerangepicker" type="text" placeholder="{{$in[0]}}" />
                                    </div>
                                </td>
                            @elseif(isset($in[1]['select']) && is_array($in[1]['select']))
                                <td>
                                    <input id="{{ $index }}" type="text" name="search_{{$in[0]}}" id="search_{{$in[0]}}" placeholder="{{$in[0]}}" value="" style="display:none;" class="search_init form-control input-sm {{ (isset($in[1]['class']))?$in[1]['class']:'filter'}}" />
                                    <div class="styled-select">
                                        <?php $select_class = (isset($in[1]['class']))?$in[1]['class']:'filter' ?>
                                        {{ Form::select('select_'.$in[0],$in[1]['select'],null,array('class'=>'selector form-control input-sm select-'.$select_class,'id'=>$index ))}}
                                    </div>
                                </td>
                            @else
                                <td>
                                    <input id="{{ $index }}" type="text" name="search_{{$in[0]}}" id="search_{{$in[0]}}" placeholder="{{$in[0]}}" value="" class="search_init form-control input-sm {{ (isset($in[1]['class']))?$in[1]['class']:'filter'}}" />
                                </td>
                            @endif
                        @else
                            @if(isset($in[1]['clear']) && $in[1]['clear'] == true)
                                <td><span id="clearsearch" style="cursor:pointer;">Clear Search</span></td>
                            @else
                                <td>&nbsp;</td>
                            @endif
                        @endif

                        <?php $index++; ?>

                    @elseif($in[0] == 'select_all')
                        <td>{{ Former::checkbox('select_all') }}</td>
                    @elseif($in[0] == '')
                        <td>&nbsp;</td>
                    @endif


                @endforeach
                </tr>
            </thead>

         <tbody>
            <!-- will be replaced by ajax content -->
         </tbody>
        </table>



<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>

<script type="text/javascript">

	var oTable;

	var current_pay_id = 0;
	var current_del_id = 0;
	var current_print_id = 0;

	function toggle_visibility(id) {
		$('#' + id).toggle();
	}

	/* Formating function for row details */
	function fnFormatDetails ( nTr )
	{
	    var aData = oTable.fnGetData( nTr );

	    //console.log(aData);

	    var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';

	    @include($row)

	    sOut += '</table>';

	    return sOut;
	}

    $(document).ready(function(){

    	$.fn.dataTableExt.oApi.fnStandingRedraw = function(oSettings) {
		    if(oSettings.oFeatures.bServerSide === false){
		        var before = oSettings._iDisplayStart;

		        oSettings.oApi._fnReDraw(oSettings);

		        // iDisplayStart has been reset to zero - so lets change it back
		        oSettings._iDisplayStart = before;
		        oSettings.oApi._fnCalculateEnd(oSettings);
		    }

		    // draw the 'current' page
		    oSettings.oApi._fnDraw(oSettings);
		};

		$.fn.dataTableExt.oApi.fnFilterClear  = function ( oSettings )
		{
		    /* Remove global filter */
		    oSettings.oPreviousSearch.sSearch = "";

		    /* Remove the text of the global filter in the input boxes */
		    if ( typeof oSettings.aanFeatures.f != 'undefined' )
		    {
		        var n = oSettings.aanFeatures.f;
		        for ( var i=0, iLen=n.length ; i<iLen ; i++ )
		        {
		            $('input', n[i]).val( '' );
		        }
		    }

		    /* Remove the search text for the column filters - NOTE - if you have input boxes for these
		     * filters, these will need to be reset
		     */
		    for ( var i=0, iLen=oSettings.aoPreSearchCols.length ; i<iLen ; i++ )
		    {
		        oSettings.aoPreSearchCols[i].sSearch = "";
		    }

		    /* Redraw */
		    oSettings.oApi._fnReDraw( oSettings );
		};


		$('.activity-list').tooltip();

		asInitVals = new Array();

        oTable = $('.dataTable').DataTable(
			{
				"bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "{{$ajaxsource}}",
				"oLanguage": { "sSearch": "Search "},
				"sPaginationType": "full_numbers",
                "sDom": 'lpirt',
				"iDisplayLength":50,
                "initComplete": function(settings, json){
                    //alert( 'DataTables has finished its initialisation.' );
                    $('.dataTables_length select').select2('destroy');
                },

				@if(isset($excludecol) && $excludecol != '')
				"oColVis": {
					"aiExclude": [ {{ $excludecol }} ]
				},
				@endif

				"oTableTools": {
					"sSwfPath": "{{ URL::to('/')  }}/swf/copy_csv_xls_pdf.swf"
				},

				"aoColumnDefs": [
				    { "bSortable": false, "aTargets": [ {{ $disablesort }} ] }
				 ],
			    "fnServerData": function ( sSource, aoData, fnCallback ) {
			    	{{ $js_additional_param }}
		            $.ajax( {
		                "dataType": 'json',
		                "type": "POST",
		                "url": sSource,
		                "data": aoData,
		                "success": fnCallback
		            } );
		        }

			}
        );


        @if($table_dnd == true)
        	oTable.rowReordering(
        		{
        			sURL:'{{ URL::to( $table_dnd_url ) }}',
        			sRequestType: 'GET',
        			iIndexColumn: {{ $table_dnd_idx }}
        		}
        	);
        @elseif($table_group == true)
        	oTable.rowGrouping({
        		bExpandableGrouping: {{ ($table_group_collapsible)?'true':'false' }},
        		iGroupingColumnIndex: {{ $table_group_idx }}
        	});
        @endif


    	//$('div.dataTables_length select').wrap('<div class="ingrid styled-select" />');


		$('.dataTable tbody tr td span.expander').on( 'click', function () {

			//console.log('expand !');

		    var nTr = $(this).parents('tr')[0];

		    if ( oTable.fnIsOpen(nTr) )
		    {
		        oTable.fnClose( nTr );
		    }
		    else
		    {
		        oTable.fnOpen( nTr, fnFormatDetails(nTr), 'details-expand' );
		    }
		} );


		//header search

		$('thead input.filter').keyup( function () {
            var search_index = this.id;
            oTable.column( search_index )
                    .search( this.value )
                    .draw();
		} );



		eldatetime = $('.datetimepickersearch').datetimepicker({
			minView:2,
			maxView:2
		});

		eldate = $('.dateinput').datetimepicker({
			minView:2,
			maxView:2
		});


		eldate.on('changeDate', function(e) {

			if(e.date.valueOf() != null){
				var dateval = e.date.valueOf();
			}else{
				var dateval = '';
			}
			var search_index = e.currentTarget.id;

            oTable.column( search_index )
                    .search( dateval )
                    .draw();
		});

		eldatetime.on('changeDate', function(e) {

			if(e.date.valueOf() != null){
				var dateval = e.date.valueOf();
			}else{
				var dateval = '';
			}
			var search_index = e.target.id;

            oTable.column( search_index )
                    .search( dateval )
                    .draw();
		});

        $('.datetimerangepicker').on('apply.daterangepicker',function(ev, picker){
            console.log(this.value);
            var search_index = this.id;
            var datevals = this.value;

            oTable.column( search_index )
                    .search( datevals )
                    .draw();

        });

        $('.daterangespicker').on('apply.daterangepicker',function(ev, picker){
            console.log(this.value);
            var search_index = this.id;
            var datevals = this.value;

            oTable.column( search_index )
                    .search( datevals )
                    .draw();

        });

		$('thead select.selector').change( function () {
			var search_index = this.id;
            oTable.column( search_index )
                    .search( this.value )
                    .draw();
		} );

		$('#clearsearch').click(function(){
			$('thead td input').val('');
            oTable.search( '' )
                .columns().search( '' )
                .draw();
		});

		$('#download-xls').on('click',function(){
			var flt = $('thead td input, thead td select');
			var dlfilter = [];

			flt.each(function(){
				if($(this).hasClass('datetimeinput') || $(this).hasClass('dateinput')){
					console.log(this.parentNode);
					dlfilter[parseInt(this.parentNode.id)] = this.value ;
				}else{
					dlfilter[parseInt(this.id)] = this.value ;
				}
			});
			console.log(dlfilter);

			//var sort = oTable.fnSettings().aaSorting;
            var sort = oTable.order();
			console.log(sort);
			$.post('{{ URL::to($ajaxdlxl) }}',{'filter' : dlfilter, 'sort':sort[0], 'sortdir' : sort[1] }, function(data) {
				if(data.status == 'OK'){

					window.location.href = data.urlxls;

				}
			},'json');

			return false;
		});

		$('#download-csv').on('click',function(){
			var flt = $('thead td input, thead td select');
			var dlfilter = [];

			flt.each(function(){
				if($(this).hasClass('datetimeinput') || $(this).hasClass('dateinput')){
					console.log(this.parentNode);
					dlfilter[parseInt(this.parentNode.id)] = this.value ;
				}else{
					dlfilter[parseInt(this.id)] = this.value ;
				}
			});
			console.log(dlfilter);

			//var sort = oTable.fnSettings().aaSorting;
            var sort = oTable.order();

			console.log(sort);
			$.post('{{ URL::to($ajaxdlxl) }}',{'filter' : dlfilter, 'sort':sort[0], 'sortdir' : sort[1] }, function(data) {
				if(data.status == 'OK'){

					window.location.href = data.urlcsv;

				}
			},'json');

			return false;
		});

		/*
		 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
		 * the footer
		 */
		/*
		$('thead input').each( function (i) {
			asInitVals[i] = this.value;
		} );

		$('thead input.filter').focus( function () {

			console.log(this);

			if ( this.className == 'search_init form-control input-sm' )
			{
				this.className = '';
				this.value = '';
			}
		} );

		$('thead input.filter').blur( function (i) {
			console.log(this);
			if ( this.value == '' )
			{
				this.className = 'search_init form-control input-sm';
				this.value = asInitVals[$('thead input').index(this)];
			}
		} );

		*/

        $('#select_all').on('click',function(){
            if($('#select_all').is(':checked')){
                $('.selector').prop('checked', true);
            }else{
                $('.selector').prop('checked',false);
            }
        });

        $('#select_all').on('ifChecked',function(){
            $('.selector').prop('checked', true);
        });

        $('#select_all').on('ifUnchecked',function(){
            $('.selector').prop('checked', false);
        });


		$('#confirmdelete').click(function(){

			$.post('{{ URL::to($ajaxdel) }}',{'id':current_del_id}, function(data) {
				if(data.status == 'OK'){
					//redraw table


					oTable.fnStandingRedraw();

					$('#delstatusindicator').html('Payment status updated');

					$('#deleteWarning').modal('toggle');

				}
			},'json');
		});

		$('#printstart').click(function(){

			var pframe = document.getElementById('print_frame');
			var pframeWindow = pframe.contentWindow;
			pframeWindow.print();

		});

		$('#upload-modal').on('hidden',function(){
			$('#pictureupload_files ul').html('');
			$('#pictureupload_uploadedform ul').html('');
		});

		$('#do-upload').on('click',function(){
			var form = $('#upload-form');
			console.log(form.serialize());

			$.post(
				'{{ URL::to('ajax/productpicture')}}',
					form.serialize(),
					function(data){
						if(data.result == 'OK:UPLOADED'){
							$('#upload-modal').modal('hide');
							oTable.draw();
						}else if( data.result == 'ERR:UPDATEFAILED' ){
							alert('Upload failed');
						}
					},
					'json'
				);

		});

		$('#upinv-modal').on('hidden',function(){
			$('#upinv-id').val('');
			$('#upinv-sku').val('');
			$('#upinv-container').html('');
		});

		$('#do-upinv').on('click',function(){
			var form = $('#upinv-form');
			console.log(form.serialize());

			$.post(
				'{{ URL::to('ajax/updateinventory')}}',
					form.serialize(),
					function(data){
						if(data.result == 'OK:UPDATED'){
							$('#upinv-modal').modal('hide');
							oTable.draw();
						}else if( data.result == 'ERR:UPDATEFAILED' ){
							alert('Update failed');
						}
					},
					'json'
				);

		});

		$('table.dataTable').click(function(e){

			if ($(e.target).is('.del')) {
				var _id = e.target.id;
				var answer = confirm("Are you sure you want to delete this item ?");

				console.log(answer);

				if (answer == true){

					$.post('{{ URL::to($ajaxdel) }}',{'id':_id}, function(data) {
						if(data.status == 'OK'){
							//redraw table

							oTable.draw();
							alert("Item id : " + _id + " deleted");
						}
					},'json');

				}else{
					alert("Deletion cancelled");
				}
		   	}

		   	{{ $js_table_event }}


			if ($(e.target).is('.thumbnail')) {
				var _id = e.target.id;
				var links = [];

				var g = $('.g_' + _id);

				g.each(function(){
					links.push({
						href:$(this).val(),
						title:$(this).data('caption')
					});
				})
				var options = {
					carousel: false
				};

				blueimp.Gallery(links, options);
				console.log(links);

		   	}


			if ($(e.target).is('.pop')) {
				var _id = e.target.id;
				var _rel = $(e.target).attr('rel');

				$.fancybox({
					type:'iframe',
					href: '{{ URL::to('/')  }}' + '/' + _rel + '/' + _id,
					autosize: true
				});

		   	}

			if ($(e.target).is('.upload')) {
				var _id = e.target.id;
				var _rel = $(e.target).attr('rel');
				var _status = $(e.target).data('status');

				$('#loading-pictures').show();

				$.post('{{ URL::to($product_info_url) }}', { product_id: _id },
					function(data){

						$('#loading-pictures').hide();

						if(data.result == 'OK:FOUND'){
							var defaultpic = data.data.defaultpic;

							if(data.data.files){

					            $.each(data.data.files, function (index, file) {
					            	console.log(file);
                                    @if( isset($prefix) && $prefix != '' && !is_null($product_info_url) )
					            	{{ View::make($prefix.'.jsajdetail')->render() }}
                                    @else
                                    {{ View::make('fupload.jsajdetail')->render() }}
                                    @endif


					                $(thumb).appendTo('#pictureupload_files ul');

					                var upl = '<li id="fdel_' + file.file_id +'" ><input type="hidden" name="delete_type[]" value="' + file.delete_type + '">';
					                upl += '<input type="hidden" name="delete_url[]" value="' + file.delete_url + '">';
					                upl += '<input type="hidden" name="filename[]" value="' + file.filename  + '">';
					                upl += '<input type="hidden" name="filesize[]" value="' + file.filesize  + '">';
					                upl += '<input type="hidden" name="temp_dir[]" value="' + file.temp_dir  + '">';
					                upl += '<input type="hidden" name="thumbnail_url[]" value="' + file.thumbnail_url + '">';
					                upl += '<input type="hidden" name="large_url[]" value="' + file.large_url + '">';
					                upl += '<input type="hidden" name="medium_url[]" value="' + file.medium_url + '">';
					                upl += '<input type="hidden" name="full_url[]" value="' + file.full_url + '">';
					                upl += '<input type="hidden" name="filetype[]" value="' + file.filetype + '">';
					                upl += '<input type="hidden" name="fileurl[]" value="' + file.fileurl + '">';
					                upl += '<input type="hidden" name="file_id[]" value="' + file.file_id + '"></li>';

					                $(upl).appendTo('#pictureupload_uploadedform ul');

					            });



							}

						}

					},'json');

				$('#upload-modal').modal();

				$('#upload-id').val(_id);

				$('#upload-title-id').html('SKU : ' + _rel);

		   	}

			if ($(e.target).is('.upinv')) {
				var _id = e.target.id;
				var _rel = $(e.target).attr('rel');
				var _status = $(e.target).data('status');

				$('#inv-loading-pictures').show();

				$('#upinv-id').val(_id);
				$('#upinv-sku').val(_rel);

				$.post('{{ URL::to('ajax/inventoryinfo') }}', { product_id: _id },
					function(data){

						$('#inv-loading-pictures').hide();

						if(data.result == 'OK:FOUND'){
							$('#upinv-container').html(data.html);
						}

					},'json');

				$('#upinv-modal').modal();

				$('#upinv-id').val(_id);

				$('#upinv-title-id').html('SKU : ' + _rel);

		   	}


			if ($(e.target).is('.chg')) {
				var _id = e.target.id;
				var _rel = $(e.target).attr('rel');
				var _status = $(e.target).data('status');

				$('#chg-modal').modal();

				$('#trx-chg').val(_id);
				$('#stat-chg').val(_status);

				$('#trx-order').html('Order # : ' + _rel);

		   	}

			if ($(e.target).is('.propchg')) {
				var _id = e.target.id;
				var _rel = $(e.target).attr('rel');
				var _status = $(e.target).data('status');

				console.log(_status);

				$('#prop-chg-modal').modal();
				$('#prop-trx-chg').val(_id);
				$('#prop-stat-chg').val(_status);
				$('#prop-trx-order').html('Property ID : ' + _rel);

		   	}

		});

		$('#clear-attendance').on('click',function(){

			var answer = confirm("Are you sure you want to delete this item ?");

			if (answer == true){

	            $.post('{{ URL::to('ajax/clearattendance')}}',
		            {
		                trx_id:$('#trx-chg').val(),
		                status:$('#stat-chg').val()
		            },
		            function(data){
		            	if(data.result == 'OK'){
		            		alert('Attendance data cleared, ready to start the event.');
		            		oTable.draw();
		            	}
		            },
	            'json');

			}else{
				alert("Clear data cancelled");
			}


		});

		$('#clear-log').on('click',function(){

				var answer = confirm("Are you sure you want to delete this item ?");

				if (answer == true){

		            $.post('{{ URL::to('ajax/clearlog')}}',
			            {
			            },
			            function(data){
			            	if(data.result == 'OK'){
			            		alert('Attendance Log data cleared, ready to start the event.')
			            	}
			            },
		            'json');

				}else{
					alert("Clear data cancelled");
				}

		});

		$('#save-chg').on('click',function(){
            $.post('{{ URL::to('ajax/changestatus')}}',
            {
                trx_id:$('#trx-chg').val(),
                status:$('#stat-chg').val()
            },
            function(data){
				$('#chg-modal').modal('hide');
            },
            'json');
		});

		$('#chg-modal').on('hidden', function () {
			oTable.fnDraw();
		})


		$('#prop-save-chg').on('click',function(){
            $.post('{{ URL::to('ajax/propchangestatus')}}',
            {
                trx_id:$('#prop-trx-chg').val(),
                status:$('#prop-stat-chg').val()
            },
            function(data){
				$('#prop-chg-modal').modal('hide');
            },
            'json');
		});

		$('#prop-chg-modal').on('hidden', function () {
			oTable.fnDraw();
		});

        $('.select-location').on('change',function(){
            var location = $('.select-location').val();
            console.log(location);

            $.post('{{ URL::to('asset/rack' ) }}',
                {
                    loc : location
                },
                function(data){
                    var opt = updateselector(data.html);
                    $('.select-rack').html(opt);
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

		function dateFormat(indate) {
	        var yyyy = indate.getFullYear().toString();
	        var mm = (indate.getMonth()+1).toString(); // getMonth() is zero-based
	        var dd  = indate.getDate().toString();

	        return (dd[1]?dd:"0"+dd[0]) + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + yyyy;
   		}


    });
  </script>

@stop

@section('modals')

<div id="print-modal" class="modal fade large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Print Barcode Tag</h3>
    </div>
        <div class="modal-body">

        </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="prop-save-chg">Save changes</button>
    </div>
</div>


<div id="chg-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Change Transaction Status</h3>
  </div>
  <div class="modal-body">
    <h4 id="trx-order"></h4>
    {{ Former::hidden('trx_id')->id('trx-chg') }}
    {{ Former::select('status', 'Status')->options(Config::get('ia.trx_status'))->id('stat-chg')}}
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="save-chg">Save changes</button>
  </div>
</div>

<div id="upload-modal" class="modal fade" tabindex="-1" data-width="760" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Upload Pictures</span></h3>
  </div>
  <div class="modal-body" >
        <h4 id="upload-title-id"></h4>
        {{ Former::open()->id('upload-form') }}
        {{ Former::hidden('upload_id')->id('upload-id') }}

        <?php
            $fupload = new Fupload();
        ?>

        {{ $fupload->id('pictureupload')->title('Select Images')->label('Upload Images')->make() }}

        {{ Former::close() }}
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="do-upload">Save changes</button>
  </div>
</div>

<div id="upinv-modal" class="modal fade large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Update Inventory</span></h3>
  </div>
  <div class="modal-body" >
        <h4 id="upinv-title-id"></h4>

        {{ Former::open()->id('upinv-form') }}
        {{ Former::hidden('id')->id('upinv-id') }}
        {{ Former::hidden('SKU')->id('upinv-sku') }}
            <span id="inv-loading-pictures" style="display:none;" ><img src="{{URL::to('/') }}/images/loading.gif" />loading existing pictures...</span>
        <div id="upinv-container">

        </div>
        {{ Former::close() }}
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="do-upinv">Save changes</button>
  </div>
</div>

{{ $modal_sets }}


@stop