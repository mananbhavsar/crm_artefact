<md-content class="md-padding bg-white">
    <div class="form-group clearfix">
        <label class=" col-md-2"><?php echo lang('cron_job_link') ?></label>
        <div class=" col-md-10"><?php echo base_url('CronJob/run') ?></div>
    </div>
    <div class="form-group clearfix">
        <label class=" col-md-2"><?php echo lang('recommended_execution_interval') ?></label>
        <div class=" col-md-10"><?php echo  lang('every_one_hour'); ?></div>
    </div>
    <label class=" col-md-2"><?php echo lang('cpanel_cron_job_command') ?></label>
    <div class=" col-md-10">
        <div>
            <p>
                <pre class="editorField">wget <?php echo base_url('CronJob/run') ?></pre>
            </p>
            <p>
                <pre class="editorField">wget <?php echo base_url('CronJob/emails') ?></pre>
            </p>
        </div>
        <hr>
        <div>
            <p>
                <pre class="editorField"><strong class="text-danger"><?php echo lang('or') ?></strong> wget -q -O- <?php echo base_url('CronJob/run') ?></pre>
            </p>
            <p>
                <pre class="editorField"><strong class="text-danger"><?php echo lang('or') ?></strong> wget -q -O- <?php echo base_url('CronJob/emails') ?></pre>
            </p>
        </div>
    </div>
</md-content>