<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('table'); ?>

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
            url: base_url+'<?php echo cruds_constants::get_crud_url; ?>',
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
            exportOptions: { ignoreColumn: ['action'], fileName: 'Crud' },
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
                    },
                    // {
                    //     field: 'member_id',
                    //     title: 'Member Id',
                    //     align: 'left',
                    //     valign: 'middle',
                    //     sortable: true,
                    //     editable: false,
                    //     footerFormatter: false,
                    // },
                    {
                        field: 'email',
                        title: 'Email',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'mobile',
                        title: 'Mobile',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'pincode',
                        title: 'Pincode',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'address',
                        title: 'Address',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'status',
                        title: 'Status',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'created_on',
                        title: 'Created On',
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'action',
                        title: 'Action',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    }
                ]
            ]
        });
    }

    initTable();
</script>