<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'business_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\'\.&]+$/', // Allow letters, numbers, spaces, and common business characters
            ],
            'business_email' => [
                'required',
                'email',
                'max:255',
            ],
            'business_phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9\+\-\(\)\s]+$/', // Allow numbers and phone formatting characters
            ],
            'business_address' => [
                'required',
                'string',
                'max:500',
            ],
            'business_permit' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120', // 5MB
            ],
            'business_permit_name' => [
                'required',
                'string',
                'max:255',
            ],
            'permit_expiry_date' => [
                'required',
                'date',
                'after:today',
            ],
            'id_card' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120', // 5MB
            ],
            'id_card_name' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'business_name.required' => 'Business name is required.',
            'business_name.regex' => 'Business name contains invalid characters.',
            'business_email.required' => 'Business email is required.',
            'business_email.email' => 'Please provide a valid email address.',
            'business_phone.required' => 'Business phone is required.',
            'business_phone.regex' => 'Please provide a valid phone number.',
            'business_address.required' => 'Business address is required.',
            'business_permit.required' => 'Business permit document is required.',
            'business_permit.mimes' => 'Business permit must be a PDF, JPG, JPEG, or PNG file.',
            'business_permit.max' => 'Business permit file size must not exceed 5MB.',
            'business_permit_name.required' => 'Name on business permit is required.',
            'permit_expiry_date.required' => 'Permit expiry date is required.',
            'permit_expiry_date.after' => 'Permit expiry date must be in the future.',
            'id_card.required' => 'ID card document is required.',
            'id_card.mimes' => 'ID card must be a PDF, JPG, JPEG, or PNG file.',
            'id_card.max' => 'ID card file size must not exceed 5MB.',
            'id_card_name.required' => 'Name on ID card is required.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'business_name' => 'business name',
            'business_email' => 'business email',
            'business_phone' => 'business phone',
            'business_address' => 'business address',
            'business_permit' => 'business permit',
            'business_permit_name' => 'business permit name',
            'permit_expiry_date' => 'permit expiry date',
            'id_card' => 'ID card',
            'id_card_name' => 'ID card name',
        ];
    }
}
