<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'amount' => $this->currentBalance(),
        ]);
    }

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
        $balance = $this->currentBalance();

        return [
            'amount' => [
                'bail',
                'required',
                'numeric',
                function (string $attribute, mixed $value, \Closure $fail) use ($balance) {
                    if ($balance <= 0) {
                        $fail('Aucun solde disponible pour effectuer ce virement.');
                    }
                },
                'min:0.01',
                'max:' . $balance,
            ],
            'recipient_name' => 'required|string|max:255',
            'recipient_iban' => 'required|string|regex:/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/',
            'recipient_bic' => 'required|string|regex:/^[A-Z]{6}[A-Z0-9]{2}([A-Z0-9]{3})?$/',
            'bank_name' => 'required|string|max:255',
            'reason' => 'nullable|string|max:500',
            'activation_code' => 'nullable|string|max:50',
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Le montant est requis.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            'amount.min' => 'Le montant doit être supérieur à 0.',
            'amount.max' => 'Solde insuffisant.',
            'recipient_name.required' => 'Le nom du bénéficiaire est requis.',
            'recipient_iban.required' => 'L\'IBAN est requis.',
            'recipient_iban.regex' => 'Format IBAN invalide.',
            'recipient_bic.required' => 'Le BIC est requis.',
            'recipient_bic.regex' => 'Format BIC invalide.',
            'bank_name.required' => 'Le nom de la banque est requis.',
            'activation_code.required' => 'Le code d\'activation est requis.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->activation_code !== auth()->user()->activation_code) {
                $validator->errors()->add('activation_code', 'Le code d\'activation est incorrect.');
            }
        });
    }

    private function currentBalance(): float
    {
        $user = auth()->user();

        if (!$user) {
            return 0.0;
        }

        $freshUser = $user->fresh();

        return round((float) ($freshUser?->balance ?? $user->balance ?? 0), 2);
    }
}
