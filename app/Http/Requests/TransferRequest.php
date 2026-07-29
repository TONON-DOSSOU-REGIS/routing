<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class TransferRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'amount' => $this->currentBalance(),
            'recipient_iban' => strtoupper((string) preg_replace('/\s+/', '', (string) $this->input('recipient_iban'))),
            'recipient_bic' => strtoupper((string) preg_replace('/\s+/', '', (string) $this->input('recipient_bic'))),
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
     * @return array<string, ValidationRule|array<mixed>|string>
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
                'max:'.$balance,
            ],
            'recipient_name' => 'required|string|max:255',
            'recipient_iban' => 'required|string|regex:/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/',
            'recipient_bic' => 'required|string|regex:/^[A-Z]{6}[A-Z0-9]{2}([A-Z0-9]{3})?$/',
            'bank_name' => 'required|string|max:255',
            'reason' => 'nullable|string|max:500',
            'activation_code' => ['required', 'digits:6'],
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
            'activation_code.required' => __('transactions.activation_code_required'),
            'activation_code.digits' => __('transactions.invalid_activation_code'),
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        if (app()->isLocal()) {
            Log::warning('LOCAL transfer validation failed', [
                'route' => $this->route()?->getName(),
                'errors' => $validator->errors()->toArray(),
            ]);
        }

        parent::failedValidation($validator);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->any()) {
                return;
            }

            $user = $this->user()?->fresh();
            $storedCode = (string) ($user?->activation_code ?? '');

            if ($storedCode === '' || ! Hash::isHashed($storedCode)) {
                $validator->errors()->add('activation_code', __('transactions.activation_code_not_configured'));

                return;
            }

            $rateLimitKey = 'transfer-activation:'.(string) $user->id;

            if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
                $validator->errors()->add('activation_code', __('transactions.activation_too_many_attempts'));

                return;
            }

            if (! Hash::check((string) $this->input('activation_code'), $storedCode)) {
                RateLimiter::hit($rateLimitKey, 15 * 60);
                $message = RateLimiter::tooManyAttempts($rateLimitKey, 5)
                    ? __('transactions.activation_too_many_attempts')
                    : __('transactions.invalid_activation_code');
                $validator->errors()->add('activation_code', $message);

                return;
            }

            RateLimiter::clear($rateLimitKey);
        });
    }

    private function currentBalance(): float
    {
        $user = auth()->user();

        if (! $user) {
            return 0.0;
        }

        $freshUser = $user->fresh();

        return round((float) ($freshUser?->balance ?? $user->balance ?? 0), 2);
    }
}
