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

    
    
    class campaign_import_program_generator_name_idModalViewPage extends ViewBasedPage
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
            $this->dataset->AddLookupField('master_campaign_id', 'brief', new IntegerField('master_campaign_id'), new StringField('campaign_name', false, false, false, false, 'master_campaign_id_campaign_name', 'master_campaign_id_campaign_name_brief'), 'master_campaign_id_campaign_name_brief');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for campaign_name field
            //
            $column = new TextViewColumn('master_campaign_id', 'master_campaign_id_campaign_name', 'Master Campaign Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
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
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
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
            // View column for job_function field
            //
            $column = new NumberViewColumn('job_function', 'job_function', 'Job Function', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
            // View column for emails_tracker field
            //
            $column = new NumberViewColumn('emails_tracker', 'emails_tracker', 'Emails Tracker', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pregion field
            //
            $column = new TextViewColumn('pregion', 'pregion', 'Pregion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for import_total field
            //
            $column = new NumberViewColumn('import_total', 'import_total', 'Import Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for create_import_list field
            //
            $column = new NumberViewColumn('create_import_list', 'create_import_list', 'Create Import List', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_event_id field
            //
            $column = new NumberViewColumn('campaign_event_id', 'campaign_event_id', 'Campaign Event Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
            // View column for webinar_tracker field
            //
            $column = new NumberViewColumn('webinar_tracker', 'webinar_tracker', 'Webinar Tracker', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_publish_date_end field
            //
            $column = new DateTimeViewColumn('campaign_publish_date_end', 'campaign_publish_date_end', 'Campaign Publish Date End', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expired field
            //
            $column = new NumberViewColumn('expired', 'expired', 'Expired', $this->dataset);
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
    
    class campaign_import_list_obtainedNestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_imported_obtained`');
            $this->dataset->addFields(
                array(
                    new IntegerField('lookup_imported_obtainedid', true, true, true),
                    new StringField('description')
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for description field
            //
            $editor = new TextEdit('description_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Description', 'description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
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
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
       static public function getNestedInsertHandlerName()
        {
            return get_class() . '_form_insert';
        }
    
        public function GetGridInsertHandler()
        {
            return self::getNestedInsertHandlerName();
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class campaign_importPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Contact List Import');
            $this->SetMenuLabel('Contact List Import');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`campaign_import`');
            $this->dataset->addFields(
                array(
                    new IntegerField('campaign_import_id', true, true, true),
                    new IntegerField('program_generator_name_id'),
                    new DateTimeField('created_date'),
                    new StringField('trackerid'),
                    new IntegerField('list_total'),
                    new StringField('csv_list_location'),
                    new IntegerField('import_status'),
                    new IntegerField('cleaned'),
                    new IntegerField('duplicates'),
                    new IntegerField('imported_total'),
                    new IntegerField('list_obtained'),
                    new StringField('program_url'),
                    new StringField('created_by'),
                    new StringField('modified_by'),
                    new DateTimeField('modified_date'),
                    new IntegerField('png_trackerid')
                )
            );
            $this->dataset->AddLookupField('program_generator_name_id', 'campaign_program_name_generator', new IntegerField('program_generator_name_id'), new StringField('campaign_program_name', false, false, false, false, 'program_generator_name_id_campaign_program_name', 'program_generator_name_id_campaign_program_name_campaign_program_name_generator'), 'program_generator_name_id_campaign_program_name_campaign_program_name_generator');
            $this->dataset->AddLookupField('import_status', 'lookup_status_types', new IntegerField('Status_Type_ID'), new StringField('Status_Type', false, false, false, false, 'import_status_Status_Type', 'import_status_Status_Type_lookup_status_types'), 'import_status_Status_Type_lookup_status_types');
            $this->dataset->AddLookupField('list_obtained', 'lookup_imported_obtained', new IntegerField('lookup_imported_obtainedid'), new StringField('description', false, false, false, false, 'list_obtained_description', 'list_obtained_description_lookup_imported_obtained'), 'list_obtained_description_lookup_imported_obtained');
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
                new FilterColumn($this->dataset, 'campaign_import_id', 'campaign_import_id', 'Campaign Import Id'),
                new FilterColumn($this->dataset, 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Acquisition Program'),
                new FilterColumn($this->dataset, 'import_status', 'import_status_Status_Type', 'Import Status'),
                new FilterColumn($this->dataset, 'csv_list_location', 'csv_list_location', 'File URL (CSV stored in Teams)'),
                new FilterColumn($this->dataset, 'trackerid', 'trackerid', 'Trackerid'),
                new FilterColumn($this->dataset, 'list_total', 'list_total', 'List Total'),
                new FilterColumn($this->dataset, 'cleaned', 'cleaned', 'Cleaned'),
                new FilterColumn($this->dataset, 'duplicates', 'duplicates', 'Duplicates'),
                new FilterColumn($this->dataset, 'imported_total', 'imported_total', 'Imported Total'),
                new FilterColumn($this->dataset, 'list_obtained', 'list_obtained_description', 'List Obtained'),
                new FilterColumn($this->dataset, 'program_url', 'program_url', 'Program Url'),
                new FilterColumn($this->dataset, 'created_by', 'created_by', 'Created By'),
                new FilterColumn($this->dataset, 'created_date', 'created_date', 'Created Date'),
                new FilterColumn($this->dataset, 'modified_by', 'modified_by', 'Modified By'),
                new FilterColumn($this->dataset, 'modified_date', 'modified_date', 'Modified Date'),
                new FilterColumn($this->dataset, 'png_trackerid', 'png_trackerid', 'Png Trackerid')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['program_generator_name_id'])
                ->addColumn($columns['import_status'])
                ->addColumn($columns['csv_list_location'])
                ->addColumn($columns['list_total'])
                ->addColumn($columns['cleaned'])
                ->addColumn($columns['duplicates'])
                ->addColumn($columns['imported_total'])
                ->addColumn($columns['list_obtained'])
                ->addColumn($columns['program_url'])
                ->addColumn($columns['created_by'])
                ->addColumn($columns['created_date'])
                ->addColumn($columns['modified_by'])
                ->addColumn($columns['modified_date']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('program_generator_name_id')
                ->setOptionsFor('import_status')
                ->setOptionsFor('list_obtained')
                ->setOptionsFor('created_date');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('program_generator_name_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_import_program_generator_name_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('program_generator_name_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_import_program_generator_name_id_search');
            
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
            
            $main_editor = new DynamicCombobox('import_status_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_import_import_status_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('import_status', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_import_import_status_search');
            
            $filterBuilder->addColumn(
                $columns['import_status'],
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
            
            $main_editor = new TextEdit('csv_list_location_edit');
            $main_editor->SetPrefix('URL');
            $main_editor->SetPlaceholder('Copy the full shared list url in teams to the CSV files location');
            
            $filterBuilder->addColumn(
                $columns['csv_list_location'],
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
            
            $main_editor = new TextEdit('list_total_edit');
            
            $filterBuilder->addColumn(
                $columns['list_total'],
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
            
            $main_editor = new TextEdit('cleaned_edit');
            
            $filterBuilder->addColumn(
                $columns['cleaned'],
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
            
            $main_editor = new TextEdit('duplicates_edit');
            
            $filterBuilder->addColumn(
                $columns['duplicates'],
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
            
            $main_editor = new TextEdit('imported_total_edit');
            
            $filterBuilder->addColumn(
                $columns['imported_total'],
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
            
            $main_editor = new DynamicCombobox('list_obtained_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_campaign_import_list_obtained_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('list_obtained', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_campaign_import_list_obtained_search');
            
            $filterBuilder->addColumn(
                $columns['list_obtained'],
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
            
            $main_editor = new TextEdit('program_url_edit');
            $main_editor->SetSuffix('Marketo Program ID');
            
            $filterBuilder->addColumn(
                $columns['program_url'],
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
            
            $main_editor = new TextEdit('modified_by_edit');
            $main_editor->SetMaxLength(50);
            
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
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Acquisition Program', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setLookupRecordModalViewHandlerName(campaign_import_program_generator_name_idModalViewPage::getHandlerName());
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('import_status', 'import_status_Status_Type', 'Import Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for list_total field
            //
            $column = new NumberViewColumn('list_total', 'list_total', 'List Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for cleaned field
            //
            $column = new NumberViewColumn('cleaned', 'cleaned', 'Cleaned', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for duplicates field
            //
            $column = new NumberViewColumn('duplicates', 'duplicates', 'Duplicates', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for imported_total field
            //
            $column = new NumberViewColumn('imported_total', 'imported_total', 'Imported Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('list_obtained', 'list_obtained_description', 'List Obtained', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for program_url field
            //
            $column = new NumberViewColumn('program_url', 'program_url', 'Program Url', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
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
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Acquisition Program', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(campaign_import_program_generator_name_idModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('import_status', 'import_status_Status_Type', 'Import Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for csv_list_location field
            //
            $column = new DownloadExternalDataColumn('csv_list_location', 'csv_list_location', 'File URL (CSV stored in Teams)', $this->dataset, '');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for list_total field
            //
            $column = new NumberViewColumn('list_total', 'list_total', 'List Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cleaned field
            //
            $column = new NumberViewColumn('cleaned', 'cleaned', 'Cleaned', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for duplicates field
            //
            $column = new NumberViewColumn('duplicates', 'duplicates', 'Duplicates', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for imported_total field
            //
            $column = new NumberViewColumn('imported_total', 'imported_total', 'Imported Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('list_obtained', 'list_obtained_description', 'List Obtained', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for program_url field
            //
            $column = new NumberViewColumn('program_url', 'program_url', 'Program Url', $this->dataset);
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
    
        protected function AddEditColumns(Grid $grid)
        {
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
            $editColumn = new DynamicLookupEditColumn('Acquisition Program', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'edit_campaign_import_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for import_status field
            //
            $editor = new DynamicCombobox('import_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'import\''));
            $editColumn = new DynamicLookupEditColumn('Import Status', 'import_status', 'import_status_Status_Type', 'edit_campaign_import_import_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for csv_list_location field
            //
            $editor = new TextEdit('csv_list_location_edit');
            $editor->SetPrefix('URL');
            $editor->SetPlaceholder('Copy the full shared list url in teams to the CSV files location');
            $editColumn = new CustomEditColumn('File URL (CSV stored in Teams)', 'csv_list_location', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for list_total field
            //
            $editor = new TextEdit('list_total_edit');
            $editColumn = new CustomEditColumn('List Total', 'list_total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cleaned field
            //
            $editor = new TextEdit('cleaned_edit');
            $editColumn = new CustomEditColumn('Cleaned', 'cleaned', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for duplicates field
            //
            $editor = new TextEdit('duplicates_edit');
            $editColumn = new CustomEditColumn('Duplicates', 'duplicates', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for imported_total field
            //
            $editor = new TextEdit('imported_total_edit');
            $editColumn = new CustomEditColumn('Imported Total', 'imported_total', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for list_obtained field
            //
            $editor = new DynamicCombobox('list_obtained_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_imported_obtained`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_imported_obtainedid', true, true, true),
                    new StringField('description')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('List Obtained', 'list_obtained', 'list_obtained_description', 'edit_campaign_import_list_obtained_search', $editor, $this->dataset, $lookupDataset, 'lookup_imported_obtainedid', 'description', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(campaign_import_list_obtainedNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for program_url field
            //
            $editor = new TextEdit('program_url_edit');
            $editor->SetSuffix('Marketo Program ID');
            $editColumn = new CustomEditColumn('Program Url', 'program_url', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for modified_by field
            //
            $editor = new TextEdit('modified_by_edit');
            $editor->SetMaxLength(50);
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
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
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
            $editColumn = new DynamicLookupEditColumn('Acquisition Program', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'multi_edit_campaign_import_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for import_status field
            //
            $editor = new DynamicCombobox('import_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'import\''));
            $editColumn = new DynamicLookupEditColumn('Import Status', 'import_status', 'import_status_Status_Type', 'multi_edit_campaign_import_import_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for csv_list_location field
            //
            $editor = new TextEdit('csv_list_location_edit');
            $editor->SetPrefix('URL');
            $editor->SetPlaceholder('Copy the full shared list url in teams to the CSV files location');
            $editColumn = new CustomEditColumn('File URL (CSV stored in Teams)', 'csv_list_location', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for list_total field
            //
            $editor = new TextEdit('list_total_edit');
            $editColumn = new CustomEditColumn('List Total', 'list_total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cleaned field
            //
            $editor = new TextEdit('cleaned_edit');
            $editColumn = new CustomEditColumn('Cleaned', 'cleaned', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for duplicates field
            //
            $editor = new TextEdit('duplicates_edit');
            $editColumn = new CustomEditColumn('Duplicates', 'duplicates', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for imported_total field
            //
            $editor = new TextEdit('imported_total_edit');
            $editColumn = new CustomEditColumn('Imported Total', 'imported_total', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for list_obtained field
            //
            $editor = new DynamicCombobox('list_obtained_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_imported_obtained`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_imported_obtainedid', true, true, true),
                    new StringField('description')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('List Obtained', 'list_obtained', 'list_obtained_description', 'multi_edit_campaign_import_list_obtained_search', $editor, $this->dataset, $lookupDataset, 'lookup_imported_obtainedid', 'description', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(campaign_import_list_obtainedNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for program_url field
            //
            $editor = new TextEdit('program_url_edit');
            $editor->SetSuffix('Marketo Program ID');
            $editColumn = new CustomEditColumn('Program Url', 'program_url', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Created By', 'created_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for created_date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'created_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for modified_by field
            //
            $editor = new TextEdit('modified_by_edit');
            $editor->SetMaxLength(50);
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
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
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
            $editColumn = new DynamicLookupEditColumn('Acquisition Program', 'program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'insert_campaign_import_program_generator_name_id_search', $editor, $this->dataset, $lookupDataset, 'program_generator_name_id', 'campaign_program_name', '');
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for import_status field
            //
            $editor = new DynamicCombobox('import_status_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'import\''));
            $editColumn = new DynamicLookupEditColumn('Import Status', 'import_status', 'import_status_Status_Type', 'insert_campaign_import_import_status_search', $editor, $this->dataset, $lookupDataset, 'Status_Type_ID', 'Status_Type', '');
            $editColumn->SetInsertDefaultValue('27');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for csv_list_location field
            //
            $editor = new TextEdit('csv_list_location_edit');
            $editor->SetPrefix('URL');
            $editor->SetPlaceholder('Copy the full shared list url in teams to the CSV files location');
            $editColumn = new CustomEditColumn('File URL (CSV stored in Teams)', 'csv_list_location', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for list_total field
            //
            $editor = new TextEdit('list_total_edit');
            $editColumn = new CustomEditColumn('List Total', 'list_total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cleaned field
            //
            $editor = new TextEdit('cleaned_edit');
            $editColumn = new CustomEditColumn('Cleaned', 'cleaned', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for duplicates field
            //
            $editor = new TextEdit('duplicates_edit');
            $editColumn = new CustomEditColumn('Duplicates', 'duplicates', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for imported_total field
            //
            $editor = new TextEdit('imported_total_edit');
            $editColumn = new CustomEditColumn('Imported Total', 'imported_total', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for list_obtained field
            //
            $editor = new DynamicCombobox('list_obtained_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_imported_obtained`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_imported_obtainedid', true, true, true),
                    new StringField('description')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('List Obtained', 'list_obtained', 'list_obtained_description', 'insert_campaign_import_list_obtained_search', $editor, $this->dataset, $lookupDataset, 'lookup_imported_obtainedid', 'description', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(campaign_import_list_obtainedNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for program_url field
            //
            $editor = new TextEdit('program_url_edit');
            $editor->SetSuffix('Marketo Program ID');
            $editColumn = new CustomEditColumn('Program Url', 'program_url', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new UrlValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('UrlValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for created_by field
            //
            $editor = new TextEdit('created_by_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Created By', 'created_by', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_USER_NAME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for created_date field
            //
            $editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Created Date', 'created_date', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATETIME%');
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
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Acquisition Program', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('import_status', 'import_status_Status_Type', 'Import Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for csv_list_location field
            //
            $column = new DownloadExternalDataColumn('csv_list_location', 'csv_list_location', 'File URL (CSV stored in Teams)', $this->dataset, '');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for list_total field
            //
            $column = new NumberViewColumn('list_total', 'list_total', 'List Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cleaned field
            //
            $column = new NumberViewColumn('cleaned', 'cleaned', 'Cleaned', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for duplicates field
            //
            $column = new NumberViewColumn('duplicates', 'duplicates', 'Duplicates', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for imported_total field
            //
            $column = new NumberViewColumn('imported_total', 'imported_total', 'Imported Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('list_obtained', 'list_obtained_description', 'List Obtained', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for program_url field
            //
            $column = new NumberViewColumn('program_url', 'program_url', 'Program Url', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
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
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Acquisition Program', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('import_status', 'import_status_Status_Type', 'Import Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for csv_list_location field
            //
            $column = new DownloadExternalDataColumn('csv_list_location', 'csv_list_location', 'File URL (CSV stored in Teams)', $this->dataset, '');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for list_total field
            //
            $column = new NumberViewColumn('list_total', 'list_total', 'List Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for cleaned field
            //
            $column = new NumberViewColumn('cleaned', 'cleaned', 'Cleaned', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for duplicates field
            //
            $column = new NumberViewColumn('duplicates', 'duplicates', 'Duplicates', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for imported_total field
            //
            $column = new NumberViewColumn('imported_total', 'imported_total', 'Imported Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('list_obtained', 'list_obtained_description', 'List Obtained', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for program_url field
            //
            $column = new NumberViewColumn('program_url', 'program_url', 'Program Url', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
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
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for campaign_program_name field
            //
            $column = new TextViewColumn('program_generator_name_id', 'program_generator_name_id_campaign_program_name', 'Acquisition Program', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Status_Type field
            //
            $column = new TextViewColumn('import_status', 'import_status_Status_Type', 'Import Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for csv_list_location field
            //
            $column = new DownloadExternalDataColumn('csv_list_location', 'csv_list_location', 'File URL (CSV stored in Teams)', $this->dataset, '');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for list_total field
            //
            $column = new NumberViewColumn('list_total', 'list_total', 'List Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for cleaned field
            //
            $column = new NumberViewColumn('cleaned', 'cleaned', 'Cleaned', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for duplicates field
            //
            $column = new NumberViewColumn('duplicates', 'duplicates', 'Duplicates', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for imported_total field
            //
            $column = new NumberViewColumn('imported_total', 'imported_total', 'Imported Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('right');
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('list_obtained', 'list_obtained_description', 'List Obtained', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for program_url field
            //
            $column = new NumberViewColumn('program_url', 'program_url', 'Program Url', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for created_by field
            //
            $column = new TextViewColumn('created_by', 'created_by', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddCompareColumn($column);
            
            //
            // View column for created_date field
            //
            $column = new DateTimeViewColumn('created_date', 'created_date', 'Created Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
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
            $defaultSortedColumns = array();
            $defaultSortedColumns[] = new SortColumn('created_date', 'ASC');
            $result->setDefaultOrdering($defaultSortedColumns);
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
                          <div class="mark-bd-placeholder-img mr-3"><img src="apps/icons/import-color.png" width="80" height="79"></div>
                          <div class="mark-media-body">
                            <h5 class="mt-0 h5">What will you find here</h5>
                            <p class="mark-p">List import is the centralised managed import register to comply with GDPR and quality data being imported into Salesforce via Marketo.</p>
                            <i class="far fa-life-ring"></i> If you need more help go to <a href="portal_help.php?partitionpage=4" class="stretched-link">portal help</a> section!
                          </div>
                        </div>');
            $this->setShowFormErrorsOnTop(true);
            $this->setShowFormErrorsAtBottom(false);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_import_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'import\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_import_import_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_imported_obtained`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_imported_obtainedid', true, true, true),
                    new StringField('description')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_campaign_import_list_obtained_search', 'lookup_imported_obtainedid', 'description', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_import_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'import\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_import_import_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_imported_obtained`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_imported_obtainedid', true, true, true),
                    new StringField('description')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_campaign_import_list_obtained_search', 'lookup_imported_obtainedid', 'description', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_import_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'import\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_import_import_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_imported_obtained`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_imported_obtainedid', true, true, true),
                    new StringField('description')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_campaign_import_list_obtained_search', 'lookup_imported_obtainedid', 'description', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_import_program_generator_name_id_search', 'program_generator_name_id', 'campaign_program_name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'Status_Filters=\'import\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_import_import_status_search', 'Status_Type_ID', 'Status_Type', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_imported_obtained`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_imported_obtainedid', true, true, true),
                    new StringField('description')
                )
            );
            $lookupDataset->setOrderByField('description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_campaign_import_list_obtained_search', 'lookup_imported_obtainedid', 'description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            
            
            new campaign_import_program_generator_name_idModalViewPage($this, GetCurrentUserPermissionsForPage('campaign_import.program_generator_name_id'));
            new campaign_import_list_obtainedNestedPage($this, GetCurrentUserPermissionsForPage('campaign_import.list_obtained'));
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
            if ($success) {
            
                  $created_by = $rowData['created_by'];
                  $created_date = $rowData['created_date'];
                  $trackerid = $rowData['trackerid'];
            
                $sql = 
            
                  "CALL activityLogInsert('$created_by', '$created_date', 'INSERT', 'campaign_import', $trackerid);";
                  $this->GetConnection()->ExecSQL($sql);
                  
                  $message = '<p>Record inserted successfully.</p>';                                   
            }
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            if ($success) {
            
                  $modified_by = $rowData['modified_by'];
                  $modified_date = $rowData['modified_date'];
                  $trackerid = $rowData['trackerid'];
            
                $sql = 
            
                  "CALL activityLogInsert('$modified_by', '$modified_date', 'UPDATED', 'campaign_import', $trackerid);";
                  $this->GetConnection()->ExecSQL($sql);
                  
                  $message = '<p>Record updated successfully.</p>';                                   
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
            
            $displayGroup = $layout->addGroup('Overview');
            $displayGroup->addRow()
                ->addCol($columns['program_generator_name_id'], 12);
            $displayGroup->addRow()
                ->addCol($columns['list_obtained'], 12);
            $displayGroup->addRow()
                ->addCol($columns['program_url'], 12);
            $displayGroup->addRow()
                ->addCol($columns['csv_list_location'], 12);
            $displayGroup->addRow()
                ->addCol($columns['import_status'], 12);
            
            $storageGroup = $layout->addGroup('Marketo Admin', 12);
            $storageGroup->addRow()
                ->addCol($columns['list_total'], 3)
                ->addCol($columns['cleaned'], 3)
                ->addCol($columns['duplicates'], 3)
                ->addCol($columns['imported_total'], 3);
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
            $columnGroup->add(new ViewColumnGroup('Import Information',
                array(
                    new ViewColumnGroup('Target List',
                        array(
                            $columns['program_generator_name_id'],
                            $columns['created_date'],
                        )
                    ),
                    new ViewColumnGroup('Import Stats',
                        array(
                            $columns['list_total'],
                            $columns['cleaned'],
                            $columns['duplicates'],
                            $columns['imported_total']
                        )
                    )
                )
            ));
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
            $lt = $rowData['list_total'];
            $ct = $rowData['cleaned'];
            $dt = $rowData['duplicates'];
            
            if ($fieldName == 'imported_total') {
                 $value = $lt-$ct-$dt;
            }
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
        $Page = new campaign_importPage("campaign_import", "campaign_import.php", GetCurrentUserPermissionsForPage("campaign_import"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("campaign_import"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
