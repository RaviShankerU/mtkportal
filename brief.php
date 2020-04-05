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

    
    
    class brief_owner_personModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $this->dataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('user_name', 'user_name', 'User Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_owner_personModalViewPage_user_name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for user_email field
            //
            $column = new TextViewColumn('user_email', 'user_email', 'User Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_owner_personModalViewPage_user_email_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for user_status field
            //
            $column = new NumberViewColumn('user_status', 'user_status', 'User Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
            // View column for user_name field
            //
            $column = new TextViewColumn('user_name', 'user_name', 'User Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_owner_personModalViewPage_user_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for user_email field
            //
            $column = new TextViewColumn('user_email', 'user_email', 'User Email', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_owner_personModalViewPage_user_email_handler_view', $column);
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
    
    
    
    class briefPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Campaign: Brief Request');
            $this->SetMenuLabel('Campaign Brief');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
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
            $this->dataset->AddLookupField('campaign_type', 'lookup_brief_campaign_types', new IntegerField('brief_campaign_types_ID'), new StringField('campaign_types', false, false, false, false, 'campaign_type_campaign_types', 'campaign_type_campaign_types_lookup_brief_campaign_types'), 'campaign_type_campaign_types_lookup_brief_campaign_types');
            $this->dataset->AddLookupField('b_country', 'country_list', new StringField('Country_Name'), new StringField('Country_Name', false, false, false, false, 'b_country_Country_Name', 'b_country_Country_Name_country_list'), 'b_country_Country_Name_country_list');
            $this->dataset->AddLookupField('b_region', '(SELECT DISTINCT(`c_Region`) FROM `country_list` WHERE 1)', new StringField('c_Region'), new StringField('c_Region', false, false, false, false, 'b_region_c_Region', 'b_region_c_Region_lookup_Country_Region'), 'b_region_c_Region_lookup_Country_Region');
            $this->dataset->AddLookupField('event_type', 'lookup_event_type', new IntegerField('Event_Type_ID'), new StringField('Event_Type', false, false, false, false, 'event_type_Event_Type', 'event_type_Event_Type_lookup_event_type'), 'event_type_Event_Type_lookup_event_type');
            $this->dataset->AddLookupField('owner_person', 'phpgen_users', new IntegerField('user_id'), new StringField('user_name', false, false, false, false, 'owner_person_user_name', 'owner_person_user_name_phpgen_users'), 'owner_person_user_name_phpgen_users');
            $this->dataset->AddLookupField('industry', 'lookup_industries', new StringField('Industry_Name'), new StringField('Industry_Name', false, false, false, false, 'industry_Industry_Name', 'industry_Industry_Name_lookup_industries'), 'industry_Industry_Name_lookup_industries');
            $this->dataset->AddLookupField('campaign_status', 'lookup_status_types', new IntegerField('Status_Type_ID'), new StringField('Status_Type', false, false, false, false, 'campaign_status_Status_Type', 'campaign_status_Status_Type_lookup_status_types'), 'campaign_status_Status_Type_lookup_status_types');
            if (!$this->GetSecurityInfo()->HasAdminGrant()) {
                $this->dataset->setRlsPolicy(new RlsPolicy('created_by', GetApplication()->GetCurrentUserId()));
            }
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
                new FilterColumn($this->dataset, 'master_campaign_id', 'master_campaign_id', 'Master Campaign Id'),
                new FilterColumn($this->dataset, 'campaign_name', 'campaign_name', 'Campaign Name'),
                new FilterColumn($this->dataset, 'short_description', 'short_description', 'Short Description'),
                new FilterColumn($this->dataset, 'campaign_type', 'campaign_type_campaign_types', 'Reporting Type'),
                new FilterColumn($this->dataset, 'channel_types', 'channel_types', 'Channel'),
                new FilterColumn($this->dataset, 'campaign_tier', 'campaign_tier', 'Campaign Tier'),
                new FilterColumn($this->dataset, 'b_country', 'b_country_Country_Name', 'Country'),
                new FilterColumn($this->dataset, 'b_region', 'b_region_c_Region', 'Region'),
                new FilterColumn($this->dataset, 'event_type', 'event_type_Event_Type', 'Event Type'),
                new FilterColumn($this->dataset, 'objective', 'objective', 'Objective'),
                new FilterColumn($this->dataset, 'owner_person', 'owner_person_user_name', 'Project Owner'),
                new FilterColumn($this->dataset, 'industry', 'industry_Industry_Name', 'Industry'),
                new FilterColumn($this->dataset, 'est_opportunity_value_in_euros', 'est_opportunity_value_in_euros', 'Est Opportunity Value In Euros'),
                new FilterColumn($this->dataset, 'campaign_cost', 'campaign_cost', 'Campaign Cost'),
                new FilterColumn($this->dataset, 'expected_roi_enquiries', 'expected_roi_enquiries', 'Expected ROI Enquiries'),
                new FilterColumn($this->dataset, 'expected_roi_ots', 'expected_roi_ots', 'Expected ROI OTS'),
                new FilterColumn($this->dataset, 'post_enquiries', 'post_enquiries', 'Enquiries'),
                new FilterColumn($this->dataset, 'new_opportunities', 'new_opportunities', 'New Opportunities'),
                new FilterColumn($this->dataset, 'start_date', 'start_date', 'Start Date'),
                new FilterColumn($this->dataset, 'end_date', 'end_date', 'End Date'),
                new FilterColumn($this->dataset, 'file_upload', 'file_upload', 'Content Brief Document'),
                new FilterColumn($this->dataset, 'asset_upload', 'asset_upload', 'Additional Assets'),
                new FilterColumn($this->dataset, 'campaign_status', 'campaign_status_Status_Type', 'Campaign Status'),
                new FilterColumn($this->dataset, 'created_by', 'created_by', 'Created By'),
                new FilterColumn($this->dataset, 'created_date', 'created_date', 'Created Date'),
                new FilterColumn($this->dataset, 'updated_by', 'updated_by', 'Updated By'),
                new FilterColumn($this->dataset, 'updated_date', 'updated_date', 'Updated Date')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['master_campaign_id'])
                ->addColumn($columns['campaign_name'])
                ->addColumn($columns['short_description'])
                ->addColumn($columns['campaign_type'])
                ->addColumn($columns['channel_types'])
                ->addColumn($columns['campaign_tier'])
                ->addColumn($columns['b_country'])
                ->addColumn($columns['b_region'])
                ->addColumn($columns['event_type'])
                ->addColumn($columns['objective'])
                ->addColumn($columns['owner_person'])
                ->addColumn($columns['industry'])
                ->addColumn($columns['est_opportunity_value_in_euros'])
                ->addColumn($columns['campaign_cost'])
                ->addColumn($columns['expected_roi_enquiries'])
                ->addColumn($columns['expected_roi_ots'])
                ->addColumn($columns['post_enquiries'])
                ->addColumn($columns['new_opportunities'])
                ->addColumn($columns['start_date'])
                ->addColumn($columns['end_date'])
                ->addColumn($columns['file_upload'])
                ->addColumn($columns['asset_upload'])
                ->addColumn($columns['campaign_status'])
                ->addColumn($columns['created_by'])
                ->addColumn($columns['created_date'])
                ->addColumn($columns['updated_by'])
                ->addColumn($columns['updated_date']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('b_country')
                ->setOptionsFor('b_region')
                ->setOptionsFor('owner_person')
                ->setOptionsFor('start_date')
                ->setOptionsFor('end_date')
                ->setOptionsFor('campaign_status')
                ->setOptionsFor('created_date');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('master_campaign_id_edit');
            
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('campaign_name_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['campaign_name'],
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
            
            $main_editor = new TextEdit('short_description_edit');
            $main_editor->SetMaxLength(50);
            $main_editor->SetPlaceholder('What will your first campaign be called?');
            
            $filterBuilder->addColumn(
                $columns['short_description'],
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
            
            $main_editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brief_campaign_type_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('campaign_type', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brief_campaign_type_search');
            
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
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new RemoteMultiValueSelect('channel_types_edit', $this->CreateLinkBuilder());
            $main_editor->SetHandlerName('filter_builder_channel_types_channel_ID_channnel_name_search');
            $main_editor->setMaxSelectionSize(0);
            
            $filterBuilder->addColumn(
                $columns['channel_types'],
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
            
            $main_editor = new TextEdit('campaign_tier_edit');
            
            $filterBuilder->addColumn(
                $columns['campaign_tier'],
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
            
            $main_editor = new DynamicCombobox('b_country_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brief_b_country_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('b_country', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brief_b_country_search');
            
            $text_editor = new TextEdit('b_country');
            
            $filterBuilder->addColumn(
                $columns['b_country'],
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
            
            $main_editor = new DynamicCombobox('b_region_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brief_b_region_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('b_region', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brief_b_region_search');
            
            $text_editor = new TextEdit('b_region');
            
            $filterBuilder->addColumn(
                $columns['b_region'],
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
            
            $main_editor = new DynamicCombobox('event_type_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brief_event_type_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('event_type', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brief_event_type_search');
            
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
            
            $main_editor = new TextEdit('objective');
            
            $filterBuilder->addColumn(
                $columns['objective'],
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
            
            $main_editor = new DynamicCombobox('owner_person_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brief_owner_person_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('owner_person', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brief_owner_person_search');
            
            $text_editor = new TextEdit('owner_person');
            
            $filterBuilder->addColumn(
                $columns['owner_person'],
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
            
            $main_editor = new DynamicCombobox('industry_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brief_industry_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('industry', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brief_industry_search');
            
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
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('est_opportunity_value_in_euros_edit');
            $main_editor->SetPrefix('Qty');
            
            $filterBuilder->addColumn(
                $columns['est_opportunity_value_in_euros'],
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
            
            $main_editor = new TextEdit('campaign_cost_edit');
            $main_editor->SetPrefix('Euro');
            
            $filterBuilder->addColumn(
                $columns['campaign_cost'],
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
            
            $main_editor = new TextEdit('expected_roi_enquiries_edit');
            $main_editor->SetPrefix('Qty');
            
            $filterBuilder->addColumn(
                $columns['expected_roi_enquiries'],
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
            
            $main_editor = new TextEdit('expected_roi_ots_edit');
            $main_editor->SetPrefix('Qty');
            
            $filterBuilder->addColumn(
                $columns['expected_roi_ots'],
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
            
            $main_editor = new TextEdit('post_enquiries_edit');
            $main_editor->SetPrefix('Qty');
            
            $filterBuilder->addColumn(
                $columns['post_enquiries'],
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
            
            $main_editor = new TextEdit('new_opportunities_edit');
            $main_editor->SetPrefix('Qty');
            
            $filterBuilder->addColumn(
                $columns['new_opportunities'],
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
            
            $main_editor = new DateTimeEdit('start_date_edit', false, 'd.m.Y H:i:s');
            
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
            
            $main_editor = new DateTimeEdit('end_date_edit', false, 'd.m.Y H:i:s');
            
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
            
            $main_editor = new TextEdit('file_upload_edit');
            $main_editor->SetPlaceholder('Copy the shared link from your teams folder in here');
            
            $filterBuilder->addColumn(
                $columns['file_upload'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('asset_upload_edit');
            $main_editor->SetPlaceholder('Copy the shared link from your teams assets folder in here');
            
            $filterBuilder->addColumn(
                $columns['asset_upload'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('campaign_status_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_brief_campaign_status_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('campaign_status', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_brief_campaign_status_search');
            
            $filterBuilder->addColumn(
                $columns['campaign_status'],
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
            
            $main_editor = new TextEdit('created_by_edit');
            $main_editor->SetMaxLength(50);
            
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
            
            $main_editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y');
            
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
            
            $main_editor = new TextEdit('updated_by_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['updated_by'],
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
            
            $main_editor = new DateTimeEdit('updated_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['updated_date'],
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
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_campaign_name_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('b_country', 'b_country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_b_country_Country_Name_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for c_Region field
            //
            $column = new TextViewColumn('b_region', 'b_region_c_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_b_region_c_Region_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('owner_person', 'owner_person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setLookupRecordModalViewHandlerName(brief_owner_personModalViewPage::getHandlerName());
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
            // View column for Status_Type field
            //
            $column = new TextViewColumn('campaign_status', 'campaign_status_Status_Type', 'Status', $this->dataset);
            $column->setNullLabel('1');
            $column->SetOrderable(true);
            $column->setAlign('left');
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
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for master_campaign_id field
            //
            $column = new NumberViewColumn('master_campaign_id', 'master_campaign_id', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_campaign_name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_short_description_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_types field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_campaign_types', 'Reporting Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for channel_types field
            //
            $column = new TextViewColumn('channel_types', 'channel_types', 'Channel', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for Country_Name field
            //
            $column = new TextViewColumn('b_country', 'b_country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_b_country_Country_Name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for c_Region field
            //
            $column = new TextViewColumn('b_region', 'b_region_c_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_b_region_c_Region_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(500);
            $column->SetFullTextWindowHandlerName('brief_objective_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('owner_person', 'owner_person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(brief_owner_personModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_industry_Industry_Name_handler_view');
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
            $column = new CurrencyViewColumn('campaign_cost', 'campaign_cost', 'Campaign Cost', $this->dataset);
            $column->setNullLabel('0.00');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setCurrencySign('€ ');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expected_roi_enquiries field
            //
            $column = new NumberViewColumn('expected_roi_enquiries', 'expected_roi_enquiries', 'Expected ROI Enquiries', $this->dataset);
            $column->setNullLabel('0.0');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expected_roi_ots field
            //
            $column = new NumberViewColumn('expected_roi_ots', 'expected_roi_ots', 'Expected ROI OTS', $this->dataset);
            $column->setNullLabel('0.00');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for post_enquiries field
            //
            $column = new CheckboxViewColumn('post_enquiries', 'post_enquiries', 'Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for new_opportunities field
            //
            $column = new NumberViewColumn('new_opportunities', 'new_opportunities', 'New Opportunities', $this->dataset);
            $column->setNullLabel('0');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
            $column = new TextViewColumn('file_upload', 'file_upload', 'Content Brief Document', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%file_upload%');
            $column->setTarget('_blank');
            $column->SetMaxLength(2500);
            $column->SetFullTextWindowHandlerName('brief_file_upload_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for asset_upload field
            //
            $column = new TextViewColumn('asset_upload', 'asset_upload', 'Additional Assets', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('campaign_status', 'campaign_status_Status_Type', 'Campaign Status', $this->dataset);
            $column->setNullLabel('1');
            $column->SetOrderable(true);
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
            $column->SetDateTimeFormat('d-m-Y');
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
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for campaign_name field
            //
            $editor = new TextEdit('campaign_name_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Campaign Name', 'campaign_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for short_description field
            //
            $editor = new TextEdit('short_description_edit');
            $editor->SetMaxLength(50);
            $editor->SetPlaceholder('What will your first campaign be called?');
            $editColumn = new CustomEditColumn('Short Description', 'short_description', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_type field
            //
            $editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brief_campaign_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('brief_campaign_types_ID', true, true, true),
                    new StringField('campaign_types', true),
                    new StringField('description', true)
                )
            );
            $lookupDataset->setOrderByField('campaign_types', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Reporting Type', 'campaign_type', 'campaign_type_campaign_types', 'edit_brief_campaign_type_search', $editor, $this->dataset, $lookupDataset, 'brief_campaign_types_ID', 'campaign_types', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for channel_types field
            //
            $editor = new RemoteMultiValueSelect('channel_types_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('edit_channel_types_channel_ID_channnel_name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Campaign Channels', 'channel_types', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_tier field
            //
            $editor = new TextEdit('campaign_tier_edit');
            $editColumn = new CustomEditColumn('Campaign Tier', 'campaign_tier', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for b_country field
            //
            $editor = new DynamicCombobox('b_country_edit', $this->CreateLinkBuilder());
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
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Country', 'b_country', 'b_country_Country_Name', 'edit_brief_b_country_search', $editor, $this->dataset, $lookupDataset, 'Country_Name', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for b_region field
            //
            $editor = new DynamicCombobox('b_region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT DISTINCT(`c_Region`) FROM `country_list` WHERE 1';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_Country_Region');
            $lookupDataset->addFields(
                array(
                    new StringField('c_Region')
                )
            );
            $lookupDataset->setOrderByField('c_Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Region', 'b_region', 'b_region_c_Region', 'edit_brief_b_region_search', $editor, $this->dataset, $lookupDataset, 'c_Region', 'c_Region', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'edit_brief_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for objective field
            //
            $editor = new TextAreaEdit('objective_edit', 50, 2);
            $editor->setPlaceholder('Your objective should include the total period you want to run this campaign i.e.: 12 Months');
            $editColumn = new CustomEditColumn('Objective', 'objective', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for owner_person field
            //
            $editor = new DynamicCombobox('owner_person_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Project Owner', 'owner_person', 'owner_person_user_name', 'edit_brief_owner_person_search', $editor, $this->dataset, $lookupDataset, 'user_id', 'user_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new DynamicCombobox('industry_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Industry', 'industry', 'industry_Industry_Name', 'edit_brief_industry_search', $editor, $this->dataset, $lookupDataset, 'Industry_Name', 'Industry_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for est_opportunity_value_in_euros field
            //
            $editor = new TextEdit('est_opportunity_value_in_euros_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Estimated Opportunity Value', 'est_opportunity_value_in_euros', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_cost field
            //
            $editor = new TextEdit('campaign_cost_edit');
            $editor->SetPrefix('Euro');
            $editColumn = new CustomEditColumn('Campaign Cost', 'campaign_cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for expected_roi_enquiries field
            //
            $editor = new TextEdit('expected_roi_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Expected ROI Enquiries', 'expected_roi_enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for expected_roi_ots field
            //
            $editor = new TextEdit('expected_roi_ots_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Expected ROI OTS', 'expected_roi_ots', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for post_enquiries field
            //
            $editor = new TextEdit('post_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Enquiries', 'post_enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for new_opportunities field
            //
            $editor = new TextEdit('new_opportunities_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('New Opportunities', 'new_opportunities', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for start_date field
            //
            $editor = new DateTimeEdit('start_date_edit', false, 'd.m.Y H:i:s');
            $editColumn = new CustomEditColumn('Start Date', 'start_date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for end_date field
            //
            $editor = new DateTimeEdit('end_date_edit', false, 'd.m.Y H:i:s');
            $editColumn = new CustomEditColumn('End Date', 'end_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for file_upload field
            //
            $editor = new TextEdit('file_upload_edit');
            $editor->SetPlaceholder('Copy the shared link from your teams folder in here');
            $editColumn = new CustomEditColumn('Content Brief Document', 'file_upload', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for asset_upload field
            //
            $editor = new TextEdit('asset_upload_edit');
            $editor->SetPlaceholder('Copy the shared link from your teams assets folder in here');
            $editColumn = new CustomEditColumn('Additional Assets', 'asset_upload', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campaign_status field
            //
            $editor = new DynamicCombobox('campaign_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $editColumn = new DynamicLookupEditColumn('Campaign Status', 'campaign_status', 'campaign_status_Status_Type', 'edit_brief_campaign_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for updated_by field
            //
            $editor = new TextEdit('updated_by_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Updated By', 'updated_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for updated_date field
            //
            $editor = new DateTimeEdit('updated_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Updated Date', 'updated_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for campaign_name field
            //
            $editor = new TextEdit('campaign_name_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Campaign Name', 'campaign_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for short_description field
            //
            $editor = new TextEdit('short_description_edit');
            $editor->SetMaxLength(50);
            $editor->SetPlaceholder('What will your first campaign be called?');
            $editColumn = new CustomEditColumn('Short Description', 'short_description', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_type field
            //
            $editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brief_campaign_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('brief_campaign_types_ID', true, true, true),
                    new StringField('campaign_types', true),
                    new StringField('description', true)
                )
            );
            $lookupDataset->setOrderByField('campaign_types', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Reporting Type', 'campaign_type', 'campaign_type_campaign_types', 'multi_edit_brief_campaign_type_search', $editor, $this->dataset, $lookupDataset, 'brief_campaign_types_ID', 'campaign_types', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for channel_types field
            //
            $editor = new RemoteMultiValueSelect('channel_types_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('multi_edit_channel_types_channel_ID_channnel_name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Channel', 'channel_types', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_tier field
            //
            $editor = new TextEdit('campaign_tier_edit');
            $editColumn = new CustomEditColumn('Campaign Tier', 'campaign_tier', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for b_country field
            //
            $editor = new DynamicCombobox('b_country_edit', $this->CreateLinkBuilder());
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
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Country', 'b_country', 'b_country_Country_Name', 'multi_edit_brief_b_country_search', $editor, $this->dataset, $lookupDataset, 'Country_Name', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for b_region field
            //
            $editor = new DynamicCombobox('b_region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT DISTINCT(`c_Region`) FROM `country_list` WHERE 1';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_Country_Region');
            $lookupDataset->addFields(
                array(
                    new StringField('c_Region')
                )
            );
            $lookupDataset->setOrderByField('c_Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Region', 'b_region', 'b_region_c_Region', 'multi_edit_brief_b_region_search', $editor, $this->dataset, $lookupDataset, 'c_Region', 'c_Region', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'multi_edit_brief_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for objective field
            //
            $editor = new TextAreaEdit('objective_edit', 50, 2);
            $editor->setPlaceholder('Your objective should include the total period you want to run this campaign i.e.: 12 Months');
            $editColumn = new CustomEditColumn('Objective', 'objective', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for owner_person field
            //
            $editor = new DynamicCombobox('owner_person_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Project Owner', 'owner_person', 'owner_person_user_name', 'multi_edit_brief_owner_person_search', $editor, $this->dataset, $lookupDataset, 'user_id', 'user_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new DynamicCombobox('industry_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Industry', 'industry', 'industry_Industry_Name', 'multi_edit_brief_industry_search', $editor, $this->dataset, $lookupDataset, 'Industry_Name', 'Industry_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for est_opportunity_value_in_euros field
            //
            $editor = new TextEdit('est_opportunity_value_in_euros_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Est Opportunity Value In Euros', 'est_opportunity_value_in_euros', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_cost field
            //
            $editor = new TextEdit('campaign_cost_edit');
            $editor->SetPrefix('Euro');
            $editColumn = new CustomEditColumn('Campaign Cost', 'campaign_cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for expected_roi_enquiries field
            //
            $editor = new TextEdit('expected_roi_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Expected Roi Enquiries', 'expected_roi_enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for expected_roi_ots field
            //
            $editor = new TextEdit('expected_roi_ots_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Expected Roi Ots', 'expected_roi_ots', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for post_enquiries field
            //
            $editor = new TextEdit('post_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Enquiries', 'post_enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for new_opportunities field
            //
            $editor = new TextEdit('new_opportunities_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('New Opportunities', 'new_opportunities', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for start_date field
            //
            $editor = new DateTimeEdit('start_date_edit', false, 'd.m.Y H:i:s');
            $editColumn = new CustomEditColumn('Start Date', 'start_date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for end_date field
            //
            $editor = new DateTimeEdit('end_date_edit', false, 'd.m.Y H:i:s');
            $editColumn = new CustomEditColumn('End Date', 'end_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for file_upload field
            //
            $editor = new TextEdit('file_upload_edit');
            $editor->SetPlaceholder('Copy the shared link from your teams folder in here');
            $editColumn = new CustomEditColumn('Content Brief Document', 'file_upload', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for asset_upload field
            //
            $editor = new TextEdit('asset_upload_edit');
            $editor->SetPlaceholder('Copy the shared link from your teams assets folder in here');
            $editColumn = new CustomEditColumn('Additional Assets', 'asset_upload', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campaign_status field
            //
            $editor = new DynamicCombobox('campaign_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $editColumn = new DynamicLookupEditColumn('Campaign Status', 'campaign_status', 'campaign_status_Status_Type', 'multi_edit_brief_campaign_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Created By', 'created_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for created_date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Created Date', 'created_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for updated_by field
            //
            $editor = new TextEdit('updated_by_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Updated By', 'updated_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for updated_date field
            //
            $editor = new DateTimeEdit('updated_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Updated Date', 'updated_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for campaign_name field
            //
            $editor = new TextEdit('campaign_name_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Campaign Name', 'campaign_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for short_description field
            //
            $editor = new TextEdit('short_description_edit');
            $editor->SetMaxLength(50);
            $editor->SetPlaceholder('What will your first campaign be called?');
            $editColumn = new CustomEditColumn('Short Description', 'short_description', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_type field
            //
            $editor = new DynamicCombobox('campaign_type_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brief_campaign_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('brief_campaign_types_ID', true, true, true),
                    new StringField('campaign_types', true),
                    new StringField('description', true)
                )
            );
            $lookupDataset->setOrderByField('campaign_types', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Reporting Type', 'campaign_type', 'campaign_type_campaign_types', 'insert_brief_campaign_type_search', $editor, $this->dataset, $lookupDataset, 'brief_campaign_types_ID', 'campaign_types', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for channel_types field
            //
            $editor = new RemoteMultiValueSelect('channel_types_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('insert_channel_types_channel_ID_channnel_name_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Champaign Channels', 'channel_types', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_tier field
            //
            $editor = new TextEdit('campaign_tier_edit');
            $editColumn = new CustomEditColumn('Campaign Tier', 'campaign_tier', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('1');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for b_country field
            //
            $editor = new DynamicCombobox('b_country_edit', $this->CreateLinkBuilder());
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
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Country', 'b_country', 'b_country_Country_Name', 'insert_brief_b_country_search', $editor, $this->dataset, $lookupDataset, 'Country_Name', 'Country_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for b_region field
            //
            $editor = new DynamicCombobox('b_region_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT DISTINCT(`c_Region`) FROM `country_list` WHERE 1';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_Country_Region');
            $lookupDataset->addFields(
                array(
                    new StringField('c_Region')
                )
            );
            $lookupDataset->setOrderByField('c_Region', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Region', 'b_region', 'b_region_c_Region', 'insert_brief_b_region_search', $editor, $this->dataset, $lookupDataset, 'c_Region', 'c_Region', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Event Type', 'event_type', 'event_type_Event_Type', 'insert_brief_event_type_search', $editor, $this->dataset, $lookupDataset, 'Event_Type_ID', 'Event_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for objective field
            //
            $editor = new TextAreaEdit('objective_edit', 50, 2);
            $editor->setPlaceholder('Your objective should include the total period you want to run this campaign i.e.: 12 Months');
            $editColumn = new CustomEditColumn('Objective', 'objective', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for owner_person field
            //
            $editor = new DynamicCombobox('owner_person_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Project Owner', 'owner_person', 'owner_person_user_name', 'insert_brief_owner_person_search', $editor, $this->dataset, $lookupDataset, 'user_id', 'user_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for industry field
            //
            $editor = new DynamicCombobox('industry_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Industry', 'industry', 'industry_Industry_Name', 'insert_brief_industry_search', $editor, $this->dataset, $lookupDataset, 'Industry_Name', 'Industry_Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for est_opportunity_value_in_euros field
            //
            $editor = new TextEdit('est_opportunity_value_in_euros_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Estimated Opportunity Value', 'est_opportunity_value_in_euros', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('0');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_cost field
            //
            $editor = new TextEdit('campaign_cost_edit');
            $editor->SetPrefix('Euro');
            $editColumn = new CustomEditColumn('Campaign Cost', 'campaign_cost', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('€ 0.00');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for expected_roi_enquiries field
            //
            $editor = new TextEdit('expected_roi_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Expected ROI Enquiries', 'expected_roi_enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('0');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for expected_roi_ots field
            //
            $editor = new TextEdit('expected_roi_ots_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Expected ROI OTS', 'expected_roi_ots', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('0');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for post_enquiries field
            //
            $editor = new TextEdit('post_enquiries_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('Enquiries', 'post_enquiries', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('0');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for new_opportunities field
            //
            $editor = new TextEdit('new_opportunities_edit');
            $editor->SetPrefix('Qty');
            $editColumn = new CustomEditColumn('New Opportunities', 'new_opportunities', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('0');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for start_date field
            //
            $editor = new DateTimeEdit('start_date_edit', false, 'd.m.Y H:i:s');
            $editColumn = new CustomEditColumn('Start Date', 'start_date', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATE%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for end_date field
            //
            $editor = new DateTimeEdit('end_date_edit', false, 'd.m.Y H:i:s');
            $editColumn = new CustomEditColumn('End Date', 'end_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATE%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for file_upload field
            //
            $editor = new TextEdit('file_upload_edit');
            $editor->SetPlaceholder('Copy the shared link from your teams folder in here');
            $editColumn = new CustomEditColumn('Content Brief Document', 'file_upload', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for asset_upload field
            //
            $editor = new TextEdit('asset_upload_edit');
            $editor->SetPlaceholder('Copy the shared link from your teams assets folder in here');
            $editColumn = new CustomEditColumn('Additional Assets', 'asset_upload', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campaign_status field
            //
            $editor = new DynamicCombobox('campaign_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $editColumn = new DynamicLookupEditColumn('Campaign Status', 'campaign_status', 'campaign_status_Status_Type', 'insert_brief_campaign_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('5');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Created By', 'created_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_USER_NAME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for created_date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Created Date', 'created_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATE%');
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
            // View column for master_campaign_id field
            //
            $column = new NumberViewColumn('master_campaign_id', 'master_campaign_id', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_campaign_name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_short_description_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_types field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_campaign_types', 'Reporting Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for channel_types field
            //
            $column = new TextViewColumn('channel_types', 'channel_types', 'Channel', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_tier field
            //
            $column = new NumberViewColumn('campaign_tier', 'campaign_tier', 'Campaign Tier', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('b_country', 'b_country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_b_country_Country_Name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for c_Region field
            //
            $column = new TextViewColumn('b_region', 'b_region_c_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_b_region_c_Region_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(500);
            $column->SetFullTextWindowHandlerName('brief_objective_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('owner_person', 'owner_person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_owner_person_user_name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_industry_Industry_Name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for est_opportunity_value_in_euros field
            //
            $column = new NumberViewColumn('est_opportunity_value_in_euros', 'est_opportunity_value_in_euros', 'Est Opportunity Value In Euros', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for campaign_cost field
            //
            $column = new CurrencyViewColumn('campaign_cost', 'campaign_cost', 'Campaign Cost', $this->dataset);
            $column->setNullLabel('0.00');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setCurrencySign('€ ');
            $grid->AddPrintColumn($column);
            
            //
            // View column for expected_roi_enquiries field
            //
            $column = new NumberViewColumn('expected_roi_enquiries', 'expected_roi_enquiries', 'Expected ROI Enquiries', $this->dataset);
            $column->setNullLabel('0.0');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for expected_roi_ots field
            //
            $column = new NumberViewColumn('expected_roi_ots', 'expected_roi_ots', 'Expected ROI OTS', $this->dataset);
            $column->setNullLabel('0.00');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for post_enquiries field
            //
            $column = new CheckboxViewColumn('post_enquiries', 'post_enquiries', 'Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddPrintColumn($column);
            
            //
            // View column for new_opportunities field
            //
            $column = new NumberViewColumn('new_opportunities', 'new_opportunities', 'New Opportunities', $this->dataset);
            $column->setNullLabel('0');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
            // View column for file_upload field
            //
            $column = new TextViewColumn('file_upload', 'file_upload', 'Content Brief Document', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%file_upload%');
            $column->setTarget('_blank');
            $column->SetMaxLength(2500);
            $column->SetFullTextWindowHandlerName('brief_file_upload_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for asset_upload field
            //
            $column = new TextViewColumn('asset_upload', 'asset_upload', 'Additional Assets', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('campaign_status', 'campaign_status_Status_Type', 'Campaign Status', $this->dataset);
            $column->setNullLabel('1');
            $column->SetOrderable(true);
            $column->setAlign('left');
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
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for updated_by field
            //
            $column = new TextViewColumn('updated_by', 'updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for updated_date field
            //
            $column = new DateTimeViewColumn('updated_date', 'updated_date', 'Updated Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for master_campaign_id field
            //
            $column = new NumberViewColumn('master_campaign_id', 'master_campaign_id', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_campaign_name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_short_description_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_types field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_campaign_types', 'Reporting Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for channel_types field
            //
            $column = new TextViewColumn('channel_types', 'channel_types', 'Channel', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_tier field
            //
            $column = new NumberViewColumn('campaign_tier', 'campaign_tier', 'Campaign Tier', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('b_country', 'b_country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_b_country_Country_Name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for c_Region field
            //
            $column = new TextViewColumn('b_region', 'b_region_c_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_b_region_c_Region_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(500);
            $column->SetFullTextWindowHandlerName('brief_objective_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('owner_person', 'owner_person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_owner_person_user_name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_industry_Industry_Name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for est_opportunity_value_in_euros field
            //
            $column = new NumberViewColumn('est_opportunity_value_in_euros', 'est_opportunity_value_in_euros', 'Est Opportunity Value In Euros', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for campaign_cost field
            //
            $column = new CurrencyViewColumn('campaign_cost', 'campaign_cost', 'Campaign Cost', $this->dataset);
            $column->setNullLabel('0.00');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setCurrencySign('€ ');
            $grid->AddExportColumn($column);
            
            //
            // View column for expected_roi_enquiries field
            //
            $column = new NumberViewColumn('expected_roi_enquiries', 'expected_roi_enquiries', 'Expected ROI Enquiries', $this->dataset);
            $column->setNullLabel('0.0');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for expected_roi_ots field
            //
            $column = new NumberViewColumn('expected_roi_ots', 'expected_roi_ots', 'Expected ROI OTS', $this->dataset);
            $column->setNullLabel('0.00');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for post_enquiries field
            //
            $column = new CheckboxViewColumn('post_enquiries', 'post_enquiries', 'Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddExportColumn($column);
            
            //
            // View column for new_opportunities field
            //
            $column = new NumberViewColumn('new_opportunities', 'new_opportunities', 'New Opportunities', $this->dataset);
            $column->setNullLabel('0');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
            // View column for file_upload field
            //
            $column = new TextViewColumn('file_upload', 'file_upload', 'Content Brief Document', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%file_upload%');
            $column->setTarget('_blank');
            $column->SetMaxLength(2500);
            $column->SetFullTextWindowHandlerName('brief_file_upload_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for asset_upload field
            //
            $column = new TextViewColumn('asset_upload', 'asset_upload', 'Additional Assets', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('campaign_status', 'campaign_status_Status_Type', 'Campaign Status', $this->dataset);
            $column->setNullLabel('1');
            $column->SetOrderable(true);
            $column->setAlign('left');
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
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for updated_by field
            //
            $column = new TextViewColumn('updated_by', 'updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for updated_date field
            //
            $column = new DateTimeViewColumn('updated_date', 'updated_date', 'Updated Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_campaign_name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_short_description_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_types field
            //
            $column = new TextViewColumn('campaign_type', 'campaign_type_campaign_types', 'Reporting Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for channel_types field
            //
            $column = new TextViewColumn('channel_types', 'channel_types', 'Channel', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_tier field
            //
            $column = new NumberViewColumn('campaign_tier', 'campaign_tier', 'Campaign Tier', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('b_country', 'b_country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_b_country_Country_Name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for c_Region field
            //
            $column = new TextViewColumn('b_region', 'b_region_c_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_b_region_c_Region_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Event_Type field
            //
            $column = new TextViewColumn('event_type', 'event_type_Event_Type', 'Event Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(500);
            $column->SetFullTextWindowHandlerName('brief_objective_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('owner_person', 'owner_person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_owner_person_user_name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('brief_industry_Industry_Name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for est_opportunity_value_in_euros field
            //
            $column = new NumberViewColumn('est_opportunity_value_in_euros', 'est_opportunity_value_in_euros', 'Est Opportunity Value In Euros', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for campaign_cost field
            //
            $column = new CurrencyViewColumn('campaign_cost', 'campaign_cost', 'Campaign Cost', $this->dataset);
            $column->setNullLabel('0.00');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setCurrencySign('€ ');
            $grid->AddCompareColumn($column);
            
            //
            // View column for expected_roi_enquiries field
            //
            $column = new NumberViewColumn('expected_roi_enquiries', 'expected_roi_enquiries', 'Expected ROI Enquiries', $this->dataset);
            $column->setNullLabel('0.0');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for expected_roi_ots field
            //
            $column = new NumberViewColumn('expected_roi_ots', 'expected_roi_ots', 'Expected ROI OTS', $this->dataset);
            $column->setNullLabel('0.00');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for post_enquiries field
            //
            $column = new CheckboxViewColumn('post_enquiries', 'post_enquiries', 'Enquiries', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddCompareColumn($column);
            
            //
            // View column for new_opportunities field
            //
            $column = new NumberViewColumn('new_opportunities', 'new_opportunities', 'New Opportunities', $this->dataset);
            $column->setNullLabel('0');
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
            // View column for file_upload field
            //
            $column = new TextViewColumn('file_upload', 'file_upload', 'Content Brief Document', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%file_upload%');
            $column->setTarget('_blank');
            $column->SetMaxLength(2500);
            $column->SetFullTextWindowHandlerName('brief_file_upload_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for asset_upload field
            //
            $column = new TextViewColumn('asset_upload', 'asset_upload', 'Additional Assets', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('campaign_status', 'campaign_status_Status_Type', 'Campaign Status', $this->dataset);
            $column->setNullLabel('1');
            $column->SetOrderable(true);
            $column->setAlign('left');
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
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for updated_by field
            //
            $column = new TextViewColumn('updated_by', 'updated_by', 'Updated By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for updated_date field
            //
            $column = new DateTimeViewColumn('updated_date', 'updated_date', 'Updated Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
            //
            // View column for master_campaign_id field
            //
            $column = new NumberViewColumn('master_campaign_id', 'master_campaign_id', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareHeaderColumn($column);
            
            //
            // View column for channel_types field
            //
            $column = new TextViewColumn('channel_types', 'channel_types', 'Channel', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareHeaderColumn($column);
            
            //
            // View column for start_date field
            //
            $column = new DateTimeViewColumn('start_date', 'start_date', 'Start Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareHeaderColumn($column);
            
            //
            // View column for end_date field
            //
            $column = new DateTimeViewColumn('end_date', 'end_date', 'End Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareHeaderColumn($column);
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
    
    
            $this->SetViewFormTitle('%campaign_name%');
            $this->SetEditFormTitle('%campaign_name%');
            $this->SetInsertFormTitle('Add New Campaign Brief');
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
                          <div class="mark-bd-placeholder-img mr-3"><img src="http://mktportal.mscsoftware.com/icons/add-color.png" width="80" height="79"></div>
                          <div class="mark-media-body">
                            <h5 class="mt-0 h5">What will you find here</h5>
                            <p class="mark-p">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                            <a href="http://mktportal.mscsoftware.com/" class="stretched-link">Go to Master Campaign</a>
                          </div>
                        </div>');
            $this->SetHidePageListByDefault(true);
            $this->setShowFormErrorsOnTop(true);
            $this->setShowFormErrorsAtBottom(false);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
            $grid->SetInsertClientEditorValueChangedScript('if (sender.getFieldName() == \'channel_types\')
            {
              console.log(sender.getValue());
              editors[\'event_type\'].enabled(sender.getValue().indexOf("1") >= 0);
              if (sender.getValue().indexOf("1") >= 0) { 
                 editors[\'event_type\'].setValue();
                 editors[\'event_type\'].setVisible(true); 
                 $(\'#event_type_edit\').next().show();
              }
              else
              {
                 editors[\'event_type\'].setVisible(false);  
                $(\'#event_type_edit\').next().hide();  
              }
            }
            
            if (sender.getFieldName() == \'campaign_status\'){
              if (sender.getValue() == \'3\'){
                editors[\'require_review\'].setValue(\'\');
                editors[\'require_review\'].setVisible(true);   
                $(\'#require_review_edit\').next().show(); 
              }
              else{
                editors[\'require_review\'].setVisible(false); 
                $(\'#require_review_edit\').next().hide();      
              }
            }');
            
            $grid->SetEditClientEditorValueChangedScript('if (sender.getFieldName() == \'channel_types\')
            {
              console.log(sender.getValue());
              editors[\'event_type\'].enabled(sender.getValue().indexOf("1") >= 0);
              if (sender.getValue().indexOf("1") >= 0) { 
                 editors[\'event_type\'].setValue();
                 editors[\'event_type\'].setVisible(true); 
                 $(\'#event_type_edit\').next().show();
              }
              else
              {
                 editors[\'event_type\'].setVisible(false);  
                $(\'#event_type_edit\').next().hide();  
              }
            }');
            
            $grid->SetInsertClientFormLoadedScript('if (editors[\'channel_types\'].getValue() == \'\'){
                editors[\'event_type\'].setVisible(false);
                editors[\'event_type\'].setValue(\'\');  
            }
            else {
                editors[\'event_type\'].setVisible(true); 
            }
            
            if (editors[\'campaign_status\'].getValue() != 6){
                editors[\'require_review\'].setVisible(true);
            }
            else {
                editors[\'require_review\'].setEnabled(true); 
                editors[\'require_review\'].setValue(\'\');  
            }');
            
            $grid->SetEditClientFormLoadedScript('if (editors[\'campaign_status\'].getValue() == 3) {
                editors[\'require_review\'].setValue(\'0\');
                editors[\'require_review\'].setVisible(false);  
            }
            
            else {
                editors[\'require_review\'].setVisible(false); 
            }
            
            if (editors[\'campaign_type\'].getValue().indexOf("1") > 0) {
                editors[\'event_type\'].setValue(\'1\');
                editors[\'event_type\'].setVisible(true);  
            }
            else {
                editors[\'event_type\'].setVisible(false);  
            }');
        }
    
        protected function doRegisterHandlers() {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_campaign_name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('b_country', 'b_country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_b_country_Country_Name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for c_Region field
            //
            $column = new TextViewColumn('b_region', 'b_region_c_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_b_region_c_Region_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_campaign_name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_short_description_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('b_country', 'b_country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_b_country_Country_Name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for c_Region field
            //
            $column = new TextViewColumn('b_region', 'b_region_c_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_b_region_c_Region_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_objective_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('owner_person', 'owner_person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_owner_person_user_name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_industry_Industry_Name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for file_upload field
            //
            $column = new TextViewColumn('file_upload', 'file_upload', 'Content Brief Document', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%file_upload%');
            $column->setTarget('_blank');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_file_upload_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_campaign_name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_short_description_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('b_country', 'b_country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_b_country_Country_Name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for c_Region field
            //
            $column = new TextViewColumn('b_region', 'b_region_c_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_b_region_c_Region_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_objective_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('owner_person', 'owner_person_user_name', 'Project Owner', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_owner_person_user_name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_industry_Industry_Name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for file_upload field
            //
            $column = new TextViewColumn('file_upload', 'file_upload', 'Content Brief Document', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%file_upload%');
            $column->setTarget('_blank');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_file_upload_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brief_campaign_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('brief_campaign_types_ID', true, true, true),
                    new StringField('campaign_types', true),
                    new StringField('description', true)
                )
            );
            $lookupDataset->setOrderByField('campaign_types', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brief_campaign_type_search', 'brief_campaign_types_ID', 'campaign_types', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_channels`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('channel_ID', true, true, true),
                    new StringField('channnel_name')
                )
            );
            $valuesDataset->setOrderByField('channnel_name', 'ASC');
            $valuesDataset->addDistinct('channel_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'insert_channel_types_channel_ID_channnel_name_search', 'channel_ID', 'channnel_name', null, 20);
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
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brief_b_country_search', 'Country_Name', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT DISTINCT(`c_Region`) FROM `country_list` WHERE 1';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_Country_Region');
            $lookupDataset->addFields(
                array(
                    new StringField('c_Region')
                )
            );
            $lookupDataset->setOrderByField('c_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brief_b_region_search', 'c_Region', 'c_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brief_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brief_owner_person_search', 'user_id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brief_industry_search', 'Industry_Name', 'Industry_Name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_brief_campaign_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brief_campaign_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('brief_campaign_types_ID', true, true, true),
                    new StringField('campaign_types', true),
                    new StringField('description', true)
                )
            );
            $lookupDataset->setOrderByField('campaign_types', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brief_campaign_type_search', 'brief_campaign_types_ID', 'campaign_types', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_channels`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('channel_ID', true, true, true),
                    new StringField('channnel_name')
                )
            );
            $valuesDataset->setOrderByField('channnel_name', 'ASC');
            $valuesDataset->addDistinct('channel_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'filter_builder_channel_types_channel_ID_channnel_name_search', 'channel_ID', 'channnel_name', null, 20);
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
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brief_b_country_search', 'Country_Name', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT DISTINCT(`c_Region`) FROM `country_list` WHERE 1';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_Country_Region');
            $lookupDataset->addFields(
                array(
                    new StringField('c_Region')
                )
            );
            $lookupDataset->setOrderByField('c_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brief_b_region_search', 'c_Region', 'c_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brief_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brief_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brief_owner_person_search', 'user_id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brief_industry_search', 'Industry_Name', 'Industry_Name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_brief_campaign_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('campaign_name', 'campaign_name', 'Campaign Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_campaign_name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for short_description field
            //
            $column = new TextViewColumn('short_description', 'short_description', 'Short Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_short_description_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Country_Name field
            //
            $column = new TextViewColumn('b_country', 'b_country_Country_Name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_b_country_Country_Name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for c_Region field
            //
            $column = new TextViewColumn('b_region', 'b_region_c_Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_b_region_c_Region_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for objective field
            //
            $column = new TextViewColumn('objective', 'objective', 'Objective', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_objective_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for Industry_Name field
            //
            $column = new TextViewColumn('industry', 'industry_Industry_Name', 'Industry', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_industry_Industry_Name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for file_upload field
            //
            $column = new TextViewColumn('file_upload', 'file_upload', 'Content Brief Document', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%file_upload%');
            $column->setTarget('_blank');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'brief_file_upload_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brief_campaign_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('brief_campaign_types_ID', true, true, true),
                    new StringField('campaign_types', true),
                    new StringField('description', true)
                )
            );
            $lookupDataset->setOrderByField('campaign_types', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brief_campaign_type_search', 'brief_campaign_types_ID', 'campaign_types', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_channels`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('channel_ID', true, true, true),
                    new StringField('channnel_name')
                )
            );
            $valuesDataset->setOrderByField('channnel_name', 'ASC');
            $valuesDataset->addDistinct('channel_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'edit_channel_types_channel_ID_channnel_name_search', 'channel_ID', 'channnel_name', null, 20);
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
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brief_b_country_search', 'Country_Name', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT DISTINCT(`c_Region`) FROM `country_list` WHERE 1';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_Country_Region');
            $lookupDataset->addFields(
                array(
                    new StringField('c_Region')
                )
            );
            $lookupDataset->setOrderByField('c_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brief_b_region_search', 'c_Region', 'c_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brief_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brief_owner_person_search', 'user_id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brief_industry_search', 'Industry_Name', 'Industry_Name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_brief_campaign_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_brief_campaign_types`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('brief_campaign_types_ID', true, true, true),
                    new StringField('campaign_types', true),
                    new StringField('description', true)
                )
            );
            $lookupDataset->setOrderByField('campaign_types', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brief_campaign_type_search', 'brief_campaign_types_ID', 'campaign_types', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $valuesDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_channels`');
            $valuesDataset->addFields(
                array(
                    new IntegerField('channel_ID', true, true, true),
                    new StringField('channnel_name')
                )
            );
            $valuesDataset->setOrderByField('channnel_name', 'ASC');
            $valuesDataset->addDistinct('channel_ID');
            $handler = new DynamicSearchHandler($valuesDataset, $this, 'multi_edit_channel_types_channel_ID_channnel_name_search', 'channel_ID', 'channnel_name', null, 20);
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
                    new StringField('Territories')
                )
            );
            $lookupDataset->setOrderByField('Country_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brief_b_country_search', 'Country_Name', 'Country_Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT DISTINCT(`c_Region`) FROM `country_list` WHERE 1';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lookup_Country_Region');
            $lookupDataset->addFields(
                array(
                    new StringField('c_Region')
                )
            );
            $lookupDataset->setOrderByField('c_Region', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brief_b_region_search', 'c_Region', 'c_Region', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_event_type`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Event_Type_ID', true, true, true),
                    new StringField('Event_Type')
                )
            );
            $lookupDataset->setOrderByField('Event_Type', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brief_event_type_search', 'Event_Type_ID', 'Event_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true),
                    new StringField('user_level', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brief_owner_person_search', 'user_id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_industries`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('Industry_ID', true, true, true),
                    new StringField('Industry_Name')
                )
            );
            $lookupDataset->setOrderByField('Industry_Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brief_industry_search', 'Industry_Name', 'Industry_Name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters="brief"'));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_brief_campaign_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            new brief_owner_personModalViewPage($this, GetCurrentUserPermissionSetForDataSource('brief.owner_person'));
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
            if ($fieldName == 'data_field')
            {
               $customText = '<a href="dosomething.php?id=' .$rowData['master_campaign_id'] .'">Do something</a>';
               $handled = true;
            }
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
            if ($success) {
            
               // Check if the substring exists inside the string     
               
               $aMaster_campaign_id = $rowData['master_campaign_id'];
               $aShort_description = $rowData['short_description'];
               $aObjective = $rowData['objective'];
               $aEvent_type = $rowData['event_type'];
               $aRegion = $rowData['b_region'];
               $aCountry = $rowData['b_country'];
               $aIndustry = $rowData['industry'];
               $aEst_opportunity_value_in_euros = $rowData['est_opportunity_value_in_euros'];
               $aEvent_cost = $rowData['campaign_cost'];
               $aExpected_roi_enquiries = $rowData['expected_roi_enquiries'];
               $aExpected_roi_ots = $rowData['expected_roi_ots'];
               $aPost_enquiries = $rowData['post_enquiries'];
               $aNew_opportunities = $rowData['new_opportunities'];
               $aOwner_person = $rowData['owner_person'];
               $aStart_date = $rowData['start_date'];
               $aEnd_date = $rowData['end_date'];
               $aCreated_by = $rowData['created_by'];
               $aCreated_date = $rowData['created_date'];
               $aChannels = $rowData['channel_types'];
               $event = '1';
            
            
               $sql = 
               
                "CALL campaignEventsinsertupdatedelete($aMaster_campaign_id, '$aShort_description', '$aEvent_type', '$aIndustry', '$aObjective', '$aRegion', " .
                "'$aCountry', $aEst_opportunity_value_in_euros, $aEvent_cost, $aExpected_roi_enquiries, $aExpected_roi_ots, $aPost_enquiries, $aNew_opportunities, " .
                "$aOwner_person, '$aStart_date', '$aEnd_date', '$aCreated_by', '$aCreated_date', @LID);";
            
                $this->GetConnection()->ExecSQL($sql);  
                $lastInsertedEventId = '1'; 
                
                if (strpos($aChannels,$event) !== false) {
            
                    $message = '<p>Record processed successfully. Your event' .
                    ' has been update, we need more information. Click on ' .
                    '<a class="alert-link" href="campaign_events.php?operation=edit&pk0='. $lastInsertedEventId .'">my event</a> to complete your event setup.</p>';
                } else{
                    $message = '<p>Record processed successfully. ' .
                    'Your request has been submitted.</p>';
                }
            }
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            if ($success) {
            
               // Check if the substring exists inside the string     
               
               $aMaster_campaign_id = $rowData['master_campaign_id'];
               $aShort_description = $rowData['short_description'];
               $aObjective = $rowData['objective'];
               $aEvent_type = $rowData['event_type'];
               $aRegion = $rowData['b_region'];
               $aCountry = $rowData['b_country'];
               $aIndustry = $rowData['industry'];
               $aEst_opportunity_value_in_euros = $rowData['est_opportunity_value_in_euros'];
               $aEvent_cost = $rowData['campaign_cost'];
               $aExpected_roi_enquiries = $rowData['expected_roi_enquiries'];
               $aExpected_roi_ots = $rowData['expected_roi_ots'];
               $aPost_enquiries = $rowData['post_enquiries'];
               $aNew_opportunities = $rowData['new_opportunities'];
               $aOwner_person = $rowData['owner_person'];
               $aStart_date = $rowData['start_date'];
               $aEnd_date = $rowData['end_date'];
               $aCreated_by = $rowData['created_by'];
               $aCreated_date = $rowData['created_date'];
               $aChannels = $rowData['channel_types'];
               $event = '1';
            
            
               $sql = 
               
                "CALL campaignEventsinsertupdatedelete($aMaster_campaign_id, '$aShort_description', '$aEvent_type', '$aIndustry', '$aObjective', '$aRegion', " .
                "'$aCountry', $aEst_opportunity_value_in_euros, $aEvent_cost, $aExpected_roi_enquiries, $aExpected_roi_ots, $aPost_enquiries, $aNew_opportunities, " .
                "$aOwner_person, '$aStart_date', '$aEnd_date', '$aCreated_by', '$aCreated_date', @LID);";
            
                $this->GetConnection()->ExecSQL($sql);  
                $lastInsertedEventId = '1';
                
                while( $record = mysqli_fetch_assoc($this) ) {
                
                if (strpos($aChannels,$event) !== false) {
            
                    $message = '<p>Record processed successfully. Your event' .
                    ' has been update, we need more information. Click on ' .
                    '<a class="alert-link" href="campaign_events.php?operation=edit&pk0='. $record['@LID'] .'">my event</a> to complete your event setup.</p>';
                } else{
                    $message = '<p>Record processed successfully. ' .
                    'Your request has been submitted.</p>';
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
            $briefGroup->addRow()->addCol($columns['campaign_name'], 12);
            $briefGroup->addRow()->addCol($columns['objective'], 12);
            $briefGroup->addRow()->addCol($columns['short_description'], 12);
            $briefGroup->addRow()->addCol($columns['owner_person'], 12);
            $briefGroup->addRow()->addCol($columns['file_upload'], 12);
            $briefGroup->addRow()->addCol($columns['asset_upload'], 12);
            
            
            $storageGroup = $layout->addGroup('Projections', 12);
            $storageGroup->addRow()
                ->addCol($columns['campaign_cost'], 4)
                ->addCol($columns['new_opportunities'], 4)
                ->addCol($columns['post_enquiries'], 4);
            $storageGroup->addRow()
                ->addCol($columns['est_opportunity_value_in_euros'], 12);
            $storageGroup->addRow()
                ->addCol($columns['expected_roi_enquiries'], 6)
                ->addCol($columns['expected_roi_ots'], 6);    
            
            $storageGroup = $layout->addGroup('Target Audience', 12);
            $storageGroup->addRow()
                ->addCol($columns['b_country'], 6)
                ->addCol($columns['b_region'], 6);
            $storageGroup->addRow()
                ->addCol($columns['industry'], 12);
                
            $storageGroup = $layout->addGroup('Campaign Period', 12);
            $storageGroup->addRow()
                ->addCol($columns['start_date'], 6)
                ->addCol($columns['end_date'], 6);
            
            $storageGroup = $layout->addGroup('Marketing Requirements', 12);
            $storageGroup->addRow()
                ->addCol($columns['channel_types'], 12);
            $storageGroup->addRow()
                ->addCol($columns['event_type'], 8)
                ->addCol($columns['campaign_type'], 4);
              
                
            $storageGroup = $layout->addGroup('Campaign Admin', 12);
            $storageGroup->addRow()
                ->addCol($columns['campaign_status'], 12);
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
        $Page = new briefPage("brief", "brief.php", GetCurrentUserPermissionSetForDataSource("brief"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("brief"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
