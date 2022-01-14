<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0">Filters</h5>
            </div>
            <div class="card-body">
                <form class="" action="">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">From Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input type='text' class="form-control pickadate bg-white" id="fromdateVal" name="fromdateVal" placeholder="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">To Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input type='text' class="form-control pickadate bg-white" id="todateVal" name="todateVal" placeholder="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="status_wrap">
                                    <select class="form-control select2" name="status" id="status" multiple style="width: 100%;">
                                        <option value="">-- Select Status --</option>
                                        <option value="1">Active</option>
                                        <option value="0">In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <button type="button" class="btn btn-main-primary mr-1" onclick="filterTable();">Filter</button>
                            <button type="button" class="btn btn-secondary custom-btn-secondary" onclick="clearTable();">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <div id="dataTableWrap">
                    <div class="table-responsive">
                        <table id="dataTableId"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>