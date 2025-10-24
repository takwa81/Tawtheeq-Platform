<?php

return [
    'custom' => [
        'name_ar' => [
            'string' => 'The Arabic name must be a string.',
            'required' => 'The Arabic name field is required.',
            'max' => 'The Arabic name may not be greater than the allowed limit.',
            'unique' => 'The Arabic name has already been taken.',
        ],
        'name_en' => [
            'required' => 'The English name is required.',
            'string' => 'The English name must be a string.',
            'unique' => 'The English name has already been taken.',
            'max' => 'The English name may not be greater than the allowed limit.',
        ],
        'pet_type_id' => [
            'required' => 'Pet type is required.',
            'exists' => 'The selected pet type does not exist.',
        ],
        'country_id' => [
            'required' => 'The country field is required.',
            'exists' => 'The selected country does not exist.',
        ],
        'link' => [
            'url' => 'The advertisement link must be a valid URL.',
        ],
        'start_date' => [
            'required' => 'The start date is required.',
            'date' => 'The start date must be a valid date.',
            'after_or_equal' => 'The start date must be today or later.',
            'before_or_equal' => 'The start date must be before or equal to the end date.',
        ],
        'end_date' => [
            'required' => 'The end date is required.',
            'date' => 'The end date must be a valid date.',
            'after_or_equal' => 'The end date must be after or equal to the start date.',
        ],
        'image' => [
            'required' => 'The advertisement image is required.',
            'image' => 'The file must be an image.',
            'max' => 'The image may not be larger than 2 MB.',
            'mimes' => 'The image must be of type: jpeg, png, jpg, gif, svg.',
        ],
        'price' => [
            'integer' => 'The price must be an integer.',
            'required' => 'The price field is required.',
            'numeric' => 'The price must be a number.',
            'min' => 'The price must be at least :min.',
        ],
        'addons_type_id' => [
            'required' => 'The add-on type is required.',
            'exists' => 'The selected add-on type is invalid.',
        ],
        'user_payout_amount' => [
            'required' => 'The user payout amount is required.',
            'integer'  => 'The user payout amount must be an integer.',
        ],
        'number_of_invited_users_required' => [
            'required' => 'The number of invited users is required.',
            'integer'  => 'The number of invited users must be an integer.',
        ],
        'is_active' => [
            'required' => 'The activation status is required.',
            'boolean' => 'The active field must be true or false.',
        ],
        'min_spent_points' => [
            'required' => 'The minimum spent points field is required.',
            'integer' => 'The minimum spent points must be an integer.',
            'unique' => 'The minimum spent points value has already been used.',
        ],
        'color_code' => [
            'required' => 'The color code is required.',
            'string' => 'The color code must be a string.',
            'regex' => 'The color code must be a valid hex code (e.g., #FFFFFF).',
        ],
        'min_value' => [
            'required' => 'The minimum value is required.',
            'integer' => 'The minimum value must be an integer.',
            'min' => 'The minimum value must be at least 1.',
            'lt' => 'The minimum value must be less than the maximum value.',
            'lt_max' => 'The minimum value must be less than the maximum value.',
            'overlap' => 'The range overlaps with an existing range.',
        ],
        'max_value' => [
            'required' => 'The maximum value is required.',
            'integer' => 'The maximum value must be an integer.',
            'gt' => 'The maximum value must be greater than the minimum value.',
        ],
        'percent' => [
            'required' => 'The percentage is required.',
            'numeric' => 'The percentage must be a number.',
            'min' => 'The percentage must be at least 0.',
            'max' => 'The percentage may not be greater than 100.',
        ],
        'question_ar' => [
            'required' => 'The Arabic question is required.',
            'string' => 'The Arabic question must be a string.',
            'max' => 'The Arabic question may not be greater than 255 characters.',
        ],
        'question_en' => [
            'required' => 'The English question is required.',
            'string' => 'The English question must be a string.',
            'max' => 'The English question may not be greater than 255 characters.',
        ],
        'answer_ar' => [
            'required' => 'The Arabic answer is required.',
            'string' => 'The Arabic answer must be a string.',
        ],
        'answer_en' => [
            'required' => 'The English answer is required.',
            'string' => 'The English answer must be a string.',
        ],
        'title' => [
            'required' => 'The title is required.',
            'string' => 'The title must be a string.',
            'max' => 'The title may not be greater than 255 characters.',
        ],

        'date' => [
            'required' => 'The date is required.',
            'date' => 'The date must be a valid date.',
            'after_or_equal' => 'The date must be today or later.',
        ],
        'time' => [
            'required' => 'The time is required.',
        ],
        'place' => [
            'required' => 'The place is required.',
            'string' => 'The place must be a string.',
            'max' => 'The place may not be greater than 255 characters.',
        ],
        'city_id' => [
            'required' => 'The city field is required.',
            'exists' => 'The selected city does not exist.',
        ],
        'pet_types' => [
            'required' => 'The pet types field is required.',
            'array' => 'The pet types must be an array.',
        ],
        'addons' => [
            'array' => 'The addons must be an array.',
        ],
        'store_id' => [
            'required' => 'The store is required.',
            'exists' => 'The selected store does not exist.',
        ],
        'from_currency_id' => [
            'required' => 'The currency that you exchange from is required.',
            'exists' => 'The currency that you exchange from is not exist.',
        ],

         'to_currency_id' => [
            'required' => 'The currency that you exchange to is required.',
            'exists' => 'The currency that you exchange to is not exist.',
        ],
        'description' => [
            'string' => 'The description must be a string.',
            'max' => 'The description may not be greater than 255 characters.',
        ],
        'min_quantity' => [
            'required' => 'The minimum quantity is required.',
            'numeric' => 'The quantity must be a number.',
            'min' => 'The quantity must be at least 1.',
        ],
        'value' => [
            'required' => 'The discount value is required.',
            'numeric' => 'The value must be a number.',
            'min' => 'The value must be at least 1.',
        ],
        'discount_type' => [
            'required' => 'The discount type is required.',
            'in' => 'The selected discount type is invalid.',
        ],
        'discount_scope' => [
            'required' => 'The discount scope is required.',
            'in' => 'The selected discount scope is invalid.',
        ],
        'product_ids' => [
            'required_if' => 'You must select products if the discount scope is set to products.',
            'array' => 'The product IDs must be an array.',
            '*.exists' => 'One of the selected products does not exist.',
        ],
        'category_ids' => [
            'required_if' => 'You must select categories if the discount scope is set to category.',
            'array' => 'The category IDs must be an array.',
            '*.exists' => 'One of the selected categories does not exist.',
        ],
        'pet_type_ids' => [
            'required_if' => 'You must select pet types if the discount scope is set to pet type.',
            'array' => 'The pet type IDs must be an array.',
            '*.exists' => 'One of the selected pet types does not exist.',
        ],
        'user_id' => [
            'required' => 'The user is required.',
            'exists' => 'The selected user does not exist.',
            'unique' => 'This user is already associated.',
        ],
        'discount_code_id' => [
            'required' => 'The discount code is required.',
            'exists' => 'The selected discount code does not exist.',
        ],

        'discount_applicable_on_id' => [
            'required' => 'Discount type is required.',
            'exists' => 'Selected discount type does not exist.',
        ],
        'code' => [
            'required' => 'The discount code is required.',
            'digits' => 'The discount code must be 6 digits.',
            'numeric' => 'The discount code must be numeric.',
            'unique' => 'The discount code has already been taken.',
        ],
        'discount_nature' => [
            'required' => 'Discount nature is required.',
            'in' => 'The selected discount nature is invalid.',
        ],
        'discount_value' => [
            'required' => 'Discount value is required.',
            'numeric' => 'Discount value must be numeric.',
            'min' => 'Discount value must be at least 1%.',
            'max' => 'Discount value may not exceed 100%.',
        ],
        'max_uses' => [
            'required' => 'Maximum uses is required.',
            'integer' => 'Maximum uses must be an integer.',
            'min' => 'Maximum uses must be at least 0.',
        ],
        'max_uses_for_user' => [
            'required' => 'Max uses per user is required.',
            'integer' => 'Max uses per user must be an integer.',
            'min' => 'Max uses per user must be at least 0.',
        ],
        'start_at' => [
            'required' => 'Start date is required.',
            'date' => 'Start date must be a valid date.',
            'after_or_equal' => 'Start date must be today or later.',
        ],
        'expired_at' => [
            'required' => 'Expiry date is required.',
            'date' => 'Expiry date must be a valid date.',
            'after' => 'Expiry date must be after start date.',
        ],
        'is_public' => [
            'required' => 'Public visibility field is required.',
        ],
        'users' => [
            'required' => 'Users are required when the discount is private.',
            'array' => 'Users must be an array.',
        ],
        'amount' => [
            'required' => 'The amount is required.',
            'numeric' => 'The amount must be a number.',
            'min' => 'The amount must be zero or more.',
        ],
        'payment_method_id' => [
            'required' => 'The payment method is required.',
            'exists' => 'The selected payment method does not exist.',
        ],
        'expended_point_create_play_date' => [
            'required' => 'The expended points for creating a play date are required.',
            'integer' => 'The expended points for creating a play date must be an integer.',
        ],

        'expended_point_accept_play_date' => [
            'required' => 'The expended points for accepting a play date are required.',
            'integer' => 'The expended points for accepting a play date must be an integer.',
        ],

        'expended_point_create_breed_date' => [
            'required' => 'The expended points for creating a breed date are required.',
            'integer' => 'The expended points for creating a breed date must be an integer.',
        ],

        'expended_point_accept_breed_date' => [
            'required' => 'The expended points for accepting a breed date are required.',
            'integer' => 'The expended points for accepting a breed date must be an integer.',
        ],

        'expended_point_accept_event' => [
            'required' => 'The expended points for accepting an event are required.',
            'integer' => 'The expended points for accepting an event must be an integer.',
        ],

        'expended_point_accept_vet_emergency_request' => [
            'required' => 'The expended points for accepting a vet emergency request are required.',
            'integer' => 'The expended points for accepting a vet emergency request must be an integer.',
        ],

        'return_point_cancle_play_date_requester' => [
            'required' => 'The returned points when the requester cancels a play date are required.',
            'integer' => 'The returned points for the requester must be an integer.',
        ],

        'return_point_cancle_play_date_invitor' => [
            'required' => 'The returned points when the inviter cancels a play date are required.',
            'integer' => 'The returned points for the inviter must be an integer.',
        ],

        'return_point_cancle_breed_date_requester' => [
            'required' => 'The returned points when the requester cancels a breed date are required.',
            'integer' => 'The returned points for the requester must be an integer.',
        ],

        'return_point_cancle_breed_date_invitor' => [
            'required' => 'The returned points when the inviter cancels a breed date are required.',
            'integer' => 'The returned points for the inviter must be an integer.',
        ],

        'return_point_cancle_event_by_admin' => [
            'required' => 'The returned points when the event is canceled by the admin are required.',
            'integer' => 'The returned points by the admin must be an integer.',
        ],

        'return_point_cancle_event' => [
            'required' => 'The returned points when the event is canceled are required.',
            'integer' => 'The returned points must be an integer.',
        ],

        'earned_point_rate_play_date' => [
            'required' => 'The earned point rate for play date is required.',
            'integer' => 'The earned point rate for play date must be an integer.',
        ],

        'earned_point_rate_breed_date' => [
            'required' => 'The earned point rate for breed date is required.',
            'integer' => 'The earned point rate for breed date must be an integer.',
        ],

        'earned_point_rate_event' => [
            'required' => 'The earned point rate for event is required.',
            'integer' => 'The earned point rate for event must be an integer.',
        ],

        'count_point_charged_automatically_on_register' => [
            'required' => 'The number of points charged automatically on registration is required.',
            'integer' => 'The number of points charged on registration must be an integer.',
        ],
        'time_to_notify_before_the_play_date' => [
            'required' => 'Notification time before play date is required.',
            'integer' => 'Notification time must be an integer.',
            'min' => 'Notification time must be at least 1 minute.',
        ],
        'time_to_notify_before_the_breed_date' => [
            'required' => 'Notification time before breed date is required.',
            'integer' => 'Notification time must be an integer.',
            'min' => 'Notification time must be at least 1 minute.',
        ],
        'time_to_notify_before_the_event' => [
            'required' => 'Notification time before event is required.',
            'integer' => 'Notification time must be an integer.',
            'min' => 'Notification time must be at least 1 minute.',
        ],
        'count_request_play_date_per_day' => [
            'required' => 'The number of play date requests per day is required.',
            'integer' => 'The value must be an integer.',
            'min' => 'There must be at least one request.',
        ],
        'count_request_breed_date_per_day' => [
            'required' => 'The number of breed date requests per day is required.',
            'integer' => 'The value must be an integer.',
            'min' => 'There must be at least one request.',
        ],
        'count_invitation_for_request_breed_date' => [
            'required' => 'The number of invitations for breed date is required.',
            'integer' => 'The value must be an integer.',
            'min' => 'There must be at least one invitation.',
        ],
        'count_invitation_for_request_play_date' => [
            'required' => 'The number of invitations for play date is required.',
            'integer' => 'The value must be an integer.',
            'min' => 'There must be at least one invitation.',
        ],
        'allow_vet_attachment_count' => [
            'required_if' => 'Attachment count is required when limit is enabled.',
            'integer' => 'The attachment count must be an integer.',
            'min' => 'There must be at least one file allowed.',
        ],
        'name' => [
            'required' => 'The name field is required.',
            'string' => 'The name must be a string.',
            'max' => 'The name may not be greater than 255 characters.',
        ],

        'symbol' => [
            'required' => 'The currency symbol is required.',
            'string' => 'The symbol must be a string.',
            'max' => 'The symbol may not be greater than 10 characters.',
        ],

        'iso_code' => [
            'required' => 'The ISO code is required.',
            'string' => 'The ISO code must be a string.',
            'size' => 'The ISO code must be exactly 3 characters.',
        ],

        'country' => [
            'required' => 'The country name is required.',
            'string' => 'The country name must be a string.',
            'max' => 'The country name may not be greater than 255 characters.',
        ],

        'exchange_rate' => [
            'required' => 'The exchange rate is required.',
            'numeric' => 'The exchange rate must be a number.',
            'min' => 'The exchange rate must be at least 0.',
        ],

        'full_name' => [
            'required' => 'The full name field is required.',
            'string' => 'The full name must be a string.',
            'max' => 'The full name may not be greater than 255 characters.',
        ],

        'phone_number' => [
            'required' => 'The phone number is required.',
            'string' => 'The phone number must be a string.',
            'max' => 'The phone number may not be greater than the allowed limit.',
            'unique' => 'The phone number has already been taken.',
        ],

        'email' => [
            'required' => 'The email field is required.',
            'email' => 'The email must be a valid email address.',
            'max' => 'The email may not be greater than the allowed limit.',
            'unique' => 'The email has already been taken.',
        ],

        'password' => [
            'required' => 'The password field is required.',
            'string' => 'The password must be a string.',
            'min' => 'The password must be at least 8 characters.',
            'mixed' => 'The password must contain uppercase and lowercase letters.',
            'letters' => 'The password must contain letters.',
            'numbers' => 'The password must contain numbers.',
        ],

        'user_type' => [
            'required' => 'The user type field is required.',
            'in' => 'The user type must be one of: Salon, Setter, Walker, Housing.',
        ],

        'zone_id' => [
            'required' => 'The zone field is required.',
            'exists' => 'The selected zone does not exist.',
        ],

        'vehicle_number' => [
            'required' => 'The vehicle number is required.',
        ],

        'vehicle_type' => [
            'required' => 'The vehicle type is required.',
        ],

        'car_description' => [
            'required' => 'The car description is required.',
        ],

        'is_available' => [
            'boolean' => 'The availability field must be true or false.',
        ],

        'specialization' => [
            'required' => 'The specialization is required.',
            'string' => 'The specialization must be a string.',
            'max' => 'The specialization may not be greater than 255 characters.',
        ],

        'years_of_experience' => [
            'required' => 'Years of experience are required.',
            'numeric' => 'Years of experience must be a number.',
            'min' => 'Years of experience cannot be negative.',
        ],

        'vet_id' => [
            'exists' => 'The selected vet does not exist.',
            'unique' => 'This vet already has an attached profile.',
        ],

        'file' => [
            'file' => 'You must select a valid file.',
            'mimes' => 'The file must be of type: jpg, jpeg, png, pdf, doc, or docx.',
            'max' => 'The file may not be greater than 5 megabytes.',
        ],

        'default_pricing_currency' => [
            'exists' => 'The selected default pricing currency does not exist.',
        ],

        'address' => [
            'max' => 'The address may not be greater than the allowed limit.',
        ],

        'status_open' => [
            'required' => 'The open status field is required.',
            'in' => 'The selected open status is invalid.',
        ],

        'status_active' => [
            'required' => 'The active status field is required.',
            'boolean' => 'The active status field must be true or false.',
        ],

        'reason' => [
            'required' => 'The cancellation reason is required.',
            'string'   => 'The cancellation reason must be a string.',
            'max'      => 'The cancellation reason may not be greater than 255 characters.',
        ],
        'pet_owner_id' => [
            'required' => 'The pet owner ID is required.',
            'exists' => 'The selected pet owner does not exist.',
        ],
        'gender' => [
            'required' => 'Gender is required.',
            'in' => 'Gender must be either male or female.',
        ],
        'cover_image' => [
            'image' => 'The file must be an image.',
            'mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'max' => 'The image must not be greater than 2MB.',
        ],

        'years' => [
            'required' => 'Years is required.',
            'integer' => 'Years must be an integer.',
            'min' => 'Years must be at least 0.',
            'max' => 'Years must not exceed 30.',
        ],
        'months' => [
            'required' => 'Months is required.',
            'integer' => 'Months must be an integer.',
            'min' => 'Months must be at least 0.',
            'max' => 'Months must not exceed 11.',
        ],
        'healthy_status_id' => [
            'exists' => 'The selected healthy status is invalid.',
        ],
        'pet_species_id' => [
            'exists' => 'The selected pet species does not exist.',
        ],
        'moods' => [
            'required' => 'The mood field is required.',
            'array'    => 'The moods must be an array.',
        ],

        'duration_in_months' => [
            'required' => 'The duration in months is required.',
            'integer' => 'The duration must be an integer.',
            'min' => 'The duration must be at least :min month.',
        ],

        'number_of_play_dates' => [
            'required' => 'The number of play dates is required.',
            'integer' => 'The number of play dates must be an integer.',
            'min' => 'The number of play dates must be at least :min.',
        ],

        'number_of_mate_dates' => [
            'required' => 'The number of mate dates is required.',
            'integer' => 'The number of mate dates must be an integer.',
            'min' => 'The number of mate dates must be at least :min.',
        ],

        'number_of_vet_visits' => [
            'required' => 'The number of vet visits is required.',
            'integer' => 'The number of vet visits must be an integer.',
            'min' => 'The number of vet visits must be at least :min.',
        ],

        'is_active' => [
            'boolean' => 'The is active field must be true or false.',
        ],

        'price' => [
            'required' => 'The price field is required.',
            'numeric' => 'The price must be a number.',
            'min' => 'The price must be at least :min.',
        ],
        'work_days' => [
            'there_are_repeated_days' => 'there are repeated days.',
            'there_are_missing_days' => 'there are missing days.',
            'work_days_required'=>'work days required.',
            'work_days_must_be_array' => 'work days must be array.',
            'all_week_days'=>'all week days required',
            'day_required' => 'day is required',
            'day_in'=>'day must be in :',
            'is_holiday_required'=>'is holiday is required',
            'starting_hours_required'=>'starting hour is required',
            'ending_hours_required'=>'ending hour is required',
            'ending_hours_after' => 'ending hour must be after starting hour'
        ],
        'orders'=>[
            'order_id_required'=> 'order number is required',
            'order_id_exist' => 'order not found'
        ],
         'rating'=>[
            'rating_required'=> 'rating value is required',
            'rating_value' => 'rating value must be between 0 and 5'
        ]

    ],
];
