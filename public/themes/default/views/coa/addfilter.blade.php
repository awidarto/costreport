
<form class="form-horizontal">
{{ Former::select('assigned', '')
        ->options(Prefs::getShopCategory()->shopcatToSelection('slug', 'name' ) )
        ->class('form-control form-white')
        ->id('assigned-product-filter');
}}
</form>

<a class="btn btn-transparent" id="assign-product"><i class="fa fa-plus-square-o"></i> Assign Merchant to Category</a>
<a class="btn btn-transparent" id="sync_legacy"><i class="fa fa-refresh"></i> Sync with Legacy Data</a>
<span class="syncing" style="display:none;">Processing...</span>

<div id="assign-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Assign Selected to</span></h3>
  </div>
  <div class="modal-body" >
        <h4 id="upload-title-id"></h4>
        {{ Former::select('assigned', 'Category')->options(Prefs::getShopCategory()->ShopCatToSelection('slug','name',true))->id('assigned-category')}}
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="do-assign">Assign</button>
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
        $('#assigned-product-filter').select2('destroy');

        $('#assigned-product-filter').on('change',function(){
            oTable.draw();
        });

        $('#assign-product').on('click',function(e){
            $('#assign-modal').modal();
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
                $.post('{{ URL::to('ajax/assignshopcat')}}',
                    {
                        category : $('#assigned-category').val(),
                        product_ids : ids
                    },
                    function(data){
                        $('#assign-modal').modal('hide');
                        oTable.draw();
                    }
                    ,'json');

            }else{
                alert('No shop selected.');
                $('#assign-modal').modal('hide');
            }

        });

        $('#sync_legacy').on('click',function(e){
            $('.syncing').show();
            $.post('{{ URL::to( $sync_url )}}',
                {},
                function(data){
                    if(data.result == 'OK'){
                        alert('Legacy data synced. ' + data.count + ' records updated' );
                        oTable.draw();
                    }else{
                        alert('Sync failed, nothing is changed');
                    }
                    $('.syncing').hide();
                }
                ,'json');
                e.preventDefault();
        });

    });
</script>