
<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="container" style="padding-top: 10px; ">
<div class="row">
    <div class="col-md-12">
        <?php 
         $success = $this->session->userdata('success');
         if($success !=""){
             ?>
             <div class="alert-success"><?php echo $success;?></div>
        <?php 
    } 
    ?>
    <?php 
         $failure= $this->session->userdata('failure');
         if($failure !=""){
             ?>
             <div class="alert-success"><?php echo $failure;?></div>
        <?php 
    } 
    ?>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="row">
        <div class ="col-6"><h3>View Users</h3></div>
        <div class ="col-6 text-right">
    <a href="<?php echo base_url().'insert_form';?>" class="btn btn-primary">Create</a>
</div>
 </div>
 <hr>
    </div>
</div>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Pincode</th>
                    <th width="100">Edit</th>
                    <th width="100">Delete</th>
                </tr>

               
            </table>
            <div id="dataTableId"></div>
        </div>
    </div>
</div>

<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<script type="text/javascript">
    $('#status').select2();
    $(".pickadate").pickadate({
        // selectYears: 20
    });

    function loadTable() {
        setTimeout(function(){
            initTable();
            hideLoader();
        }, 500);
    }

    function filterTable() {
        showLoader();
        $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');
        loadTable();
    }

    function clearTable() {
        showLoader();
        clear_from_to_date();
        role_select_box(role_url, '', '', 'multiple');
        status_select_box();
        $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');
        loadTable();
    }
 
   function initTable() {
        $('#dataTableId').bootstrapTable({
          //  url: base_url+'<?php //echo customers_constants::get_customers_url; ?>',
            url: base_url+'<?php echo "get-crud";?>',
            method: 'GET',                
            queryParams: function (params) {
                q = {
                    limit           : params.limit,
                    offset          : params.offset,
                    search          : params.search,
                    sort            : (params.sort ? params.sort : ''),
                    order           : (params.order ? params.order : ''),
                    custom_search   : {
                                        from_date               : $('#fromdateVal').val(),
                                        to_date                 : $('#todateVal').val(),
                                        status                  : $('#status').val(),
                                      }
                }
                return q;
            },
            cache: false,
            // height: 580,
            striped: true,
            toolbar: true,
            search: true,
            showRefresh: true,
            showToggle: true,
            showColumns: true,
            detailView: false,
            exportOptions: { ignoreColumn: ['action'], fileName: 'Customers' },
            showExport: true,
            exportDataType: 'all',
            minimumCountColumns: 2,
            showPaginationSwitch: true,
            pagination: true,
            sidePagination: 'server',
            idField: 'id',
            pageSize: 10,
            pageList: [10, 25, 50, 100, 200],
            showFooter: false,
            clickToSelect: false,
            columns: [
                [
                    {
                        field: 'sr_no',
                        title: 'Sr No.',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'name',
                        title: 'Name',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    }
                    
                ]
            ]
        });
    }

    initTable();
</script>