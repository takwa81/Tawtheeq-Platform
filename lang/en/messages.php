<?php

return [

    'errors' => [
        'route_not_found' => 'The requested route was not found.',
        'method_not_allowed' => 'The HTTP method is not allowed for this route.',
        'unauthenticated' => 'You are not authenticated.',
        'forbidden' => 'You do not have permission to access this resource.',
        'validation_failed' => 'Validation failed.',
        'model_not_found' => 'The requested resource was not found.',
        'unexpected_error' => 'An unexpected error occurred. Please try again later.',
    ],

    'token_required' => 'Authentication token is required .',
    'token_invalid' => 'Invalid or expired token.',
    'fetch_failed'          => 'An error occurred while fetching data',

    'added_successfully'    => 'Added successfully',
    'add_failed'            => 'Failed to add',
    'updated_successfully'  => 'Updated successfully',
    'update_failed'         => 'Failed to update',
    'deleted_successfully'  => 'Deleted successfully',
    'delete_failed'         => 'Failed to delete',
    'restored_successfully' => 'Restored Successfully',
    'restore_failed'        => 'Failed to restore',

    'operation_failed' => 'Operation failed',
    'user_activated_successfully' => 'Data entry user activated successfully',
    'user_deactivated_successfully' => 'Data entry user deactivated successfully',

    'password_changed_successfully' => 'Password changed successfully',
    'failed' => 'Operation failed',
    'user_id_required' => 'User ID is required',
    'user_not_found' => 'User not found',
    'password_required' => 'Password is required',
    'password_min' => 'Password must be at least 6 characters',
    'password_confirmed' => 'Password confirmation does not match',

    'validation_failed' => 'Validation failed',

    'phone_number_required' => 'Phone number is required',
    'invalid_credentials' => 'Invalid phone number or password',
    'account_not_active' => 'Your account is not active',
    'contact_support' => 'Too many failed attempts. Please contact support',
    'login_success' => 'Login successfully',
    'not_found' => 'Not Found',
    'current_password_required' => 'Current password is required',
    'new_password_required' => 'New password is required',
    'new_password_confirmation' => 'New password confirmation does not match',
    'new_password_min' => 'New password must be at least 8 characters',
    'password_incorrect' => 'Current password is incorrect',
    'password_changed_success' => 'Password changed successfully',
    'contact_support' => 'Too many failed attempts. Please contact support',
    'logout_success' => 'Logged out successfully',
    'not_authenticated' => 'User not authenticated',

    'full_name_required' => 'Full name is required.',
    'full_name_string' => 'Full name must be a string.',
    'full_name_max' => 'Full name cannot exceed 255 characters.',

    'phone_number_string' => 'Phone number must be a string.',
    'phone_number_max' => 'Phone number cannot exceed 20 characters.',
    'phone_number_unique' => 'This phone number is already taken.',


    'gender_in' => 'Gender must be male or female.',

    'academic_qualification_id_exists' => 'Selected academic qualification does not exist.',

    'age_integer' => 'Age must be an integer.',

    'email_email' => 'Email must be a valid email address.',

    'personal_image_path_image' => 'Personal image must be a valid image.',
    'personal_image_path_max' => 'Personal image size cannot exceed 2MB.',

    'data_entry_note_string' => 'Data entry note must be a string.',

    'creator_user_id_exists' => 'Selected creator user does not exist.',

    'service_owner_created_success' => 'Service Owner Created Successfully ..',
    'not_authorized_update_service_owner' => 'You are not authorized to update this service owner.',
    'service_owner_updated_success' => 'Service owner updated successfully.',

    'service_created_success' => 'Service created Successfully ..',
    'service_name_required' => 'At least one of service_name_en or service_name_ar is required.',
    'service_name_en_max' => 'Service name (EN) must not exceed 255 characters.',
    'service_name_ar_max' => 'Service name (AR) must not exceed 255 characters.',
    'service_updated_success' => 'Service updated Successfully ..',

    'service_schedule_created_success' => 'Service schedule created successfully.',
    'service_schedule_updated_success' => 'Service schedule updated successfully.',
    'service_schedule_deleted_success' => 'Service schedule deleted successfully.',

    'service_schedule_required' => 'Schedules are required.',
    'service_schedule_array' => 'Schedules must be an array.',
    'service_schedule_day_required' => 'Day is required.',
    'service_schedule_day_invalid' => 'Invalid day provided.',
    'service_schedule_from_hour_format' => 'From hour must be in H:i format.',
    'service_schedule_to_hour_format' => 'To hour must be in H:i format.',
    'service_schedule_to_hour_after_from' => 'To hour must be after from hour.',
    'service_schedule_saved_success' => 'Service schedule saved successfully.',

    //attribute key vlidation messages
    'key_name_required' => 'key name is required.',
    'key_name_string' => 'key name must be string.',
    'key_name_max' => 'key name cannot exceed 64 characters.',
    'key_name_regex' => 'key name must strt with a-z , A-Z or _ , it must consists of english letter , numbers and special characters.',
    'key_name_unique' => 'key name is already used',

    'data_type_required' => 'data type is required.',
    'data_type_srting' => 'data type must be string.',
    'data_type_in' => 'data type must be in these values Text,Number,Boolean,Select.',

    'attribute_key_options_required_if' => 'attribute key options required id data type is select.',
    'attribute_key_options_array' => 'attribute key options must be array.',
    'attribute_key_options_values_string' => 'attribute key options values must be string.',

    'attributeKey_created_success' => 'Attribute Key created successfully',
    'attributeKey_created_success' => 'Attribute Key updated successfully',
    'attributeKey_created_success' => 'Attribute Key deleted successfully',

    //social medial serivce validation messages
    'social_media_required' => 'social medias is required.',
    'social_media_array' => 'The social medias must be array.',

    'social_media_id_required' => 'The social media identifier is required.',
    'social_media_id_exists' => 'The social media identifier does not exist.',

    'link_string' => 'The link must be a string.',

    //service social messages
    'service_social_saved_success' => 'Service social media saved successfully.',

    // service attachment validation messages
    'isPanorama_required' => 'You must specify whether the file is a panoramic image or not.',
    'attachment_required' => 'attachment file is required.',
    'attachment_file' => 'attachment must be a file.',
    'aattachment_mimes' => 'attachment must be a file of image or vedio.',
    'attachment_max' => 'attachment file size should not exceed 50MB.',
    'extention_unsupported' => 'Unsupported file extension.',

    'service_attachment_created_success' => 'Service attachment created successfully.',
    'service_attachments_fetched_success' => 'Service attachments fetched successfully.',
    'service_attachment_fetched_success' =>  'Service attachment fetched successfully.',
    'service_attachment_deleted_success' => 'Service attachment deleted successfully.',

    'service_attachment_updated_success' => 'Service attachment updated successfully.',
    //
    'attribute_key_required' => 'attribute key required',
    'attribute_key_exists' => 'attribute key exists is not exist',

    'attribute_value_required_without' => 'attribute value/option required',
    'key_attribute_option_exists' => 'attribute key option is not exist',

    'value_string' => 'value must be a string',
    //
    'attributes_added_success' => 'Attributes added successfully.',

    'name_ar_required' => 'The Arabic name field is required.',
    'name_ar_string'   => 'The Arabic name must be a valid string.',
    'name_ar_max'      => 'The Arabic name may not be greater than 255 characters.',
    'name_ar_unique'   => 'The Arabic name has already been taken.',

    'name_en_required' => 'The English name field is required.',
    'name_en_string'   => 'The English name must be a valid string.',
    'name_en_max'      => 'The English name may not be greater than 255 characters.',
    'name_en_unique'   => 'The English name has already been taken.',
    'tag_created_success' => ' Tag Created Successfully ',

    'manager_has_active_subscription' => 'The manager already has an active subscription.',
    'subscription_created_successfully' => 'Subscription has been created successfully ✅',
    'error_occurred' => 'An error occurred while processing your request',
    'choose_package' => 'Choose a subscription package',
    'start_date' => 'Start Date',
    'end_date' => 'End Date',
    'save' => 'Save',
    'close' => 'Close',
];
