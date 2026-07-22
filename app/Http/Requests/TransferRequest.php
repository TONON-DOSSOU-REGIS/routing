<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

        $rules = [
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
        ];

        if (! $this->routeIs('*.activation-code')) {
            $rules['activation_code'] = ['required', 'digits:6'];
        }

        return $rules;
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
        if ($this->routeIs('*.activation-code')) {
            return;
        }

        $validator->after(function ($validator) {
            $verification = $this->session()->get('transfer_activation');

            if (! is_array($verification) || ($verification['expires_at'] ?? 0) <= now()->timestamp) {
                $this->session()->forget('transfer_activation');
                $validator->errors()->add('activation_code', __('transactions.activation_code_expired'));

                return;
            }

            if (($verification['payload_hash'] ?? '') !== self::payloadFingerprint($this->all())) {
                $validator->errors()->add('activation_code', __('transactions.activation_details_changed'));

                return;
            }

            if (! Hash::check((string) $this->input('activation_code'), (string) ($verification['code_hash'] ?? ''))) {
                $verification['attempts'] = (int) ($verification['attempts'] ?? 0) + 1;

                if ($verification['attempts'] >= 5) {
                    $this->session()->forget('transfer_activation');
                    $validator->errors()->add('activation_code', __('transactions.activation_too_many_attempts'));

                    return;
                }

                $this->session()->put('transfer_activation', $verification);
                $validator->errors()->add('activation_code', __('transactions.invalid_activation_code'));
            }
        });
    }

    public static function payloadFingerprint(array $data): string
    {
        $payload = [
            'amount' => number_format((float) ($data['amount'] ?? 0), 2, '.', ''),
        ];
        foreach (['recipient_name', 'recipient_iban', 'recipient_bic', 'bank_name', 'reason'] as $field) {
            $payload[$field] = trim((string) ($data[$field] ?? ''));
        }

        return hash('sha256', json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
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
