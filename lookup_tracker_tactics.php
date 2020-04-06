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

    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class lookup_tracker_tacticsPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Tactic Template Builder');
            $this->SetMenuLabel('Tactic Template');
            $this->SetHeader(GetPagesHeader());
            $this->SetFooter(GetPagesFooter());
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_tracker_tactics`');
            $this->dataset->addFields(
                array(
                    new IntegerField('lookup_tracker_tactics_id', true, true, true),
                    new StringField('channel_name'),
                    new StringField('campaign_description'),
                    new StringField('tactic_name')
                )
            );
            $this->dataset->AddLookupField('channel_name', 'lookup_channels', new StringField('channnel_name'), new StringField('channnel_name', false, false, false, false, 'channel_name_channnel_name', 'channel_name_channnel_name_lookup_channels'), 'channel_name_channnel_name_lookup_channels');
            $this->dataset->AddLookupField('tactic_name', 'lookup_tactic', new IntegerField('lookup_tactic_ID'), new StringField('tactic_description', false, false, false, false, 'tactic_name_tactic_description', 'tactic_name_tactic_description_lookup_tactic'), 'tactic_name_tactic_description_lookup_tactic');
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
                new FilterColumn($this->dataset, 'lookup_tracker_tactics_id', 'lookup_tracker_tactics_id', 'Lookup Tracker Tactics Id'),
                new FilterColumn($this->dataset, 'channel_name', 'channel_name_channnel_name', 'Channel Name'),
                new FilterColumn($this->dataset, 'campaign_description', 'campaign_description', 'Campaign Description'),
                new FilterColumn($this->dataset, 'tactic_name', 'tactic_name_tactic_description', 'Tactic Name')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['lookup_tracker_tactics_id'])
                ->addColumn($columns['channel_name'])
                ->addColumn($columns['campaign_description'])
                ->addColumn($columns['tactic_name']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('channel_name')
                ->setOptionsFor('tactic_name');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('lookup_tracker_tactics_id_edit');
            
            $filterBuilder->addColumn(
                $columns['lookup_tracker_tactics_id'],
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
            
            $main_editor = new DynamicCombobox('channel_name_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_lookup_tracker_tactics_channel_name_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('channel_name', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_lookup_tracker_tactics_channel_name_search');
            
            $text_editor = new TextEdit('channel_name');
            
            $filterBuilder->addColumn(
                $columns['channel_name'],
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
            
            $main_editor = new DynamicCombobox('tactic_name_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_lookup_tracker_tactics_tactic_name_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('tactic_name', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_lookup_tracker_tactics_tactic_name_search');
            
            $text_editor = new TextEdit('tactic_name');
            
            $filterBuilder->addColumn(
                $columns['tactic_name'],
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
            // View column for channnel_name field
            //
            $column = new TextViewColumn('channel_name', 'channel_name_channnel_name', 'Channel Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
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
            $column->SetFullTextWindowHandlerName('lookup_tracker_tactics_campaign_description_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tactic_description field
            //
            $column = new TextViewColumn('tactic_name', 'tactic_name_tactic_description', 'Tactic Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for lookup_tracker_tactics_id field
            //
            $column = new NumberViewColumn('lookup_tracker_tactics_id', 'lookup_tracker_tactics_id', 'Lookup Tracker Tactics Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for channnel_name field
            //
            $column = new TextViewColumn('channel_name', 'channel_name_channnel_name', 'Channel Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('lookup_tracker_tactics_campaign_description_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tactic_description field
            //
            $column = new TextViewColumn('tactic_name', 'tactic_name_tactic_description', 'Tactic Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for channel_name field
            //
            $editor = new DynamicCombobox('channel_name_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_channels`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('channel_ID', true, true, true),
                    new StringField('channnel_name')
                )
            );
            $lookupDataset->setOrderByField('channnel_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Channel Name', 'channel_name', 'channel_name_channnel_name', 'edit_lookup_tracker_tactics_channel_name_search', $editor, $this->dataset, $lookupDataset, 'channnel_name', 'channnel_name', '');
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
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tactic_name field
            //
            $editor = new DynamicCombobox('tactic_name_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_tactic`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_tactic_ID', true, true, true),
                    new StringField('tactic_description')
                )
            );
            $lookupDataset->setOrderByField('tactic_description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Tactic Name', 'tactic_name', 'tactic_name_tactic_description', 'edit_lookup_tracker_tactics_tactic_name_search', $editor, $this->dataset, $lookupDataset, 'lookup_tactic_ID', 'tactic_description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for channel_name field
            //
            $editor = new DynamicCombobox('channel_name_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_channels`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('channel_ID', true, true, true),
                    new StringField('channnel_name')
                )
            );
            $lookupDataset->setOrderByField('channnel_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Channel Name', 'channel_name', 'channel_name_channnel_name', 'multi_edit_lookup_tracker_tactics_channel_name_search', $editor, $this->dataset, $lookupDataset, 'channnel_name', 'channnel_name', '');
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
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tactic_name field
            //
            $editor = new DynamicCombobox('tactic_name_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_tactic`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_tactic_ID', true, true, true),
                    new StringField('tactic_description')
                )
            );
            $lookupDataset->setOrderByField('tactic_description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Tactic Name', 'tactic_name', 'tactic_name_tactic_description', 'multi_edit_lookup_tracker_tactics_tactic_name_search', $editor, $this->dataset, $lookupDataset, 'lookup_tactic_ID', 'tactic_description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for channel_name field
            //
            $editor = new DynamicCombobox('channel_name_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_channels`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('channel_ID', true, true, true),
                    new StringField('channnel_name')
                )
            );
            $lookupDataset->setOrderByField('channnel_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Channel Name', 'channel_name', 'channel_name_channnel_name', 'insert_lookup_tracker_tactics_channel_name_search', $editor, $this->dataset, $lookupDataset, 'channnel_name', 'channnel_name', '');
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
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tactic_name field
            //
            $editor = new DynamicCombobox('tactic_name_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_tactic`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_tactic_ID', true, true, true),
                    new StringField('tactic_description')
                )
            );
            $lookupDataset->setOrderByField('tactic_description', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Tactic Name', 'tactic_name', 'tactic_name_tactic_description', 'insert_lookup_tracker_tactics_tactic_name_search', $editor, $this->dataset, $lookupDataset, 'lookup_tactic_ID', 'tactic_description', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            // View column for lookup_tracker_tactics_id field
            //
            $column = new NumberViewColumn('lookup_tracker_tactics_id', 'lookup_tracker_tactics_id', 'Lookup Tracker Tactics Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for channnel_name field
            //
            $column = new TextViewColumn('channel_name', 'channel_name_channnel_name', 'Channel Name', $this->dataset);
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
            $column->SetFullTextWindowHandlerName('lookup_tracker_tactics_campaign_description_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for tactic_description field
            //
            $column = new TextViewColumn('tactic_name', 'tactic_name_tactic_description', 'Tactic Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for lookup_tracker_tactics_id field
            //
            $column = new NumberViewColumn('lookup_tracker_tactics_id', 'lookup_tracker_tactics_id', 'Lookup Tracker Tactics Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for channnel_name field
            //
            $column = new TextViewColumn('channel_name', 'channel_name_channnel_name', 'Channel Name', $this->dataset);
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
            $column->SetFullTextWindowHandlerName('lookup_tracker_tactics_campaign_description_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for tactic_description field
            //
            $column = new TextViewColumn('tactic_name', 'tactic_name_tactic_description', 'Tactic Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for channnel_name field
            //
            $column = new TextViewColumn('channel_name', 'channel_name_channnel_name', 'Channel Name', $this->dataset);
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
            $column->SetFullTextWindowHandlerName('lookup_tracker_tactics_campaign_description_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for tactic_description field
            //
            $column = new TextViewColumn('tactic_name', 'tactic_name_tactic_description', 'Tactic Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
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
                          <div class="mark-bd-placeholder-img mr-3"><img src="http://mktportal.mscsoftware.com/icons/globe-color.png" width="80" height="79"></div>
                          <div class="mark-media-body">
                            <h5 class="mt-0 h5">What will you find here</h5>
                            <p class="mark-p">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                            <a href="http://mktportal.mscsoftware.com/master_campaign_global.php" class="stretched-link">Go to Master Campaign</a>
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
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'lookup_tracker_tactics_campaign_description_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'lookup_tracker_tactics_campaign_description_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('left');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'lookup_tracker_tactics_campaign_description_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_channels`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('channel_ID', true, true, true),
                    new StringField('channnel_name')
                )
            );
            $lookupDataset->setOrderByField('channnel_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_lookup_tracker_tactics_channel_name_search', 'channnel_name', 'channnel_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_tactic`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_tactic_ID', true, true, true),
                    new StringField('tactic_description')
                )
            );
            $lookupDataset->setOrderByField('tactic_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_lookup_tracker_tactics_tactic_name_search', 'lookup_tactic_ID', 'tactic_description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_channels`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('channel_ID', true, true, true),
                    new StringField('channnel_name')
                )
            );
            $lookupDataset->setOrderByField('channnel_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_lookup_tracker_tactics_channel_name_search', 'channnel_name', 'channnel_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_tactic`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_tactic_ID', true, true, true),
                    new StringField('tactic_description')
                )
            );
            $lookupDataset->setOrderByField('tactic_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_lookup_tracker_tactics_tactic_name_search', 'lookup_tactic_ID', 'tactic_description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for campaign_description field
            //
            $column = new TextViewColumn('campaign_description', 'campaign_description', 'Campaign Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'lookup_tracker_tactics_campaign_description_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_channels`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('channel_ID', true, true, true),
                    new StringField('channnel_name')
                )
            );
            $lookupDataset->setOrderByField('channnel_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_lookup_tracker_tactics_channel_name_search', 'channnel_name', 'channnel_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_tactic`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_tactic_ID', true, true, true),
                    new StringField('tactic_description')
                )
            );
            $lookupDataset->setOrderByField('tactic_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_lookup_tracker_tactics_tactic_name_search', 'lookup_tactic_ID', 'tactic_description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_channels`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('channel_ID', true, true, true),
                    new StringField('channnel_name')
                )
            );
            $lookupDataset->setOrderByField('channnel_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_lookup_tracker_tactics_channel_name_search', 'channnel_name', 'channnel_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`lookup_tactic`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('lookup_tactic_ID', true, true, true),
                    new StringField('tactic_description')
                )
            );
            $lookupDataset->setOrderByField('tactic_description', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_lookup_tracker_tactics_tactic_name_search', 'lookup_tactic_ID', 'tactic_description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
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
        $Page = new lookup_tracker_tacticsPage("lookup_tracker_tactics", "lookup_tracker_tactics.php", GetCurrentUserPermissionSetForDataSource("lookup_tracker_tactics"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("lookup_tracker_tactics"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
