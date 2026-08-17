<?php

return [
    'employee_created' => 'Employee created successfully.',
    'employee_updated' => 'Employee updated successfully.',
    'employee_deleted' => 'Employee deleted successfully.',
    'employee_status_updated' => 'Employee status updated successfully.',
    'role_created' => 'Role created successfully.',
    'role_updated' => 'Role updated successfully.',
    'role_deleted' => 'Role deleted successfully.',
    'user_created' => 'User created successfully.',
    'user_updated' => 'User updated successfully.',
    'user_deleted' => 'User deleted successfully.',
    'user_status_updated' => 'User status updated successfully.',
    'department_created' => 'Department created successfully.',
    'department_updated' => 'Department updated successfully.',
    'department_deleted' => 'Department deleted successfully.',
    'document_created' => 'Document created successfully.',
    'document_updated' => 'Document updated successfully.',
    'document_deleted' => 'Document deleted successfully.',
    'document_sent' => 'Document sent successfully.',
    'task_created' => 'Task created successfully.',
    'task_updated' => 'Task updated successfully.',
    'task_deleted' => 'Task deleted successfully.',
    'task_assigned' => 'Task assigned successfully.',
    'budget_entity_created' => 'Budget entity registered successfully.',
    'budget_entity_updated' => 'Budget entity updated successfully.',
    'budget_entity_deleted' => 'Budget entity deleted successfully.',
    'introduction_created' => 'Introduction letter registered successfully.',
    'introduction_updated' => 'Introduction letter updated successfully.',
    'introduction_deleted' => 'Introduction letter deleted successfully.',
    'introduction_status_updated' => 'Introduction-letter status updated successfully.',
    'focal_point_created' => 'Focal point registered successfully.',
    'focal_point_updated' => 'Focal point updated successfully.',
    'focal_point_deleted' => 'Focal point deleted successfully.',
    'focal_point_approved' => 'Focal point approved successfully.',
    'focal_point_suspended' => 'Focal point suspended successfully.',
    'card_generated' => 'Card generated successfully.',
    'card_printed' => 'Card marked as printed successfully.',
    'card_issued' => 'Card issued successfully.',
    'card_revoked' => 'Card revoked successfully.',
    'created' => 'Record created successfully.',
    'updated' => 'Record updated successfully.',
    'deleted' => 'Record deleted successfully.',
    'saved' => 'Data saved successfully.',
    'assigned' => 'Record assigned successfully.',
    'sent' => 'Document sent successfully.',
    'uploaded' => 'File uploaded successfully.',
    'status_updated' => 'Status updated successfully.',
    'error' => 'Something went wrong.',
    'not_found' => 'Record not found.',
    'unauthorized' => 'You are not authorized to perform this action.',
    'validation_failed' => 'Please correct the errors and try again.',
    'create_failed' => 'The record could not be created.',
    'update_failed' => 'The record could not be updated.',
    'delete_failed' => 'The record could not be deleted.',



    'focal_point_created' => 'Focal point registered successfully. Approval and card actions are now available.',
'focal_point_create_failed' => 'The focal point could not be registered. Please review the information and try again.',
'focal_point_updated' => 'Focal point information updated successfully.',
'focal_point_update_failed' => 'The focal point could not be updated. Please try again.',
'focal_point_has_card_history' => 'This focal point has card history and cannot be deleted. Suspend the focal point instead.',
'focal_point_deleted' => 'Focal point deleted successfully.',
'focal_point_delete_failed' => 'The focal point could not be deleted.',
'focal_point_already_approved' => 'This focal point is already approved.',
'focal_point_approved' => 'Focal point approved successfully. The ID card can now be generated.',
'focal_point_approval_failed' => 'The focal point could not be approved.',
'focal_point_already_suspended' => 'This focal point is already suspended.',
'card_auto_revoked_due_to_suspension' => 'Automatically revoked because the focal point was suspended.',
'focal_point_suspended' => 'Focal point suspended and active cards revoked.',
'focal_point_suspend_failed' => 'The focal point could not be suspended.',
'focal_point_must_be_approved' => 'The focal point must be approved before a card can be generated.',
'select_renewal_or_replacement' => 'Select renewal or replacement before creating another card.',
'card_generation_type_renewal' => 'Renewal',
'card_generation_type_replacement' => 'Replacement',
'card_generated' => 'Card :card_number generated successfully.',
'card_generation_failed' => 'The focal-point card could not be generated.',
'revoked_card_cannot_be_printed' => 'A revoked card cannot be printed.',
'card_focal_point_not_found' => 'The focal point connected to this card was not found.',
'card_print_failed' => 'The card PDF could not be generated.',
'revoked_card_cannot_be_marked_printed' => 'A revoked card cannot be marked as printed.',
'card_printed' => 'Card marked as printed successfully.',
'card_mark_printed_failed' => 'The card could not be marked as printed.',
'revoked_card_cannot_be_issued' => 'A revoked card cannot be issued.',
'card_issued' => 'Card issuance and handover recorded successfully.',
'card_issue_failed' => 'The card issuance could not be recorded.',
'card_already_revoked' => 'This card is already revoked.',
'card_revoked' => 'Card revoked successfully.',
'card_revoke_failed' => 'The card could not be revoked.',
'card_not_found' => 'The requested card was not found.',
'introduction_entity_mismatch' => 'The selected introduction letter does not belong to the selected budget entity.',


/*
|--------------------------------------------------------------------------
| Settings Center
|--------------------------------------------------------------------------
*/

'settings_updated' =>
    'Settings updated successfully.',

'settings_update_failed' =>
    'The settings could not be updated. Please try again.',

'settings_validation_failed' =>
    'Please correct the highlighted settings fields.',

'settings_file_upload_failed' =>
    'The Settings file could not be uploaded.',

'settings_access_denied' =>
    'You are not authorized to manage these settings.',


    // Additional Settings Center messages
'settings_not_found' =>
    'The requested Settings section was not found.',

'settings_file_uploaded' =>
    'The Settings file was uploaded successfully.',

'settings_file_invalid' =>
    'The selected file is invalid.',

'settings_history_unavailable' =>
    'Settings history is currently unavailable.',

'settings_no_changes' =>
    'There are no changes to save.',
];
