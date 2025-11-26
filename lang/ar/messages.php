<?php

return [

    'errors' => [
        'route_not_found' => 'المسار المطلوب غير موجود.',
        'method_not_allowed' => 'طريقة الطلب هذه غير مسموحة لهذا المسار.',
        'unauthenticated' => 'أنت غير مصرح له.',
        'forbidden' => 'ليس لديك إذن للوصول إلى هذا المورد.',
        'validation_failed' => 'فشل التحقق من البيانات.',
        'model_not_found' => 'المورد المطلوب غير موجود.',
        'unexpected_error' => 'حدث خطأ غير متوقع. حاول مرة أخرى لاحقاً.',
    ],

    'token_required' => 'ليس لديك صلاحية . يرجى تسجيل الدخول والمحاولة مرة أخرى.',
    'token_invalid' => 'انتهت صلاحية الجلسة , يرجى تسجيل الدخول مرة اخرى',


    'fetch_failed'          => 'حدث خطأ في استدعاء المعلومات',
    'added_successfully'    => 'تمت الإضافة بنجاح',
    'add_failed'            => 'فشل في عملية الإضافة',
    'updated_successfully'  => 'تم التحديث بنجاح',
    'update_failed'         => 'فشل في عملية التحديث',
    'deleted_successfully'  => 'تم الحذف بنجاح',
    'delete_failed'         => 'فشل في عملية الحذف',
    'restored_successfully' => 'تم استرجاع المعلومات بنجاح',
    'restore_failed'        => 'فشل في عملية الاسترجاع',
    'operation_failed' => 'فشلت العملية',
    'user_activated_successfully' => 'تم تفعيل المستخدم بنجاح',
    'user_deactivated_successfully' => 'تم إلغاء تفعيل المستخدم بنجاح',

    'password_changed_successfully' => 'تم تغيير كلمة المرور بنجاح',
    'failed' => 'فشلت العملية',
    'user_id_required' => 'مطلوب معرف المستخدم',
    'user_not_found' => 'المستخدم غير موجود',
    'password_min' => 'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل',
    'password_confirmed' => 'تأكيد كلمة المرور غير متطابق',

    'validation_failed' => 'فشل التحقق من البيانات',

    'phone_number_required' => 'رقم الهاتف مطلوب',
    'password_required' => 'كلمة المرور مطلوبة',
    'invalid_credentials' => 'رقم الهاتف أو كلمة المرور غير صحيحة',
    'account_not_active' => 'الحساب غير مفعل',
    'contact_support' => 'عدد محاولات تسجيل الدخول فشل كبير، الرجاء التواصل مع الدعم',
    'login_success' => 'تم تسجيل الدخول بنجاح',
    'not_found' => 'غير موجود',
    'logout_success' => 'تم تسجيل الخروج بنجاح',
    'not_authenticated' => 'المستخدم غير مسجل الدخول',

    'current_password_required' => 'كلمة المرور الحالية مطلوبة',
    'new_password_required' => 'كلمة المرور الجديدة مطلوبة',
    'new_password_confirmation' => 'تأكيد كلمة المرور الجديدة غير مطابق',
    'new_password_min' => 'يجب أن تكون كلمة المرور الجديدة 8 أحرف على الأقل',
    'password_incorrect' => 'كلمة المرور الحالية غير صحيحة',
    'password_changed_success' => 'تم تغيير كلمة المرور بنجاح',



    'full_name_required' => 'الاسم الكامل مطلوب.',
    'full_name_string' => 'الاسم الكامل يجب أن يكون نصاً.',
    'full_name_max' => 'الاسم الكامل لا يمكن أن يتجاوز 255 حرفاً.',

    'phone_number_required' => 'رقم الهاتف مطلوب.',
    'phone_number_string' => 'رقم الهاتف يجب أن يكون نصاً.',
    'phone_number_max' => 'رقم الهاتف لا يمكن أن يتجاوز 20 حرفاً.',
    'phone_number_unique' => 'رقم الهاتف مستخدم بالفعل.',


    'gender_in' => 'الجنس يجب أن يكون ذكر أو أنثى.',

    'academic_qualification_id_exists' => 'المؤهل الأكاديمي المحدد غير موجود.',

    'age_integer' => 'العمر يجب أن يكون رقماً.',

    'email_email' => 'البريد الإلكتروني يجب أن يكون صحيحاً.',

    'personal_image_path_image' => 'الصورة الشخصية يجب أن تكون صورة صالحة.',
    'personal_image_path_max' => 'حجم الصورة الشخصية لا يمكن أن يتجاوز 2 ميغابايت.',

    'data_entry_note_string' => 'ملاحظات إدخال البيانات يجب أن تكون نصاً.',

    'creator_user_id_exists' => 'مسؤول إدخال البيانات المحدد غير موجود.',

    'service_owner_created_success' => 'تمت إضافة مزود الخدمة بنجاح',

    'not_authorized_update_service_owner' => 'غير مصرح لك بتحديث هذا المزود.',
    'service_owner_updated_success' => 'تم تحديث مزود الخدمة بنجاح.',

    'service_created_success' => 'تم إنشاء الخدمة بنجاح ',


    'service_name_required' => 'يجب إدخال اسم الخدمة بالإنجليزية أو العربية على الأقل.',
    'service_name_en_max' => 'اسم الخدمة (بالإنجليزية) يجب ألا يزيد عن 255 حرفًا.',
    'service_name_ar_max' => 'اسم الخدمة (بالعربية) يجب ألا يزيد عن 255 حرفًا.',
    'service_updated_success' => 'تم تحديث معلومات الخدمة بنجاح',

    'service_schedule_created_success' => 'تم إنشاء جدول الخدمة بنجاح.',
    'service_schedule_updated_success' => 'تم تحديث جدول الخدمة بنجاح.',
    'service_schedule_deleted_success' => 'تم حذف جدول الخدمة بنجاح.',

    'service_schedule_required' => 'يجب إدخال جدول الخدمة.',
    'service_schedule_array' => 'جدول الخدمة يجب أن يكون مصفوفة.',
    'service_schedule_day_required' => 'يجب إدخال اليوم.',
    'service_schedule_day_invalid' => 'اليوم المدخل غير صالح.',
    'service_schedule_from_hour_format' => 'يجب أن يكون وقت البداية بصيغة HH:MM.',
    'service_schedule_to_hour_format' => 'يجب أن يكون وقت النهاية بصيغة HH:MM.',
    'service_schedule_to_hour_after_from' => 'يجب أن يكون وقت النهاية بعد وقت البداية.',
    'service_schedule_saved_success' => 'تم حفظ جدول الخدمة بنجاح.',
    //attribute key vlidation messages
    'key_name_required' => 'اسم الحقل مطلوب.',
    'key_name_string' => 'اسم الحقل يجب أن يكون نصاً.',
    'key_name_max' => 'اسم الحقل يجب أن لا يزيد عن 64 محرف.',
    'key_name_regex' => 'اسم الحقل يجب أن يبدأ بأحد المحارف a-z أو A-Z أو _  ويجبب أن يكون باللغة الانكليزية يمكن أن يحتوي على أرقام أو رموز خاصة.',
    'key_name_unique' => 'اسم الحقل مستخدم',


    'data_type_required' => 'نوع البيانات مطلوب',
    'data_type_srting' => 'نوع البيانات يجب أن يكون نصا',
    'data_type_in' => 'نوع البيانات يجب أن يكون بين القيم التالية Text,Number,Boolean,Select',

    'attribute_key_options_required_if' => 'قائمة الخيارات مطلوبة في حال كان نوع البيانات select',
    'attribute_key_options_array' => 'قائمة الخيارات  يجب أن تكون مصفوفة',
    'attribute_key_options_values_string' => 'الخيارات المرسلة يجب أن تكون نصية',


    //attribtue key created msg
    'attributeKey_created_success' => 'تمت إضافة مفتاح الحقل بنجاح',
    'attributeKey_created_success' => 'تمت تحديث مفتاح الحقل بنجاح',
    'attributeKey_created_success' => 'تمت حذف مفتاح الحقل بنجاح',

    //social medial serivce validation messages
    'social_media_required' => 'وسيلة التواصل مطلوبة',
    'social_media_array' => 'وسيلة التواصل يجب أن تكون مصفوفة',

    'social_media_id_required' => '.معرف وسيلة التواصل مطلوب',
    'social_media_id_exists' => 'معرف وسيلة التواصل غير موجود',

    'link_string' => 'الرابط يجب أن يكون نص.',

    // service attachment validation messages
    'isPanorama_required' => 'يجب تحديد فيما اذا كان المرفق بانورامي أو لأ',
    'attachment_required' => 'يجب تحديد ملف المرفق.',
    'attachment_file' => 'يجب أن يكون المرفق ملف.',
    'attachment_mimes' => 'يجب أن يكون ملف المرفق صورة أو فيديو.',
    'attachment_max' => 'الملف المرفق يجب أن لا يتجاوز 50 ميغابايت.',
    'extention_unsupported' => '.صيغة الملف غير مدعومة',

    'service_attachment_created_success' => 'تمت إضافة ملف المرفق بنجاح .',
    'service_attachments_fetched_success' => 'تمت جلب ملفات المرفقات بنجاح.',
    'service_attachment_fetched_success' => 'تمت جلب ملف المرفق بجاح.',
    'service_attachment_deleted_success' => 'تمت حذف ملف المرفق بنجاح.',
    'service_attachment_updated_success' => 'تمت تحديث ملف المرفق بنجاح.',

    //
    'attribute_key_required' => 'مفتاح الحقل مطلوب',
    'attribute_key_exists' => 'مفتاح الحقل غير موجود',

    'attribute_value_required_without' => 'يجب إرسال إما قيمة مفتاح الحقل أو الخيار',
    'key_attribute_option_exists' => 'الخيار المرسل غير موجود',

    'value_string' => 'يجب أن تكون القيمة نصية',

    //
    'attributes_added_success' => 'تمت إضافة الخصائص بنجاح .',

    'name_ar_required' => 'حقل الاسم بالعربية مطلوب.',
    'name_ar_string'   => 'يجب أن يكون الاسم بالعربية نصًا صالحًا.',
    'name_ar_max'      => 'يجب ألا يتجاوز الاسم بالعربية 255 حرفًا.',
    'name_ar_unique'   => 'الاسم بالعربية مستخدم بالفعل.',

    'name_en_required' => 'حقل الاسم بالإنجليزية مطلوب.',
    'name_en_string'   => 'يجب أن يكون الاسم بالإنجليزية نصًا صالحًا.',
    'name_en_max'      => 'يجب ألا يتجاوز الاسم بالإنجليزية 255 حرفًا.',
    'name_en_unique'   => 'الاسم بالإنجليزية مستخدم بالفعل.',

    'tag_created_success' => 'تم انشاء الوسم بنجاح',

    'manager_has_active_subscription' => 'البراند لديه اشتراك نشط بالفعل.',
    'subscription_created_successfully' => 'تم إنشاء الاشتراك بنجاح ✅',
    'error_occurred' => 'حدث خطأ أثناء تنفيذ العملية',
    'choose_package' => 'اختر باقة الاشتراك',
    'start_date' => 'تاريخ البداية',
    'end_date' => 'تاريخ الانتهاء',
    'save' => 'حفظ',
    'close' => 'إغلاق',
    'company_has_orders_cannot_delete' => 'لا يمكن حذف هذه الشركة لأنها مرتبطة بطلبات.',

];