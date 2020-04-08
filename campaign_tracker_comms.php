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

    
    
    class campaign_tracker_comms_master_campaign_id_b_countryModalViewPage extends ViewBasedPage
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
                    new StringField('Territories')
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
            $column = new TextViewColumn('c_Region', 'c_Region', 'C Region', $this->dataset);
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
    
    class campaign_tracker_comms_master_campaign_idModalViewPage extends ViewBasedPage
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
                    new DateTimeField('updated_date')
                )
            );
            $this->dataset->AddLookupField('b_country', 'country_list', new IntegerField('Country_ID'), new StringField('Country_Name', false, false, false, false, 'b_country_Country_Name', 'b_country_Country_Name_country_list'), 'b_country_Country_Name_country_list');
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
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_master_campaign_idModalViewPage_campaign_name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_master_campaign_idModalViewPage_objective_handler_view');
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
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_master_campaign_idModalViewPage_b_region_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('b_country', 'b_country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_tracker_comms_master_campaign_id_b_countryModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_master_campaign_idModalViewPage_industry_handler_');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for owner_person field
            //
            $column = new TextViewColumn('owner_person', 'owner_person', 'Owner Person', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_master_campaign_idModalViewPage_owner_person_handler_');
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
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_master_campaign_idModalViewPage_file_upload_handler_');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for asset_upload field
            //
            $column = new TextViewColumn('asset_upload', 'asset_upload', 'Asset Upload', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_master_campaign_idModalViewPage_asset_upload_handler_');
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
            
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_master_campaign_idModalViewPage_campaign_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_master_campaign_idModalViewPage_objective_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for b_region field
            //
            $column = new TextViewColumn('b_region', 'b_region', 'B Region', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_master_campaign_idModalViewPage_b_region_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_master_campaign_idModalViewPage_industry_handler_', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for owner_person field
            //
            $column = new TextViewColumn('owner_person', 'owner_person', 'Owner Person', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_master_campaign_idModalViewPage_owner_person_handler_', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for file_upload field
            //
            $column = new TextViewColumn('file_upload', 'file_upload', 'File Upload', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_master_campaign_idModalViewPage_file_upload_handler_', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for asset_upload field
            //
            $column = new TextViewColumn('asset_upload', 'asset_upload', 'Asset Upload', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_master_campaign_idModalViewPage_asset_upload_handler_', $column);
            GetApplication()->RegisterHTTPHandler($handler);
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
    
    
    
    class campaign_tracker_commsPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Campaign Tracker: Comms');
            $this->SetMenuLabel('Campaign Tracker Comms');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_tracker_comms`');
            $this->dataset->addFields(
                array(
                    new IntegerField('campaign_tracker_ID', true, true, true),
                    new IntegerField('master_campaign_id', true),
                    new StringField('campaign_program_name'),
                    new StringField('industry'),
                    new StringField('region'),
                    new StringField('sub_region'),
                    new StringField('territory'),
                    new StringField('country'),
                    new IntegerField('job_function'),
                    new StringField('channel_type'),
                    new StringField('product'),
                    new StringField('m_ID'),
                    new DateField('campaign_publish_date'),
                    new StringField('campaign_description'),
                    new IntegerField('campaign_type'),
                    new IntegerField('tracker_status'),
                    new IntegerField('event_type'),
                    new StringField('SFDC_child_campaign'),
                    new StringField('icon')
                )
            );
            $this->dataset->AddLookupField('master_campaign_id', 'brief', new IntegerField('master_campaign_id'), new StringField('campaign_name', false, false, false, false, 'master_campaign_id_campaign_name', 'master_campaign_id_campaign_name_brief'), 'master_campaign_id_campaign_name_brief');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
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
                new FilterColumn($this->dataset, 'master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id'),
                new FilterColumn($this->dataset, 'campaign_description', 'campaign_description', 'Campaign Description'),
                new FilterColumn($this->dataset, 'campaign_program_name', 'campaign_program_name', 'Campaign Program Name'),
                new FilterColumn($this->dataset, 'industry', 'industry', 'Industry'),
                new FilterColumn($this->dataset, 'region', 'region', 'Region'),
                new FilterColumn($this->dataset, 'sub_region', 'sub_region', 'Sub Region'),
                new FilterColumn($this->dataset, 'territory', 'territory', 'Territory'),
                new FilterColumn($this->dataset, 'country', 'country', 'Country'),
                new FilterColumn($this->dataset, 'job_function', 'job_function', 'Job Function'),
                new FilterColumn($this->dataset, 'channel_type', 'channel_type', 'Channel Type'),
                new FilterColumn($this->dataset, 'product', 'product', 'Product'),
                new FilterColumn($this->dataset, 'm_ID', 'm_ID', 'M ID'),
                new FilterColumn($this->dataset, 'campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date'),
                new FilterColumn($this->dataset, 'campaign_type', 'campaign_type', 'Campaign Type'),
                new FilterColumn($this->dataset, 'tracker_status', 'tracker_status', 'Tracker Status'),
                new FilterColumn($this->dataset, 'event_type', 'event_type', 'Event Type'),
                new FilterColumn($this->dataset, 'SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Child Campaign'),
                new FilterColumn($this->dataset, 'icon', 'icon', 'Icon')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['campaign_tracker_ID'])
                ->addColumn($columns['master_campaign_id'])
                ->addColumn($columns['campaign_description'])
                ->addColumn($columns['campaign_program_name'])
                ->addColumn($columns['industry'])
                ->addColumn($columns['region'])
                ->addColumn($columns['sub_region'])
                ->addColumn($columns['territory'])
                ->addColumn($columns['country'])
                ->addColumn($columns['job_function'])
                ->addColumn($columns['channel_type'])
                ->addColumn($columns['product'])
                ->addColumn($columns['m_ID'])
                ->addColumn($columns['campaign_publish_date'])
                ->addColumn($columns['campaign_type'])
                ->addColumn($columns['tracker_status'])
                ->addColumn($columns['event_type'])
                ->addColumn($columns['SFDC_child_campaign'])
                ->addColumn($columns['icon']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('master_campaign_id')
                ->setOptionsFor('campaign_publish_date');
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
            $main_editor->SetHandlerName('filter_builder_campaign_tracker_comms_master_campaign_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('master_campaign_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_tracker_comms_master_campaign_id_search');
            
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
            
            $main_editor = new TextEdit('campaign_description_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['campaign_description'],
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
            
            $main_editor = new TextEdit('campaign_program_name');
            
            $filterBuilder->addColumn(
                $columns['campaign_program_name'],
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
            
            $main_editor = new TextEdit('industry');
            
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
            
            $main_editor = new TextEdit('region_edit');
            $main_editor->SetMaxLength(50);
            
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
            
            $main_editor = new TextEdit('sub_region_edit');
            $main_editor->SetMaxLength(30);
            
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
            
            $main_editor = new TextEdit('territory');
            
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
            
            $main_editor = new TextEdit('country_edit');
            $main_editor->SetMaxLength(50);
            
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
            
            $main_editor = new TextEdit('job_function_edit');
            
            $filterBuilder->addColumn(
                $columns['job_function'],
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
            
            $main_editor = new TextEdit('channel_type_edit');
            $main_editor->SetMaxLength(3);
            
            $filterBuilder->addColumn(
                $columns['channel_type'],
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
            
            $main_editor = new TextEdit('product_edit');
            $main_editor->SetMaxLength(10);
            
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
            
            $main_editor = new TextEdit('campaign_type_edit');
            
            $filterBuilder->addColumn(
                $columns['campaign_type'],
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
            
            $main_editor = new TextEdit('tracker_status_edit');
            
            $filterBuilder->addColumn(
                $columns['tracker_status'],
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
            
            $main_editor = new TextEdit('event_type_edit');
            
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('sfdc_child_campaign_edit');
            $main_editor->SetMaxLength(18);
            
            $filterBuilder->addColumn(
                $columns['SFDC_child_campaign'],
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
            
            $main_editor = new TextEdit('icon');
            
            $filterBuilder->addColumn(
                $columns['icon'],
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
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setLookupRecordModalViewHandlerName(campaign_tracker_comms_master_campaign_idModalViewPage::getHandlerName());
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_campaign_description_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for campaign_publish_date field
            //
            $column = new DateTimeViewColumn('campaign_publish_date', 'campaign_publish_date', 'Campaign Publish Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for campaign_type field
            //
            $column = new NumberViewColumn('campaign_type', 'campaign_type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tracker_status field
            //
            $column = new NumberViewColumn('tracker_status', 'tracker_status', 'Tracker Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for event_type field
            //
            $column = new NumberViewColumn('event_type', 'event_type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_tracker_comms_master_campaign_idModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_campaign_description_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_campaign_program_name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_industry_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for region field
            //
            $column = new TextViewColumn('region', 'region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for sub_region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for territory field
            //
            $column = new TextViewColumn('territory', 'territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_territory_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for job_function field
            //
            $column = new NumberViewColumn('job_function', 'job_function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for channel_type field
            //
            $column = new TextViewColumn('channel_type', 'channel_type', 'Channel Type', $this->dataset);
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
            // View column for campaign_type field
            //
            $column = new NumberViewColumn('campaign_type', 'campaign_type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tracker_status field
            //
            $column = new NumberViewColumn('tracker_status', 'tracker_status', 'Tracker Status', $this->dataset);
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
            // View column for SFDC_child_campaign field
            //
            $column = new TextViewColumn('SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Child Campaign', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for icon field
            //
            $column = new TextViewColumn('icon', 'icon', 'Icon', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_icon_handler_view');
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Master Campaign Id', 'master_campaign_id', 'master_campaign_id_campaign_name', 'edit_campaign_tracker_comms_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_description field
            //
            $editor = new TextEdit('campaign_description_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Campaign Description', 'campaign_description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_program_name field
            //
            $editor = new TextAreaEdit('campaign_program_name_edit', 50, 8);
            $editColumn = new CustomEditColumn('Campaign Program Name', 'campaign_program_name', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new TextAreaEdit('industry_edit', 50, 8);
            $editColumn = new CustomEditColumn('Industry', 'industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new TextEdit('region_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Region', 'region', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for sub_region field
            //
            $editor = new TextEdit('sub_region_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Sub Region', 'sub_region', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for territory field
            //
            $editor = new TextAreaEdit('territory_edit', 50, 8);
            $editColumn = new CustomEditColumn('Territory', 'territory', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for country field
            //
            $editor = new TextEdit('country_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Country', 'country', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for job_function field
            //
            $editor = new TextEdit('job_function_edit');
            $editColumn = new CustomEditColumn('Job Function', 'job_function', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for channel_type field
            //
            $editor = new TextEdit('channel_type_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('Channel Type', 'channel_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new TextEdit('product_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Product', 'product', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('M ID', 'm_ID', $editor, $this->dataset);
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
            // Edit column for campaign_type field
            //
            $editor = new TextEdit('campaign_type_edit');
            $editColumn = new CustomEditColumn('Campaign Type', 'campaign_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tracker_status field
            //
            $editor = new TextEdit('tracker_status_edit');
            $editColumn = new CustomEditColumn('Tracker Status', 'tracker_status', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for event_type field
            //
            $editor = new TextEdit('event_type_edit');
            $editColumn = new CustomEditColumn('Event Type', 'event_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for SFDC_child_campaign field
            //
            $editor = new TextEdit('sfdc_child_campaign_edit');
            $editor->SetMaxLength(18);
            $editColumn = new CustomEditColumn('SFDC Child Campaign', 'SFDC_child_campaign', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for icon field
            //
            $editor = new TextAreaEdit('icon_edit', 50, 8);
            $editColumn = new CustomEditColumn('Icon', 'icon', $editor, $this->dataset);
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Master Campaign Id', 'master_campaign_id', 'master_campaign_id_campaign_name', 'multi_edit_campaign_tracker_comms_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_description field
            //
            $editor = new TextEdit('campaign_description_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Campaign Description', 'campaign_description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_program_name field
            //
            $editor = new TextAreaEdit('campaign_program_name_edit', 50, 8);
            $editColumn = new CustomEditColumn('Campaign Program Name', 'campaign_program_name', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new TextAreaEdit('industry_edit', 50, 8);
            $editColumn = new CustomEditColumn('Industry', 'industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new TextEdit('region_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Region', 'region', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for sub_region field
            //
            $editor = new TextEdit('sub_region_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Sub Region', 'sub_region', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for territory field
            //
            $editor = new TextAreaEdit('territory_edit', 50, 8);
            $editColumn = new CustomEditColumn('Territory', 'territory', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for country field
            //
            $editor = new TextEdit('country_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Country', 'country', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for job_function field
            //
            $editor = new TextEdit('job_function_edit');
            $editColumn = new CustomEditColumn('Job Function', 'job_function', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for channel_type field
            //
            $editor = new TextEdit('channel_type_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('Channel Type', 'channel_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new TextEdit('product_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Product', 'product', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('M ID', 'm_ID', $editor, $this->dataset);
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
            // Edit column for campaign_type field
            //
            $editor = new TextEdit('campaign_type_edit');
            $editColumn = new CustomEditColumn('Campaign Type', 'campaign_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tracker_status field
            //
            $editor = new TextEdit('tracker_status_edit');
            $editColumn = new CustomEditColumn('Tracker Status', 'tracker_status', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for event_type field
            //
            $editor = new TextEdit('event_type_edit');
            $editColumn = new CustomEditColumn('Event Type', 'event_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for SFDC_child_campaign field
            //
            $editor = new TextEdit('sfdc_child_campaign_edit');
            $editor->SetMaxLength(18);
            $editColumn = new CustomEditColumn('SFDC Child Campaign', 'SFDC_child_campaign', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for icon field
            //
            $editor = new TextAreaEdit('icon_edit', 50, 8);
            $editColumn = new CustomEditColumn('Icon', 'icon', $editor, $this->dataset);
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Master Campaign Id', 'master_campaign_id', 'master_campaign_id_campaign_name', 'insert_campaign_tracker_comms_master_campaign_id_search', $editor, $this->dataset, $lookupDataset, 'master_campaign_id', 'campaign_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_description field
            //
            $editor = new TextEdit('campaign_description_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Campaign Description', 'campaign_description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_program_name field
            //
            $editor = new TextAreaEdit('campaign_program_name_edit', 50, 8);
            $editColumn = new CustomEditColumn('Campaign Program Name', 'campaign_program_name', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new TextAreaEdit('industry_edit', 50, 8);
            $editColumn = new CustomEditColumn('Industry', 'industry', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for region field
            //
            $editor = new TextEdit('region_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Region', 'region', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for sub_region field
            //
            $editor = new TextEdit('sub_region_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Sub Region', 'sub_region', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for territory field
            //
            $editor = new TextAreaEdit('territory_edit', 50, 8);
            $editColumn = new CustomEditColumn('Territory', 'territory', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for country field
            //
            $editor = new TextEdit('country_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Country', 'country', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for job_function field
            //
            $editor = new TextEdit('job_function_edit');
            $editColumn = new CustomEditColumn('Job Function', 'job_function', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for channel_type field
            //
            $editor = new TextEdit('channel_type_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('Channel Type', 'channel_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for product field
            //
            $editor = new TextEdit('product_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Product', 'product', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for m_ID field
            //
            $editor = new TextEdit('m_id_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('M ID', 'm_ID', $editor, $this->dataset);
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
            // Edit column for campaign_type field
            //
            $editor = new TextEdit('campaign_type_edit');
            $editColumn = new CustomEditColumn('Campaign Type', 'campaign_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tracker_status field
            //
            $editor = new TextEdit('tracker_status_edit');
            $editColumn = new CustomEditColumn('Tracker Status', 'tracker_status', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for event_type field
            //
            $editor = new TextEdit('event_type_edit');
            $editColumn = new CustomEditColumn('Event Type', 'event_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for SFDC_child_campaign field
            //
            $editor = new TextEdit('sfdc_child_campaign_edit');
            $editor->SetMaxLength(18);
            $editColumn = new CustomEditColumn('SFDC Child Campaign', 'SFDC_child_campaign', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for icon field
            //
            $editor = new TextAreaEdit('icon_edit', 50, 8);
            $editColumn = new CustomEditColumn('Icon', 'icon', $editor, $this->dataset);
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
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_campaign_description_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_campaign_program_name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_industry_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for region field
            //
            $column = new TextViewColumn('region', 'region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for sub_region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for territory field
            //
            $column = new TextViewColumn('territory', 'territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_territory_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for job_function field
            //
            $column = new NumberViewColumn('job_function', 'job_function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for channel_type field
            //
            $column = new TextViewColumn('channel_type', 'channel_type', 'Channel Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
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
            // View column for campaign_type field
            //
            $column = new NumberViewColumn('campaign_type', 'campaign_type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for tracker_status field
            //
            $column = new NumberViewColumn('tracker_status', 'tracker_status', 'Tracker Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for event_type field
            //
            $column = new NumberViewColumn('event_type', 'event_type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for SFDC_child_campaign field
            //
            $column = new TextViewColumn('SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Child Campaign', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for icon field
            //
            $column = new TextViewColumn('icon', 'icon', 'Icon', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_icon_handler_print');
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
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_campaign_description_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_campaign_program_name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_industry_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for region field
            //
            $column = new TextViewColumn('region', 'region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for sub_region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for territory field
            //
            $column = new TextViewColumn('territory', 'territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_territory_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for job_function field
            //
            $column = new NumberViewColumn('job_function', 'job_function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for channel_type field
            //
            $column = new TextViewColumn('channel_type', 'channel_type', 'Channel Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
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
            // View column for campaign_type field
            //
            $column = new NumberViewColumn('campaign_type', 'campaign_type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for tracker_status field
            //
            $column = new NumberViewColumn('tracker_status', 'tracker_status', 'Tracker Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for event_type field
            //
            $column = new NumberViewColumn('event_type', 'event_type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for SFDC_child_campaign field
            //
            $column = new TextViewColumn('SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Child Campaign', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for icon field
            //
            $column = new TextViewColumn('icon', 'icon', 'Icon', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_icon_handler_export');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_campaign_description_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_campaign_program_name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_industry_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for region field
            //
            $column = new TextViewColumn('region', 'region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for sub_region field
            //
            $column = new TextViewColumn('sub_region', 'sub_region', 'Sub Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for territory field
            //
            $column = new TextViewColumn('territory', 'territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_territory_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for job_function field
            //
            $column = new NumberViewColumn('job_function', 'job_function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for channel_type field
            //
            $column = new TextViewColumn('channel_type', 'channel_type', 'Channel Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for product field
            //
            $column = new TextViewColumn('product', 'product', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for m_ID field
            //
            $column = new TextViewColumn('m_ID', 'm_ID', 'M ID', $this->dataset);
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
            // View column for campaign_type field
            //
            $column = new NumberViewColumn('campaign_type', 'campaign_type', 'Campaign Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for tracker_status field
            //
            $column = new NumberViewColumn('tracker_status', 'tracker_status', 'Tracker Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for event_type field
            //
            $column = new NumberViewColumn('event_type', 'event_type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for SFDC_child_campaign field
            //
            $column = new TextViewColumn('SFDC_child_campaign', 'SFDC_child_campaign', 'SFDC Child Campaign', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for icon field
            //
            $column = new TextViewColumn('icon', 'icon', 'Icon', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('campaign_tracker_comms_icon_handler_compare');
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
            $this->SetShowBottomPageNavigator(false);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setDescription('<div class="mark-media mark-position-relative">
            	<div class="mark-bd-placeholder-img mr-3"><img src="http://mktportal.mscsoftware.com/apps/icons/comms-color.png" width="80" height="79"></div>
            	<div class="mark-media-body">
            		<h5 class="mt-0 h5">What will you find here</h5>
            		<p class="mark-p">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
            		<a href="http://mktportal.mscsoftware.com/campaign_global_list.php" class="stretched-link">View Live Lists</a>
            	</div>
            </div>');
            $this->SetHidePageListByDefault(true);
            $this->setShowFormErrorsOnTop(true);
            $this->setShowFormErrorsAtBottom(false);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_campaign_description_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_campaign_description_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_campaign_program_name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_industry_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for territory field
            //
            $column = new TextViewColumn('territory', 'territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_territory_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for icon field
            //
            $column = new TextViewColumn('icon', 'icon', 'Icon', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_icon_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_campaign_description_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_campaign_program_name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_industry_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for territory field
            //
            $column = new TextViewColumn('territory', 'territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_territory_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for icon field
            //
            $column = new TextViewColumn('icon', 'icon', 'Icon', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_icon_handler_compare', $column);
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_tracker_comms_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_tracker_comms_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_campaign_description_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('campaign_program_name', 'campaign_program_name', 'Campaign Program Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_campaign_program_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for industry field
            //
            $column = new TextViewColumn('industry', 'industry', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_industry_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for territory field
            //
            $column = new TextViewColumn('territory', 'territory', 'Territory', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_territory_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for icon field
            //
            $column = new TextViewColumn('icon', 'icon', 'Icon', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'campaign_tracker_comms_icon_handler_view', $column);
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_tracker_comms_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
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
                    new DateTimeField('updated_date')
                )
            );
            $lookupDataset->setOrderByField('campaign_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_tracker_comms_master_campaign_id_search', 'master_campaign_id', 'campaign_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            new campaign_tracker_comms_master_campaign_id_b_countryModalViewPage($this, GetCurrentUserPermissionSetForDataSource('campaign_tracker_comms.master_campaign_id.b_country'));
            new campaign_tracker_comms_master_campaign_idModalViewPage($this, GetCurrentUserPermissionSetForDataSource('campaign_tracker_comms.master_campaign_id'));
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
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new campaign_tracker_commsPage("campaign_tracker_comms", "campaign_tracker_comms.php", GetCurrentUserPermissionSetForDataSource("campaign_tracker_comms"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("campaign_tracker_comms"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
