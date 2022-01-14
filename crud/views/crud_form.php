
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <form id="crudId" class="" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf">
                    <input type="hidden" id="id" name="id" value="<?php echo (isset($post_data['id']) ? $post_data['id'] : ''); ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Name <span class="asterisk">*</span></label>
                                <input type='text' class="form-control" id="name" name="name" placeholder="" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" data-error=".nameerror" maxlength="191" required/>
                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phone <span class="asterisk">*</span></label>
                                <input type='text' class="form-control validate_integer" id="phone" name="phone" placeholder="" value="<?php echo set_value('phone', (isset($post_data['phone']) ? $post_data['phone'] : '')); ?>" data-error=".mobileerror" maxlength="10" required/>
                                <div class="mobileerror error_msg"><?php echo form_error('mobile', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email <span class="asterisk">*</span></label>
                                <input type='text' class="form-control to_lowercase" id="email" name="email" placeholder="" value="<?php echo set_value('email', (isset($post_data['email']) ? $post_data['email'] : '')); ?>" data-error=".emailerror" maxlength="50" required/>
                                <div class="emailerror error_msg"><?php echo form_error('email', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="address">Address</label>
                                <textarea class="form-control" id="address" name="address"><?php echo (isset($post_data['address']) ? $post_data['address'] : ''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Pincode</label>
                                <input type='text' class="form-control validate_integer" id="pincode" name="pincode" placeholder="" value="<?php echo set_value('pincode', (isset($post_data['pincode']) ? $post_data['pincode'] : '')); ?>" data-error=".pincodeerror" maxlength="6"/>
                                <div class="pincodeerror error_msg"><?php echo form_error('pincode', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Status <span class="asterisk">*</span></label>
                                <select class="select2" name="status" id="status" style="width: 100%;" data-error=".statuserror" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="1" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'selected="selected"'; } ?>>Active</option>
                                    <option value="0" <?php if(isset($post_data['status']) && $post_data['status'] == 0){ echo 'selected="selected"'; } ?>>In-Active</option>
                                </select>
                                <div class="statuserror error_msg"><?php echo form_error('status', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                     <br>
                    <div class="row row-sm">
                        <div class="col-12 mg-t-10 text-right">
                            <button class="btn btn-primary" type="submit">Save</button>
                            <a href="<?php echo base_url('list') ?>" class="btn btn-secondary custom-btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#status').select2();

    $("#formId").validate({
        rules: {
            name: {
                required: true,
            },
            mobile: {
                required: true,
                mobile_regex: '#mobile',
            },
            email: {
                required: true,
                email_regex: '#email',
            },
            pincode: {
                digits: true,
                maxlength: 6,
            },
            status: {
                required: true,
            },
            address: {
                required: true,
            },
        },
        messages: {
            name: {
                required: 'Please enter name',
            },
            mobile:{
                required: 'Please enter mobile number',
                mobile_regex: 'Please enter valid mobile number',
            },
            email:{
                required: 'Please enter email',
                email_regex: 'Please enter valid email',
            },
            pincode:{
                digits: 'Please enter valid pincode',
            },
            status:{
                required: 'Please select status',
            },
            address: {
                required: 'Please address status',
            }
        },
        ignore: "input[type=hidden]",
        errorClass: "danger",
        successClass: "success",
        highlight: function(e, t) {
            $(e).removeClass(t)
        },
        unhighlight: function(e, t) {
            $(e).removeClass(t)
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form, event){
            event.preventDefault();
            var csrf_token          = $('#<?php echo $this->security->get_csrf_token_name(); ?>').val();
            var user_id             = $('#id').val();
            var mobile              = $('#mobile').val();
            var email               = $('#email').val();
            var name                = $('#name').val();
            var status              = $('#status').val();
            var pincode              = $('#pincode').val();
            var address              = $('#address').val();

            function unique_mobile() {
                var check_result = false;

                $.ajax({
                    type: "POST",
                    url: base_url+'<?php echo customers_constants::customer_check_unique_mobile_url; ?>',
                    async: false,
                    data: {mobile : mobile, id : user_id, '<?php echo $this->security->get_csrf_token_name(); ?>' : csrf_token},
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response){
                        hideLoader();
                        check_result = response;
                    }
                });
                return check_result;
            }

            function unique_email() {
                var check_result = false;

                $.ajax({
                    type: "POST",
                    url: base_url+'<?php echo customers_constants::customer_check_unique_email_url; ?>',
                    async: false,
                    data: {email : email, id : user_id, '<?php echo $this->security->get_csrf_token_name(); ?>' : csrf_token},
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response){
                        hideLoader();
                        check_result = response;
                    }
                });
                return check_result;
            }

            $('.mobileerror').html('');
            $('.emailerror').html('');

            var check_mobile = unique_mobile();
            if(check_mobile)
            {
                var check_email = unique_email();
                if(check_email)
                {
                    showLoader();
                    form.submit();
                }
                else
                {
                    hideLoader();
                    $('.emailerror').append('<div id="email-error" class="error" style="">Email already exist</div>');
                }
            }
            else
            {
                hideLoader();
                $('.mobileerror').append('<div id="mobile-error" class="error" style="">Mobile number already exist</div>');
            }
        }
    });
</script>