<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    class campaign_tracker_website_master_campaign_idModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $this->dataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_type field
            //
            $column = new NumberViewColumn('campaign_type', 'campaign_type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_tier field
            //
            $column = new NumberViewColumn('campaign_tier', 'campaign_tier', 'Campaign Tier', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for channel_types field
            //
            $column = new TextViewColumn('channel_types', 'channel_types', 'Channel Types', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_status field
            //
            $column = new NumberViewColumn('campaign_status', 'campaign_status', 'Campaign Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for event_type field
            //
            $column = new NumberViewColumn('event_type', 'event_type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for b_region field
            //
            $column = new TextViewColumn('b_region', 'b_region', 'B Region', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for b_country field
            //
            $column = new TextViewColumn('b_country', 'b_country', 'B Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for est_opportunity_value_in_euros field
            //
            $column = new NumberViewColumn('est_opportunity_value_in_euros', 'est_opportunity_value_in_euros', 'Est Opportunity Value In Euros', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_cost field
            //
            $column = new NumberViewColumn('campaign_cost', 'campaign_cost', 'Campaign Cost', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expected_roi_enquiries field
            //
            $column = new NumberViewColumn('expected_roi_enquiries', 'expected_roi_enquiries', 'Expected Roi Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expected_roi_ots field
            //
            $column = new NumberViewColumn('expected_roi_ots', 'expected_roi_ots', 'Expected Roi Ots', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for post_enquiries field
            //
            $column = new NumberViewColumn('post_enquiries', 'post_enquiries', 'Post Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for new_opportunities field
            //
            $column = new NumberViewColumn('new_opportunities', 'new_opportunities', 'New Opportunities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for owner_person field
            //
            $column = new TextViewColumn('owner_person', 'owner_person', 'Owner Person', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for file_upload field
            //
            $column = new TextViewColumn('file_upload', 'file_upload', 'File Upload', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for asset_upload field
            //
            $column = new TextViewColumn('asset_upload', 'asset_upload', 'Asset Upload', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for updated_by field
            //
            $column = new TextViewColumn('updated_by', 'updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for updated_date field
            //
            $column = new DateTimeViewColumn('updated_date', 'updated_date', 'Updated Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
        }
    
        static public function getHandlerName() {
            return get_class() . '_modal_view';
        }
    
        public function GetModalGridViewHandler() {
            return self::getHandlerName();
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    }
    
    class campaign_tracker_website_program_generator_name_idModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $this->dataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $this->dataset->AddLookupField('pregion', 'lookup_region', new StringField('Region_Value'), new StringField('Region', false, false, false, false, 'pregion_Region', 'pregion_Region_lookup_region'), 'pregion_Region_lookup_region');
            $this->dataset->AddLookupField('industry', 'lookup_industries', new IntegerField('Industry_ID'), new StringField('Industry_Name', false, false, false, false, 'industry_Industry_Name', 'industry_Industry_Name_lookup_industries'), 'industry_Industry_Name_lookup_industries');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for SFDC_child_campaign field
            //
            $column = new TextViewColumn('SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Child Campaign', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for event_type field
            //
            $column = new NumberViewColumn('event_type', 'event_type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('pregion', 'pregion_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_type field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_publish_date_end field
            //
            $column = new DateTimeViewColumn('campaign_publish_date_end', 'campaign_publish_date_end', 'Campaign Publish Date End', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_time_start field
            //
            $column = new DateTimeViewColumn('campaign_time_start', 'campaign_time_start', 'Campaign Time Start', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_time_end field
            //
            $column = new DateTimeViewColumn('campaign_time_end', 'campaign_time_end', 'Campaign Time End', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for emails_tracker field
            //
            $column = new NumberViewColumn('emails_tracker', 'emails_tracker', 'Emails Tracker', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for webinar_tracker field
            //
            $column = new NumberViewColumn('webinar_tracker', 'webinar_tracker', 'Webinar Tracker', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
        }
    
        static public function getHandlerName() {
            return get_class() . '_modal_view';
        }
    
        public function GetModalGridViewHandler() {
            return self::getHandlerName();
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    }
    
    class campaign_tracker_website_countryModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $this->dataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('Country_Name', 'Country_Name', 'Country Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Dialing_Code field
            //
            $column = new TextViewColumn('Dialing_Code', 'Dialing_Code', 'Dialing Code', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for 2_ISO field
            //
            $column = new TextViewColumn('2_ISO', '2_ISO', '2 ISO', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Preferred_Langauge field
            //
            $column = new TextViewColumn('Preferred_Langauge', 'Preferred_Langauge', 'Preferred Langauge', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for c_Region field
            //
            $column = new TextViewColumn('c_Region', 'c_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('Sub_Region', 'Sub_Region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Territories field
            //
            $column = new TextViewColumn('Territories', 'Territories', 'Territories', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
        }
    
        static public function getHandlerName() {
            return get_class() . '_modal_view';
        }
    
        public function GetModalGridViewHandler() {
            return self::getHandlerName();
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class campaign_tracker_websitePage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Campaign Tracker: Website');
            $this->SetMenuLabel('Website Listing');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_website`');
            $this->dataset->addFields(
                array(
                    new IntegerField('campaign_tracker_ID', true, true, true),
                    new IntegerField('master_campaign_id', true),
                    new IntegerField('program_generator_name_id', true),
                    new StringField('trackerid'),
                    new StringField('industry'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country', true),
                    new StringField('product', true),
                    new StringField('langauge', true),
                    new StringField('event_type'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('start_date'),
                    new DateField('end_date'),
                    new TimeField('start_time'),
                    new TimeField('end_time'),
                    new StringField('deployed_by'),
                    new DateTimeField('deployed_date', true),
                    new IntegerField('deploy_website'),
                    new StringField('deploy_website_status'),
                    new DateTimeField('deploy_website_date'),
                    new StringField('listing_title'),
                    new BlobField('listing_content'),
                    new StringField('listing_cta'),
                    new StringField('listing_banner'),
                    new StringField('listing_SEO_title'),
                    new StringField('listing_SEO_keywords'),
                    new StringField('social_meta'),
                    new IntegerField('listing_show_form'),
                    new StringField('listing_url'),
                    new StringField('publish_live'),
                    new DateField('publish_live_date'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $this->dataset->AddLookupField('master_campaign_id', 'brief', new IntegerField('master_campaign_id'), new StringField('campaign_name', false, false, false, false, 'master_campaign_id_campaign_name', 'master_campaign_id_campaign_name_brief'), 'master_campaign_id_campaign_name_brief');
            $this->dataset->AddLookupField('program_generator_name_id', 'campaign_program_name_generator', new IntegerField('program_generator_name_id'), new StringField('campaign_program_name', false, false, false, false, 'program_generator_name_id_campaign_program_name', 'program_generator_name_id_campaign_program_name_campaign_program_name_generator'), 'program_generator_name_id_campaign_program_name_campaign_program_name_generator');
            $this->dataset->AddLookupField('langauge', 'lookup_language', new IntegerField('language_id'), new StringField('langauge', false, false, false, false, 'langauge_langauge', 'langauge_langauge_lookup_language'), 'langauge_langauge_lookup_language');
            $this->dataset->AddLookupField('country', 'country_list', new IntegerField('Country_ID'), new StringField('Country_Name', false, false, false, false, 'country_Country_Name', 'country_Country_Name_country_list'), 'country_Country_Name_country_list');
            $this->dataset->AddLookupField('region', 'lookup_region', new StringField('Region_Value'), new StringField('Region', false, false, false, false, 'region_Region', 'region_Region_lookup_region'), 'region_Region_lookup_region');
            $this->dataset->AddLookupField('sub_region', 'lookup_sub_regions', new IntegerField('Sub_Region_ID'), new StringField('Sub_Region', false, false, false, false, 'sub_region_Sub_Region', 'sub_region_Sub_Region_lookup_sub_regions'), 'sub_region_Sub_Region_lookup_sub_regions');
            $this->dataset->AddLookupField('territory', 'lookup_territory', new IntegerField('Territory_ID'), new StringField('Territory', false, false, false, false, 'territory_Territory', 'territory_Territory_lookup_territory'), 'territory_Territory_lookup_territory');
            $this->dataset->AddLookupField('event_type', 'lookup_event_type', new IntegerField('Event_Type_ID'), new StringField('Event_Type', false, false, false, false, 'event_type_Event_Type', 'event_type_Event_Type_lookup_event_type'), 'event_type_Event_Type_lookup_event_type');
            $this->dataset->AddLookupField('deploy_website_status', 'lookup_status_types', new IntegerField('Status_Type_ID'), new StringField('Status_Type', false, false, false, false, 'deploy_website_status_Status_Type', 'deploy_website_status_Status_Type_lookup_status_types'), 'deploy_website_status_Status_Type_lookup_status_types');
            $this->dataset->AddLookupField('listing_cta', 'lookup_button_cta', new StringField('description'), new StringField('description', false, false, false, false, 'listing_cta_description', 'listing_cta_description_lookup_button_cta'), 'listing_cta_description_lookup_button_cta');
            if (!$this->GetSecurityInfo()->HasAdminGrant()) {
                $this->dataset->setRlsPolicy(new RlsPolicy('created_by', GetApplication()->GetCurrentUserId()));
            }
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new CustomPageNavigator('partition', $this, $this->dataset, 'Filter by Status', $result);
            $partitionNavigator->OnGetPartitionCondition->AddListener('partition' . '_GetPartitionConditionHandler', $this);
            $partitionNavigator->OnGetPartitions->AddListener('partition' . '_GetPartitionsHandler', $this);
            $partitionNavigator->SetAllowViewAllRecords(true);
            $partitionNavigator->SetNavigationStyle(NS_LIST);
            $result->AddPageNavigator($partitionNavigator);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(10);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'campaign_tracker_ID', 'campaign_tracker_ID', 'Campaign Tracker ID'),
                new FilterColumn($this->dataset, 'master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Request'),
                new FilterColumn($this->dataset, 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder'),
                new FilterColumn($this->dataset, 'product', 'product', 'Product'),
                new FilterColumn($this->dataset, 'industry', 'industry', 'Industry'),
                new FilterColumn($this->dataset, 'langauge', 'langauge_langauge', 'Langauge'),
                new FilterColumn($this->dataset, 'country', 'country_Country_Name', 'Country'),
                new FilterColumn($this->dataset, 'region', 'region_Region', 'Region'),
                new FilterColumn($this->dataset, 'sub_region', 'sub_region_Sub_Region', 'Sub Region'),
                new FilterColumn($this->dataset, 'territory', 'territory_Territory', 'Territory'),
                new FilterColumn($this->dataset, 'm_ID', 'm_ID', 'Form ID'),
                new FilterColumn($this->dataset, 'event_type', 'event_type_Event_Type', 'Event Type'),
                new FilterColumn($this->dataset, 'campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date'),
                new FilterColumn($this->dataset, 'start_date', 'start_date', 'Start Date'),
                new FilterColumn($this->dataset, 'end_date', 'end_date', 'End Date'),
                new FilterColumn($this->dataset, 'start_time', 'start_time', 'Start Time'),
                new FilterColumn($this->dataset, 'end_time', 'end_time', 'End Time'),
                new FilterColumn($this->dataset, 'deployed_by', 'deployed_by', 'Deployed By'),
                new FilterColumn($this->dataset, 'deployed_date', 'deployed_date', 'Deployed Date'),
                new FilterColumn($this->dataset, 'deploy_website', 'deploy_website', 'Deploy Website'),
                new FilterColumn($this->dataset, 'deploy_website_status', 'deploy_website_status_Status_Type', 'Deploy Website Status'),
                new FilterColumn($this->dataset, 'deploy_website_date', 'deploy_website_date', 'Deploy Website Date'),
                new FilterColumn($this->dataset, 'publish_live_date', 'publish_live_date', 'Publish Live Date'),
                new FilterColumn($this->dataset, 'publish_live', 'publish_live', 'Publish Live'),
                new FilterColumn($this->dataset, 'listing_title', 'listing_title', 'Listing Title'),
                new FilterColumn($this->dataset, 'listing_content', 'listing_content', 'Listing Content'),
                new FilterColumn($this->dataset, 'listing_cta', 'listing_cta_description', 'Button CTA'),
                new FilterColumn($this->dataset, 'listing_banner', 'listing_banner', 'Listing Banner'),
                new FilterColumn($this->dataset, 'listing_SEO_title', 'listing_SEO_title', 'Listing SEO Title'),
                new FilterColumn($this->dataset, 'listing_SEO_keywords', 'listing_SEO_keywords', 'Listing SEO Keywords'),
                new FilterColumn($this->dataset, 'social_meta', 'social_meta', 'Social Meta'),
                new FilterColumn($this->dataset, 'listing_show_form', 'listing_show_form', 'Listing Show Form'),
                new FilterColumn($this->dataset, 'listing_url', 'listing_url', 'Listing Url'),
                new FilterColumn($this->dataset, 'modified_by', 'modified_by', 'Modified By'),
                new FilterColumn($this->dataset, 'modified_date', 'modified_date', 'Modified Date'),
                new FilterColumn($this->dataset, 'trackerid', 'trackerid', 'Trackerid'),
                new FilterColumn($this->dataset, 'created_by', 'created_by', 'Created By'),
                new FilterColumn($this->dataset, 'created_date', 'created_date', 'Created Date')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['campaign_tracker_ID'])
                ->addColumn($columns['master_campaign_id'])
                ->addColumn($columns['program_generator_name_id'])
                ->addColumn($columns['product'])
                ->addColumn($columns['industry'])
                ->addColumn($columns['langauge'])
                ->addColumn($columns['country'])
                ->addColumn($columns['region'])
                ->addColumn($columns['sub_region'])
                ->addColumn($columns['territory'])
                ->addColumn($columns['m_ID'])
                ->addColumn($columns['event_type'])
                ->addColumn($columns['campaign_publish_date'])
                ->addColumn($columns['start_date'])
                ->addColumn($columns['end_date'])
                ->addColumn($columns['start_time'])
                ->addColumn($columns['end_time'])
                ->addColumn($columns['deployed_by'])
                ->addColumn($columns['deployed_date'])
                ->addColumn($columns['deploy_website'])
                ->addColumn($columns['deploy_website_status'])
                ->addColumn($columns['deploy_website_date'])
                ->addColumn($columns['publish_live_date'])
                ->addColumn($columns['publish_live'])
                ->addColumn($columns['listing_title'])
                ->addColumn($columns['listing_content'])
                ->addColumn($columns['listing_cta'])
                ->addColumn($columns['listing_banner'])
                ->addColumn($columns['listing_SEO_title'])
                ->addColumn($columns['listing_SEO_keywords'])
                ->addColumn($columns['social_meta'])
                ->addColumn($columns['listing_show_form'])
                ->addColumn($columns['listing_url'])
                ->addColumn($columns['modified_by'])
                ->addColumn($columns['modified_date'])
                ->addColumn($columns['created_by'])
                ->addColumn($columns['created_date']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('langauge')
                ->setOptionsFor('event_type')
                ->setOptionsFor('start_date')
                ->setOptionsFor('end_date')
                ->setOptionsFor('deploy_website_status')
                ->setOptionsFor('deploy_website_date')
                ->setOptionsFor('publish_live_date')
                ->setOptionsFor('created_date');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('campaign_tracker_id_edit');
            
            $filterBuilder->addColumn(
                $columns['campaign_tracker_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('master_campaign_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_tracker_website_master_campaign_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('master_campaign_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_tracker_website_master_campaign_id_search');
            
            $filterBuilder->addColumn(
                $columns['master_campaign_id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_tracker_website_program_generator_name_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('program_generator_name_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_tracker_website_program_generator_name_id_search');
            
            $filterBuilder->addColumn(
                $columns['program_generator_name_id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new RemoteMultiValueSelect('product_edit', $this->CreateLinkBuilder());
            $main_editor->SetHandlerName('filter_builder_product_Product_ID_Product_search');
            $main_editor->setMaxSelectionSize(0);
            
            $text_editor = new TextEdit('product');
            
            $filterBuilder->addColumn(
                $columns['product'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $main_editor->SetHandlerName('filter_builder_industry_Industry_ID_Industry_Name_search');
            $main_editor->setMaxSelectionSize(0);
            
            $text_editor = new TextEdit('industry');
            
            $filterBuilder->addColumn(
                $columns['industry'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('langauge_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_tracker_website_langauge_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('langauge', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_tracker_website_langauge_search');
            
            $text_editor = new TextEdit('langauge');
            
            $filterBuilder->addColumn(
                $columns['langauge'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('country_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_tracker_website_country_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('country', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_tracker_website_country_search');
            
            $text_editor = new TextEdit('country');
            
            $filterBuilder->addColumn(
                $columns['country'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_tracker_website_region_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('region', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_tracker_website_region_search');
            
            $text_editor = new TextEdit('region');
            
            $filterBuilder->addColumn(
                $columns['region'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('sub_region_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_tracker_website_sub_region_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('sub_region', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_tracker_website_sub_region_search');
            
            $text_editor = new TextEdit('sub_region');
            
            $filterBuilder->addColumn(
                $columns['sub_region'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('territory_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_tracker_website_territory_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('territory', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_tracker_website_territory_search');
            
            $text_editor = new TextEdit('territory');
            
            $filterBuilder->addColumn(
                $columns['territory'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('m_id_edit');
            $main_editor->SetMaxLength(11);
            
            $filterBuilder->addColumn(
                $columns['m_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('event_type_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_tracker_website_event_type_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('event_type', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_tracker_website_event_type_search');
            
            $filterBuilder->addColumn(
                $columns['event_type'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['campaign_publish_date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('start_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['start_date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('end_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['end_date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TimeEdit('start_time_edit', 'H:i:s');
            
            $filterBuilder->addColumn(
                $columns['start_time'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TimeEdit('end_time_edit', 'H:i:s');
            
            $filterBuilder->addColumn(
                $columns['end_time'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('deployed_by_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['deployed_by'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('deployed_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['deployed_date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ComboBox('deploy_website');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice(true, $this->GetLocalizerCaptions()->GetMessageString('True'));
            $main_editor->addChoice(false, $this->GetLocalizerCaptions()->GetMessageString('False'));
            
            $filterBuilder->addColumn(
                $columns['deploy_website'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('deploy_website_status_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_tracker_website_deploy_website_status_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('deploy_website_status', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_tracker_website_deploy_website_status_search');
            
            $text_editor = new TextEdit('deploy_website_status');
            
            $filterBuilder->addColumn(
                $columns['deploy_website_status'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('deploy_website_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['deploy_website_date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('publish_live_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['publish_live_date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('publish_live_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['publish_live'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('listing_title_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['listing_title'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('listing_content');
            
            $filterBuilder->addColumn(
                $columns['listing_content'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('listing_cta_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_tracker_website_listing_cta_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('listing_cta', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_tracker_website_listing_cta_search');
            
            $text_editor = new TextEdit('listing_cta');
            
            $filterBuilder->addColumn(
                $columns['listing_cta'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('listing_banner_edit');
            
            $filterBuilder->addColumn(
                $columns['listing_banner'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('listing_seo_title_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['listing_SEO_title'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('listing_seo_keywords_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['listing_SEO_keywords'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('social_meta');
            
            $filterBuilder->addColumn(
                $columns['social_meta'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ComboBox('listing_show_form');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice(true, $this->GetLocalizerCaptions()->GetMessageString('True'));
            $main_editor->addChoice(false, $this->GetLocalizerCaptions()->GetMessageString('False'));
            
            $filterBuilder->addColumn(
                $columns['listing_show_form'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('listing_url_edit');
            
            $filterBuilder->addColumn(
                $columns['listing_url'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('modified_by_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['modified_by'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['modified_date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('created_by_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['created_by'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['created_date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new AjaxOperation(OPERATION_VIEW,
                    $this->GetLocalizerCaptions()->GetMessageString('View'),
                    $this->GetLocalizerCaptions()->GetMessageString('View'), $this->dataset,
                    $this->GetModalGridViewHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new AjaxOperation(OPERATION_COPY,
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'),
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'), $this->dataset,
                    $this->GetModalGridCopyHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for listing_title field
            //
            $column = new TextViewColumn('listing_title', 'listing_title', 'Listing Title', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for langauge field
            //
            $column = new TextViewColumn('langauge', 'langauge_langauge', 'Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'Form ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for deploy_website field
            //
            $column = new CheckboxViewColumn('deploy_website', 'deploy_website', 'Deploy Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('Yes', 'No');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('deploy_website_status', 'deploy_website_status_Status_Type', 'Deploy Website Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for deploy_website_date field
            //
            $column = new DateTimeViewColumn('deploy_website_date', 'deploy_website_date', 'Deploy Website Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for publish_live_date field
            //
            $column = new DateTimeViewColumn('publish_live_date', 'publish_live_date', 'Publish Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for publish_live field
            //
            $column = new TextViewColumn('publish_live', 'publish_live', 'Publish Live', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for campaign_tracker_ID field
            //
            $column = new NumberViewColumn('campaign_tracker_ID', 'campaign_tracker_ID', 'Campaign Tracker ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Request', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_tracker_website_master_campaign_idModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_tracker_website_program_generator_name_idModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for langauge field
            //
            $column = new TextViewColumn('langauge', 'langauge_langauge', 'Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('country', 'country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_tracker_website_countryModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region_Sub_Region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'Form ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for start_time field
            //
            $column = new DateTimeViewColumn('start_time', 'start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for end_time field
            //
            $column = new DateTimeViewColumn('end_time', 'end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for deployed_by field
            //
            $column = new TextViewColumn('deployed_by', 'deployed_by', 'Deployed By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for deployed_date field
            //
            $column = new DateTimeViewColumn('deployed_date', 'deployed_date', 'Deployed Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for deploy_website field
            //
            $column = new CheckboxViewColumn('deploy_website', 'deploy_website', 'Deploy Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('Yes', 'No');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('deploy_website_status', 'deploy_website_status_Status_Type', 'Deploy Website Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for deploy_website_date field
            //
            $column = new DateTimeViewColumn('deploy_website_date', 'deploy_website_date', 'Deploy Website Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for publish_live_date field
            //
            $column = new DateTimeViewColumn('publish_live_date', 'publish_live_date', 'Publish Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for publish_live field
            //
            $column = new TextViewColumn('publish_live', 'publish_live', 'Publish Live', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_title field
            //
            $column = new TextViewColumn('listing_title', 'listing_title', 'Listing Title', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_content field
            //
            $column = new TextViewColumn('listing_content', 'listing_content', 'Listing Content', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('listing_cta', 'listing_cta_description', 'Button CTA', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_banner field
            //
            $column = new TextViewColumn('listing_banner', 'listing_banner', 'Listing Banner', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_SEO_title field
            //
            $column = new TextViewColumn('listing_SEO_title', 'listing_SEO_title', 'Listing SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_SEO_keywords field
            //
            $column = new TextViewColumn('listing_SEO_keywords', 'listing_SEO_keywords', 'Listing SEO Keywords', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for social_meta field
            //
            $column = new TextViewColumn('social_meta', 'social_meta', 'Social Meta', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_show_form field
            //
            $column = new CheckboxViewColumn('listing_show_form', 'listing_show_form', 'Listing Show Form', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('Show', 'Hide');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for listing_url field
            //
            $column = new TextViewColumn('listing_url', 'listing_url', 'Listing Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for master_campaign_id field
            //
            $editor = new DynamicCombobox('master_campaign_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Request', 'master_campaign_id', 'master_campaign_id_campaign_name', 'edit_campaign_tracker_website_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Builder', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'edit_campaign_tracker_website_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new RemoteMultiValueSelect('product_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('edit_product_Product_ID_Product_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Product', 'product', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('edit_industry_Industry_ID_Industry_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Industry', 'industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for langauge field
            //
            $editor = new DynamicCombobox('langauge_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Langauge', 'langauge', 'langauge_langauge', 'edit_campaign_tracker_website_langauge_search', $editor, $this->dataset, $lookupDataset, 'language_id', 'langauge', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for country field
            //
            $editor = new DynamicCombobox('country_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Country', 'country', 'country_Country_Name', 'edit_campaign_tracker_website_country_search', $editor, $this->dataset, $lookupDataset, 'Country_ID', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Region', 'region', 'region_Region', 'edit_campaign_tracker_website_region_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for sub_region field
            //
            $editor = new DynamicCombobox('sub_region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sub Region', 'sub_region', 'sub_region_Sub_Region', 'edit_campaign_tracker_website_sub_region_search', $editor, $this->dataset, $lookupDataset, 'Sub_Region_ID', 'Sub_Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for territory field
            //
            $editor = new DynamicCombobox('territory_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_territory`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Territory_ID', true, true, true),
                    new StringField('Territory'),
                    new StringField('Territory_Value'),
                    new StringField('Sub_Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Territory', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Territory', 'territory', 'territory_Territory', 'edit_campaign_tracker_website_territory_search', $editor, $this->dataset, $lookupDataset, 'Territory_ID', 'Territory', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('Form ID', 'm_ID', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for event_type field
            //
            $editor = new DynamicCombobox('event_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'event_website_listing=\'1\''));
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'edit_campaign_tracker_website_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Campaign Publish Date', 'campaign_publish_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for start_date field
            //
            $editor = new DateTimeEdit('start_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Start Date', 'start_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for end_date field
            //
            $editor = new DateTimeEdit('end_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('End Date', 'end_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for start_time field
            //
            $editor = new TimeEdit('start_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Start Time', 'start_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for end_time field
            //
            $editor = new TimeEdit('end_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('End Time', 'end_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for deployed_by field
            //
            $editor = new TextEdit('deployed_by_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Deployed By', 'deployed_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for deployed_date field
            //
            $editor = new DateTimeEdit('deployed_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Deployed Date', 'deployed_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for deploy_website field
            //
            $editor = new CheckBox('deploy_website_edit');
            $editColumn = new CustomEditColumn('Deploy Website', 'deploy_website', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for deploy_website_status field
            //
            $editor = new DynamicCombobox('deploy_website_status_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters = \'website_listing\''));
            $editColumn = new DynamicLookupEditColumn('Deploy Website Status', 'deploy_website_status', 'deploy_website_status_Status_Type', 'edit_campaign_tracker_website_deploy_website_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for deploy_website_date field
            //
            $editor = new DateTimeEdit('deploy_website_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Deploy Website Date', 'deploy_website_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for publish_live_date field
            //
            $editor = new DateTimeEdit('publish_live_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Publish Live Date', 'publish_live_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for publish_live field
            //
            $editor = new TextEdit('publish_live_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Publish Live', 'publish_live', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_title field
            //
            $editor = new TextEdit('listing_title_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing Title', 'listing_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_content field
            //
            $editor = new HtmlWysiwygEditor('listing_content_edit');
            $editColumn = new CustomEditColumn('Listing Content', 'listing_content', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_cta field
            //
            $editor = new DynamicCombobox('listing_cta_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'cta_Filter=\'web_list\''));
            $editColumn = new DynamicLookupEditColumn('Button CTA', 'listing_cta', 'listing_cta_description', 'edit_campaign_tracker_website_listing_cta_search', $editor, $this->dataset, $lookupDataset, 'description', 'description', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_banner field
            //
            $editor = new TextEdit('listing_banner_edit');
            $editColumn = new CustomEditColumn('Listing Banner', 'listing_banner', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_SEO_title field
            //
            $editor = new TextEdit('listing_seo_title_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Title', 'listing_SEO_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_SEO_keywords field
            //
            $editor = new TextEdit('listing_seo_keywords_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Keywords', 'listing_SEO_keywords', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for social_meta field
            //
            $editor = new TextAreaEdit('social_meta_edit', 50, 3);
            $editColumn = new CustomEditColumn('Social Meta', 'social_meta', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_show_form field
            //
            $editor = new CheckBox('listing_show_form_edit');
            $editColumn = new CustomEditColumn('Listing Show Form', 'listing_show_form', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for listing_url field
            //
            $editor = new TextEdit('listing_url_edit');
            $editColumn = new CustomEditColumn('Listing Url', 'listing_url', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for modified_by field
            //
            $editor = new TextEdit('modified_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Modified By', 'modified_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for modified_date field
            //
            $editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Modified Date', 'modified_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Created By', 'created_by', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for created_date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'created_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for master_campaign_id field
            //
            $editor = new DynamicCombobox('master_campaign_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Request', 'master_campaign_id', 'master_campaign_id_campaign_name', 'multi_edit_campaign_tracker_website_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Builder', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'multi_edit_campaign_tracker_website_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new RemoteMultiValueSelect('product_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('multi_edit_product_Product_ID_Product_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Product', 'product', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('multi_edit_industry_Industry_ID_Industry_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Industry', 'industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for langauge field
            //
            $editor = new DynamicCombobox('langauge_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Langauge', 'langauge', 'langauge_langauge', 'multi_edit_campaign_tracker_website_langauge_search', $editor, $this->dataset, $lookupDataset, 'language_id', 'langauge', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for country field
            //
            $editor = new DynamicCombobox('country_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Country', 'country', 'country_Country_Name', 'multi_edit_campaign_tracker_website_country_search', $editor, $this->dataset, $lookupDataset, 'Country_ID', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Region', 'region', 'region_Region', 'multi_edit_campaign_tracker_website_region_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for sub_region field
            //
            $editor = new DynamicCombobox('sub_region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sub Region', 'sub_region', 'sub_region_Sub_Region', 'multi_edit_campaign_tracker_website_sub_region_search', $editor, $this->dataset, $lookupDataset, 'Sub_Region_ID', 'Sub_Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for territory field
            //
            $editor = new DynamicCombobox('territory_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_territory`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Territory_ID', true, true, true),
                    new StringField('Territory'),
                    new StringField('Territory_Value'),
                    new StringField('Sub_Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Territory', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Territory', 'territory', 'territory_Territory', 'multi_edit_campaign_tracker_website_territory_search', $editor, $this->dataset, $lookupDataset, 'Territory_ID', 'Territory', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('Form ID', 'm_ID', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for event_type field
            //
            $editor = new DynamicCombobox('event_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'event_website_listing=\'1\''));
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'multi_edit_campaign_tracker_website_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Campaign Publish Date', 'campaign_publish_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for start_date field
            //
            $editor = new DateTimeEdit('start_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Start Date', 'start_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for end_date field
            //
            $editor = new DateTimeEdit('end_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('End Date', 'end_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for start_time field
            //
            $editor = new TimeEdit('start_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Start Time', 'start_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for end_time field
            //
            $editor = new TimeEdit('end_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('End Time', 'end_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for deployed_by field
            //
            $editor = new TextEdit('deployed_by_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Deployed By', 'deployed_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for deployed_date field
            //
            $editor = new DateTimeEdit('deployed_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Deployed Date', 'deployed_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for deploy_website field
            //
            $editor = new CheckBox('deploy_website_edit');
            $editColumn = new CustomEditColumn('Deploy Website', 'deploy_website', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for deploy_website_status field
            //
            $editor = new DynamicCombobox('deploy_website_status_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters = \'website_listing\''));
            $editColumn = new DynamicLookupEditColumn('Deploy Website Status', 'deploy_website_status', 'deploy_website_status_Status_Type', 'multi_edit_campaign_tracker_website_deploy_website_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for deploy_website_date field
            //
            $editor = new DateTimeEdit('deploy_website_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Deploy Website Date', 'deploy_website_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for publish_live_date field
            //
            $editor = new DateTimeEdit('publish_live_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Publish Live Date', 'publish_live_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for publish_live field
            //
            $editor = new TextEdit('publish_live_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Publish Live', 'publish_live', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_title field
            //
            $editor = new TextEdit('listing_title_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing Title', 'listing_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_content field
            //
            $editor = new HtmlWysiwygEditor('listing_content_edit');
            $editColumn = new CustomEditColumn('Listing Content', 'listing_content', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_cta field
            //
            $editor = new DynamicCombobox('listing_cta_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'cta_Filter=\'web_list\''));
            $editColumn = new DynamicLookupEditColumn('Button CTA', 'listing_cta', 'listing_cta_description', 'multi_edit_campaign_tracker_website_listing_cta_search', $editor, $this->dataset, $lookupDataset, 'description', 'description', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_banner field
            //
            $editor = new TextEdit('listing_banner_edit');
            $editColumn = new CustomEditColumn('Listing Banner', 'listing_banner', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_SEO_title field
            //
            $editor = new TextEdit('listing_seo_title_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Title', 'listing_SEO_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_SEO_keywords field
            //
            $editor = new TextEdit('listing_seo_keywords_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Keywords', 'listing_SEO_keywords', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for social_meta field
            //
            $editor = new TextAreaEdit('social_meta_edit', 50, 3);
            $editColumn = new CustomEditColumn('Social Meta', 'social_meta', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_show_form field
            //
            $editor = new CheckBox('listing_show_form_edit');
            $editColumn = new CustomEditColumn('Listing Show Form', 'listing_show_form', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for listing_url field
            //
            $editor = new TextEdit('listing_url_edit');
            $editColumn = new CustomEditColumn('Listing Url', 'listing_url', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for modified_by field
            //
            $editor = new TextEdit('modified_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Modified By', 'modified_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for modified_date field
            //
            $editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Modified Date', 'modified_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Created By', 'created_by', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for created_date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'created_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for master_campaign_id field
            //
            $editor = new DynamicCombobox('master_campaign_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Request', 'master_campaign_id', 'master_campaign_id_campaign_name', 'insert_campaign_tracker_website_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for program_generator_name_id field
            //
            $editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campaign Builder', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'insert_campaign_tracker_website_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new RemoteMultiValueSelect('product_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('insert_product_Product_ID_Product_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Product', 'product', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new RemoteMultiValueSelect('industry_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('insert_industry_Industry_ID_Industry_Name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Industry', 'industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for langauge field
            //
            $editor = new DynamicCombobox('langauge_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Langauge', 'langauge', 'langauge_langauge', 'insert_campaign_tracker_website_langauge_search', $editor, $this->dataset, $lookupDataset, 'language_id', 'langauge', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for country field
            //
            $editor = new DynamicCombobox('country_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Country', 'country', 'country_Country_Name', 'insert_campaign_tracker_website_country_search', $editor, $this->dataset, $lookupDataset, 'Country_ID', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new DynamicCombobox('region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Region', 'region', 'region_Region', 'insert_campaign_tracker_website_region_search', $editor, $this->dataset, $lookupDataset, 'Region_Value', 'Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for sub_region field
            //
            $editor = new DynamicCombobox('sub_region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sub Region', 'sub_region', 'sub_region_Sub_Region', 'insert_campaign_tracker_website_sub_region_search', $editor, $this->dataset, $lookupDataset, 'Sub_Region_ID', 'Sub_Region', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for territory field
            //
            $editor = new DynamicCombobox('territory_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_territory`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Territory_ID', true, true, true),
                    new StringField('Territory'),
                    new StringField('Territory_Value'),
                    new StringField('Sub_Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Territory', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Territory', 'territory', 'territory_Territory', 'insert_campaign_tracker_website_territory_search', $editor, $this->dataset, $lookupDataset, 'Territory_ID', 'Territory', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('Form ID', 'm_ID', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for event_type field
            //
            $editor = new DynamicCombobox('event_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'event_website_listing=\'1\''));
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'insert_campaign_tracker_website_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_publish_date field
            //
            $editor = new DateTimeEdit('campaign_publish_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Campaign Publish Date', 'campaign_publish_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for start_date field
            //
            $editor = new DateTimeEdit('start_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Start Date', 'start_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for end_date field
            //
            $editor = new DateTimeEdit('end_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('End Date', 'end_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for start_time field
            //
            $editor = new TimeEdit('start_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Start Time', 'start_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for end_time field
            //
            $editor = new TimeEdit('end_time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('End Time', 'end_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for deployed_by field
            //
            $editor = new TextEdit('deployed_by_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Deployed By', 'deployed_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for deployed_date field
            //
            $editor = new DateTimeEdit('deployed_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Deployed Date', 'deployed_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for deploy_website field
            //
            $editor = new CheckBox('deploy_website_edit');
            $editColumn = new CustomEditColumn('Deploy Website', 'deploy_website', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for deploy_website_status field
            //
            $editor = new DynamicCombobox('deploy_website_status_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters = \'website_listing\''));
            $editColumn = new DynamicLookupEditColumn('Deploy Website Status', 'deploy_website_status', 'deploy_website_status_Status_Type', 'insert_campaign_tracker_website_deploy_website_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for deploy_website_date field
            //
            $editor = new DateTimeEdit('deploy_website_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Deploy Website Date', 'deploy_website_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for publish_live_date field
            //
            $editor = new DateTimeEdit('publish_live_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Publish Live Date', 'publish_live_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for publish_live field
            //
            $editor = new TextEdit('publish_live_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Publish Live', 'publish_live', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_title field
            //
            $editor = new TextEdit('listing_title_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing Title', 'listing_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_content field
            //
            $editor = new HtmlWysiwygEditor('listing_content_edit');
            $editColumn = new CustomEditColumn('Listing Content', 'listing_content', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_cta field
            //
            $editor = new DynamicCombobox('listing_cta_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'cta_Filter=\'web_list\''));
            $editColumn = new DynamicLookupEditColumn('Button CTA', 'listing_cta', 'listing_cta_description', 'insert_campaign_tracker_website_listing_cta_search', $editor, $this->dataset, $lookupDataset, 'description', 'description', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_banner field
            //
            $editor = new TextEdit('listing_banner_edit');
            $editColumn = new CustomEditColumn('Listing Banner', 'listing_banner', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_SEO_title field
            //
            $editor = new TextEdit('listing_seo_title_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Title', 'listing_SEO_title', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_SEO_keywords field
            //
            $editor = new TextEdit('listing_seo_keywords_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Listing SEO Keywords', 'listing_SEO_keywords', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for social_meta field
            //
            $editor = new TextAreaEdit('social_meta_edit', 50, 3);
            $editColumn = new CustomEditColumn('Social Meta', 'social_meta', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_show_form field
            //
            $editor = new CheckBox('listing_show_form_edit');
            $editColumn = new CustomEditColumn('Listing Show Form', 'listing_show_form', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for listing_url field
            //
            $editor = new TextEdit('listing_url_edit');
            $editColumn = new CustomEditColumn('Listing Url', 'listing_url', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for modified_by field
            //
            $editor = new TextEdit('modified_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Modified By', 'modified_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_USER_NAME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for modified_date field
            //
            $editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Modified Date', 'modified_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATETIME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Created By', 'created_by', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for created_date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'created_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for campaign_tracker_ID field
            //
            $column = new NumberViewColumn('campaign_tracker_ID', 'campaign_tracker_ID', 'Campaign Tracker ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Request', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for langauge field
            //
            $column = new TextViewColumn('langauge', 'langauge_langauge', 'Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('country', 'country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region_Sub_Region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'Form ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for start_time field
            //
            $column = new DateTimeViewColumn('start_time', 'start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for end_time field
            //
            $column = new DateTimeViewColumn('end_time', 'end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for deployed_by field
            //
            $column = new TextViewColumn('deployed_by', 'deployed_by', 'Deployed By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for deployed_date field
            //
            $column = new DateTimeViewColumn('deployed_date', 'deployed_date', 'Deployed Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for deploy_website field
            //
            $column = new CheckboxViewColumn('deploy_website', 'deploy_website', 'Deploy Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('Yes', 'No');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('deploy_website_status', 'deploy_website_status_Status_Type', 'Deploy Website Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for deploy_website_date field
            //
            $column = new DateTimeViewColumn('deploy_website_date', 'deploy_website_date', 'Deploy Website Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for publish_live_date field
            //
            $column = new DateTimeViewColumn('publish_live_date', 'publish_live_date', 'Publish Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for publish_live field
            //
            $column = new TextViewColumn('publish_live', 'publish_live', 'Publish Live', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_title field
            //
            $column = new TextViewColumn('listing_title', 'listing_title', 'Listing Title', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_content field
            //
            $column = new TextViewColumn('listing_content', 'listing_content', 'Listing Content', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('listing_cta', 'listing_cta_description', 'Button CTA', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_banner field
            //
            $column = new TextViewColumn('listing_banner', 'listing_banner', 'Listing Banner', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_SEO_title field
            //
            $column = new TextViewColumn('listing_SEO_title', 'listing_SEO_title', 'Listing SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_SEO_keywords field
            //
            $column = new TextViewColumn('listing_SEO_keywords', 'listing_SEO_keywords', 'Listing SEO Keywords', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for social_meta field
            //
            $column = new TextViewColumn('social_meta', 'social_meta', 'Social Meta', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_show_form field
            //
            $column = new CheckboxViewColumn('listing_show_form', 'listing_show_form', 'Listing Show Form', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('Show', 'Hide');
            $grid->AddPrintColumn($column);
            
            //
            // View column for listing_url field
            //
            $column = new TextViewColumn('listing_url', 'listing_url', 'Listing Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for campaign_tracker_ID field
            //
            $column = new NumberViewColumn('campaign_tracker_ID', 'campaign_tracker_ID', 'Campaign Tracker ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Request', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for langauge field
            //
            $column = new TextViewColumn('langauge', 'langauge_langauge', 'Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('country', 'country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region_Sub_Region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'Form ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for start_time field
            //
            $column = new DateTimeViewColumn('start_time', 'start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for end_time field
            //
            $column = new DateTimeViewColumn('end_time', 'end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for deployed_by field
            //
            $column = new TextViewColumn('deployed_by', 'deployed_by', 'Deployed By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for deployed_date field
            //
            $column = new DateTimeViewColumn('deployed_date', 'deployed_date', 'Deployed Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for deploy_website field
            //
            $column = new CheckboxViewColumn('deploy_website', 'deploy_website', 'Deploy Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('Yes', 'No');
            $grid->AddExportColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('deploy_website_status', 'deploy_website_status_Status_Type', 'Deploy Website Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for deploy_website_date field
            //
            $column = new DateTimeViewColumn('deploy_website_date', 'deploy_website_date', 'Deploy Website Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for publish_live_date field
            //
            $column = new DateTimeViewColumn('publish_live_date', 'publish_live_date', 'Publish Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for publish_live field
            //
            $column = new TextViewColumn('publish_live', 'publish_live', 'Publish Live', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_title field
            //
            $column = new TextViewColumn('listing_title', 'listing_title', 'Listing Title', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_content field
            //
            $column = new TextViewColumn('listing_content', 'listing_content', 'Listing Content', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('listing_cta', 'listing_cta_description', 'Button CTA', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_banner field
            //
            $column = new TextViewColumn('listing_banner', 'listing_banner', 'Listing Banner', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_SEO_title field
            //
            $column = new TextViewColumn('listing_SEO_title', 'listing_SEO_title', 'Listing SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_SEO_keywords field
            //
            $column = new TextViewColumn('listing_SEO_keywords', 'listing_SEO_keywords', 'Listing SEO Keywords', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for social_meta field
            //
            $column = new TextViewColumn('social_meta', 'social_meta', 'Social Meta', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_show_form field
            //
            $column = new CheckboxViewColumn('listing_show_form', 'listing_show_form', 'Listing Show Form', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('Show', 'Hide');
            $grid->AddExportColumn($column);
            
            //
            // View column for listing_url field
            //
            $column = new TextViewColumn('listing_url', 'listing_url', 'Listing Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Campaign Request', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Campaign Builder', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for langauge field
            //
            $column = new TextViewColumn('langauge', 'langauge_langauge', 'Langauge', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('country', 'country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('region', 'region_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Sub_Region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region_Sub_Region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Territory field
            //
            $column = new TextViewColumn('territory', 'territory_Territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'Form ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for start_time field
            //
            $column = new DateTimeViewColumn('start_time', 'start_time', 'Start Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for end_time field
            //
            $column = new DateTimeViewColumn('end_time', 'end_time', 'End Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for deployed_by field
            //
            $column = new TextViewColumn('deployed_by', 'deployed_by', 'Deployed By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for deployed_date field
            //
            $column = new DateTimeViewColumn('deployed_date', 'deployed_date', 'Deployed Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for deploy_website field
            //
            $column = new CheckboxViewColumn('deploy_website', 'deploy_website', 'Deploy Website', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('Yes', 'No');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('deploy_website_status', 'deploy_website_status_Status_Type', 'Deploy Website Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for deploy_website_date field
            //
            $column = new DateTimeViewColumn('deploy_website_date', 'deploy_website_date', 'Deploy Website Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for publish_live_date field
            //
            $column = new DateTimeViewColumn('publish_live_date', 'publish_live_date', 'Publish Live Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for publish_live field
            //
            $column = new TextViewColumn('publish_live', 'publish_live', 'Publish Live', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_title field
            //
            $column = new TextViewColumn('listing_title', 'listing_title', 'Listing Title', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_content field
            //
            $column = new TextViewColumn('listing_content', 'listing_content', 'Listing Content', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('listing_cta', 'listing_cta_description', 'Button CTA', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_banner field
            //
            $column = new TextViewColumn('listing_banner', 'listing_banner', 'Listing Banner', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_SEO_title field
            //
            $column = new TextViewColumn('listing_SEO_title', 'listing_SEO_title', 'Listing SEO Title', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_SEO_keywords field
            //
            $column = new TextViewColumn('listing_SEO_keywords', 'listing_SEO_keywords', 'Listing SEO Keywords', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for social_meta field
            //
            $column = new TextViewColumn('social_meta', 'social_meta', 'Social Meta', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_show_form field
            //
            $column = new CheckboxViewColumn('listing_show_form', 'listing_show_form', 'Listing Show Form', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('Show', 'Hide');
            $grid->AddCompareColumn($column);
            
            //
            // View column for listing_url field
            //
            $column = new TextViewColumn('listing_url', 'listing_url', 'Listing Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for modified_by field
            //
            $column = new TextViewColumn('modified_by', 'modified_by', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for modified_date field
            //
            $column = new DateTimeViewColumn('modified_date', 'modified_date', 'Modified Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalSingleRecordView() { return true; }
        
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
        
        public function GetEnableModalGridCopy() { return true; }
        
        private $partitions = array(1 => array('\'19\''), 2 => array('\'21\''));
        
        function partition_GetPartitionsHandler(&$partitions)
        {
            $partitions[1] = 'Publish Live';
            $partitions[2] = 'Expired';
        }
        
        function partition_GetPartitionConditionHandler($partitionName, &$condition)
        {
            $condition = '';
            if (isset($partitionName) && isset($this->partitions[$partitionName]))
                foreach ($this->partitions[$partitionName] as $value)
                    AddStr($condition, sprintf('(Publish_Live = %s)', $this->PrepareTextForSQL($value)), ' OR ');
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(true);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setDescription('<div class="mark-media mark-position-relative">
                          <div class="mark-bd-placeholder-img mr-3"><img src="apps/icons/website-list-color.png" width="80" height="79"></div>
                          <div class="mark-media-body">
                            <h5 class="mt-0 h5">What will you find here</h5>
                            <p class="mark-p">Through the campaign builder an automated entry has been entered for the Event Type selected.</p>
                            <a href="http://mktportal.mscsoftware.com/apps/website_listing.php" class="stretched-link">View Live Lists</a>
                          </div>
                        </div>');
            $this->setShowFormErrorsOnTop(true);
            $this->setShowFormErrorsAtBottom(false);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
            $grid->SetEditClientEditorValueChangedScript('if (sender.getFieldName() == \'deploy_website_status\')
            {
              if (sender.getValue() == \'19\')
              {
                editors[\'deploy_website\'].setValue(\'1\');
                $(\'#deploy_website_date_edit\').next().show();      
              }
              else
              {
                editors[\'deploy_website\'].setValue(\'1\');
                $(\'#deploy_website_date_edit\').next().show();       
              }
            }');
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_tracker_website_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_tracker_website_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $valuesDataset->setOrderByField('Product', 'ASC');
            $valuesDataset->addDistinct('Product_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'insert_product_Product_ID_Product_search', 'Product_ID', 'Product', null, 70);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $valuesDataset->setOrderByField('Industry_Name', 'ASC');
            $valuesDataset->addDistinct('Industry_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'insert_industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_tracker_website_langauge_search', 'language_id', 'langauge', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_tracker_website_country_search', 'Country_ID', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_tracker_website_region_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_tracker_website_sub_region_search', 'Sub_Region_ID', 'Sub_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_territory`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Territory_ID', true, true, true),
                    new StringField('Territory'),
                    new StringField('Territory_Value'),
                    new StringField('Sub_Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Territory', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_tracker_website_territory_search', 'Territory_ID', 'Territory', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'event_website_listing=\'1\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_tracker_website_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters = \'website_listing\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_tracker_website_deploy_website_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'cta_Filter=\'web_list\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_tracker_website_listing_cta_search', 'description', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_tracker_website_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_tracker_website_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $valuesDataset->setOrderByField('Product', 'ASC');
            $valuesDataset->addDistinct('Product_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'filter_builder_product_Product_ID_Product_search', 'Product_ID', 'Product', null, 70);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $valuesDataset->setOrderByField('Industry_Name', 'ASC');
            $valuesDataset->addDistinct('Industry_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'filter_builder_industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_tracker_website_langauge_search', 'language_id', 'langauge', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_tracker_website_country_search', 'Country_ID', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_tracker_website_region_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_tracker_website_sub_region_search', 'Sub_Region_ID', 'Sub_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_territory`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Territory_ID', true, true, true),
                    new StringField('Territory'),
                    new StringField('Territory_Value'),
                    new StringField('Sub_Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Territory', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_tracker_website_territory_search', 'Territory_ID', 'Territory', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'event_website_listing=\'1\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_tracker_website_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters = \'website_listing\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_tracker_website_deploy_website_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'cta_Filter=\'web_list\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_tracker_website_listing_cta_search', 'description', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_tracker_website_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_tracker_website_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $valuesDataset->setOrderByField('Product', 'ASC');
            $valuesDataset->addDistinct('Product_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'edit_product_Product_ID_Product_search', 'Product_ID', 'Product', null, 70);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $valuesDataset->setOrderByField('Industry_Name', 'ASC');
            $valuesDataset->addDistinct('Industry_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'edit_industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_tracker_website_langauge_search', 'language_id', 'langauge', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_tracker_website_country_search', 'Country_ID', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_tracker_website_region_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_tracker_website_sub_region_search', 'Sub_Region_ID', 'Sub_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_territory`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Territory_ID', true, true, true),
                    new StringField('Territory'),
                    new StringField('Territory_Value'),
                    new StringField('Sub_Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Territory', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_tracker_website_territory_search', 'Territory_ID', 'Territory', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'event_website_listing=\'1\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_tracker_website_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters = \'website_listing\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_tracker_website_deploy_website_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'cta_Filter=\'web_list\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_tracker_website_listing_cta_search', 'description', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`brief`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('master_campaign_id', true, true, true),
                    new StringField('campaign_name', true),
                    new StringField('objective', true),
                    new StringField('short_description', true),
                    new IntegerField('campaign_type'),
                    new IntegerField('campaign_tier'),
                    new StringField('channel_types'),
                    new IntegerField('campaign_status'),
                    new IntegerField('event_type'),
                    new StringField('b_region'),
                    new StringField('b_country'),
                    new StringField('industry'),
                    new IntegerField('est_opportunity_value_in_euros', true),
                    new IntegerField('campaign_cost'),
                    new IntegerField('expected_roi_enquiries'),
                    new IntegerField('expected_roi_ots'),
                    new IntegerField('post_enquiries'),
                    new IntegerField('new_opportunities'),
                    new StringField('owner_person'),
                    new DateField('start_date', true),
                    new DateField('end_date'),
                    new StringField('file_upload'),
                    new StringField('asset_upload'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('updated_by'),
                    new DateTimeField('updated_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_tracker_website_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_program_name_generator`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('program_generator_name_id', true, true, true),
                    new IntegerField('master_campaign_id'),
                    new IntegerField('campaign_event_id'),
                    new StringField('trackerid'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('campaign_program_name'),
                    new IntegerField('event_type'),
                    new StringField('short_description'),
                    new StringField('pregion'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new StringField('industry'),
                    new StringField('job_function'),
                    new StringField('campaign_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new DateField('campaign_publish_date_end'),
                    new TimeField('campaign_time_start'),
                    new TimeField('campaign_time_end'),
                    new IntegerField('emails_tracker'),
                    new IntegerField('webinar_tracker'),
                    new StringField('created_by'),
                    new DateTimeField('created_date'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('import_total'),
                    new IntegerField('create_import_list'),
                    new IntegerField('expired')
                )
            );
            $lookupDataset->setOrderByField('campaign_program_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_tracker_website_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_products`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Product_ID', true, true, true),
                    new StringField('Product'),
                    new StringField('Product_Value')
                )
            );
            $valuesDataset->setOrderByField('Product', 'ASC');
            $valuesDataset->addDistinct('Product_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'multi_edit_product_Product_ID_Product_search', 'Product_ID', 'Product', null, 70);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $valuesDataset->setOrderByField('Industry_Name', 'ASC');
            $valuesDataset->addDistinct('Industry_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'multi_edit_industry_Industry_ID_Industry_Name_search', 'Industry_ID', 'Industry_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_language`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('language_id', true, true, true),
                    new StringField('langauge', true)
                )
            );
            $lookupDataset->setOrderByField('langauge', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_tracker_website_langauge_search', 'language_id', 'langauge', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country_list`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Country_ID', true, true, true),
                    new StringField('Country_Name'),
                    new StringField('Dialing_Code'),
                    new StringField('2_ISO'),
                    new StringField('Preferred_Langauge'),
                    new StringField('c_Region'),
                    new StringField('Sub_Region'),
                    new StringField('Territories'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_tracker_website_country_search', 'Country_ID', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_region`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Region_ID', true, true, true),
                    new StringField('Region', true),
                    new StringField('Region_Value', true)
                )
            );
            $lookupDataset->setOrderByField('Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_tracker_website_region_search', 'Region_Value', 'Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_sub_regions`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Sub_Region_ID', true, true, true),
                    new StringField('Sub_Region'),
                    new StringField('Sub_Region_Value'),
                    new StringField('Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Sub_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_tracker_website_sub_region_search', 'Sub_Region_ID', 'Sub_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_territory`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Territory_ID', true, true, true),
                    new StringField('Territory'),
                    new StringField('Territory_Value'),
                    new StringField('Sub_Region_Value_ID', true)
                )
            );
            $lookupDataset->setOrderByField('Territory', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_tracker_website_territory_search', 'Territory_ID', 'Territory', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type'),
                    new IntegerField('Event_website_listing')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'event_website_listing=\'1\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_tracker_website_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_status_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Status_Type_ID', true, true, true),
                    new StringField('Status_Type'),
                    new StringField('Status_Type_Value'),
                    new StringField('Status_Filters')
                )
            );
            $lookupDataset->setOrderByField('Status_Type', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters = \'website_listing\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_tracker_website_deploy_website_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_button_cta`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('button_cta_id', true, true, true),
                    new StringField('description'),
                    new StringField('cta_Filter')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'cta_Filter=\'web_list\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_tracker_website_listing_cta_search', 'description', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            new campaign_tracker_website_master_campaign_idModalViewPage($this, GetCurrentUserPermissionsForPage('campaign_tracker_website.master_campaign_id'));
            new campaign_tracker_website_program_generator_name_idModalViewPage($this, GetCurrentUserPermissionsForPage('campaign_tracker_website.program_generator_name_id'));
            new campaign_tracker_website_countryModalViewPage($this, GetCurrentUserPermissionsForPage('campaign_tracker_website.country'));
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
            $today = date("Y-m-d");
            
            if ($rowData['end_date'] <= $today) {
                 $cellBgColor['end_date'] = '#FF0000';
                 $cellBoldAttr['end_date'] = true;
            }
            else {
                 $cellFontColor['end_date'] = '#228B22';
                 $cellBoldAttr['end_date'] = true;
            }
            if ($rowData['start_date'] <= $today) {
                 $cellBgColor['start_date'] = '#FF0000';
                 $cellBoldAttr['start_date'] = true;
            }
            else {
                 $cellFontColor['start_date'] = '#228B22';
                 $cellBoldAttr['start_date'] = true;
            }
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            if ($success) {
            
              // Check if record data was modified
            
              $dataMofified  = 
            
            	$oldRowData['langauge'] !== $rowData['langauge'] ||
            	$oldRowData['event_type'] !== $rowData['event_type'] ||
            	$oldRowData['deploy_website_status'] !== $rowData['deploy_website_status'];
            	
            	
              if ($dataMofified) {
            
                    $sprogram_generator_name_id = $rowData['program_generator_name_id'];
                    $trackerid = $rowData['trackerid'];
                    $event_type = $rowData['event_type'];                
            
                  
               
               if ($event_type !== '8' || $event_type !== '18') {   
            
               $sql = 
            
                  "CALL campaignTacticWebsiteListingMID($sprogram_generator_name_id, $trackerid);";
                  $this->GetConnection()->ExecSQL($sql);
               }
               
                  $message = '<p>Record processed successfully</p>';
                  
              }                                    
            }
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
            $layout->setMode(FormLayoutMode::VERTICAL);
            
            $briefGroup = $layout->addGroup('Request Overview', 12);
            $briefGroup->addRow()->addCol($columns['master_campaign_id'], 12);
            $briefGroup->addRow()->addCol($columns['program_generator_name_id'], 12);
            $briefGroup->addRow()->addCol($columns['deployed_by'], 12);
            $briefGroup->addRow()->addCol($columns['deployed_date'], 12);
            
            
            $storageGroup = $layout->addGroup('Website Content', 12);
            $storageGroup->addRow()
                ->addCol($columns['event_type'], 8)
                ->addCol($columns['langauge'], 4);
            $storageGroup->addRow()
                ->addCol($columns['listing_title'], 12);
            $storageGroup->addRow()
                ->addCol($columns['listing_content'], 12);
            $storageGroup->addRow()
                ->addCol($columns['listing_url'], 12);
            $storageGroup->addRow()
                ->addCol($columns['listing_banner'], 12);
            $storageGroup->addRow()
                ->addCol($columns['listing_SEO_title'], 12);
            $storageGroup->addRow()
                ->addCol($columns['listing_SEO_keywords'], 12);
            $storageGroup->addRow()
                ->addCol($columns['social_meta'], 12);
            $storageGroup->addRow()
                ->addCol($columns['listing_cta'], 4)
                ->addCol($columns['listing_show_form'], 4)
                ->addCol($columns['m_ID'], 4);
            
            $storageGroup = $layout->addGroup('Campaign Filters', 12);
            $storageGroup->addRow()
                ->addCol($columns['country'], 12);
            $storageGroup->addRow()
                ->addCol($columns['region'], 6)
                ->addCol($columns['sub_region'], 6);
            $storageGroup->addRow()
                ->addCol($columns['territory'], 12);
            $storageGroup->addRow()
                ->addCol($columns['product'], 6)
                ->addCol($columns['industry'], 6);    
            
            $storageGroup = $layout->addGroup('Deployment', 12);
            $storageGroup->addRow()
                ->addCol($columns['deploy_website_status'], 4)
                ->addCol($columns['deploy_website'], 2)
                ->addCol($columns['deploy_website_date'], 6);
            $storageGroup->addRow()
                ->addCol($columns['campaign_publish_date'], 12);
            $storageGroup->addRow()
                ->addCol($columns['start_date'], 6)
                ->addCol($columns['end_date'], 6);
            $storageGroup->addRow()
                ->addCol($columns['start_time'], 6)
                ->addCol($columns['end_time'], 6);
            $storageGroup->addRow()
                ->addCol($columns['publish_live'], 6)
                ->addCol($columns['publish_live_date'], 6);
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new campaign_tracker_websitePage("campaign_tracker_website", "campaign_tracker_website.php", GetCurrentUserPermissionsForPage("campaign_tracker_website"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("campaign_tracker_website"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
