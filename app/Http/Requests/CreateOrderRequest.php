<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $hasUberPickup = $this->has('uber_pickup')
            && $this->get('uber_pickup') === true;
        $this->merge([
            'uber_pickup' => $hasUberPickup,
            'uber_route' => $hasUberPickup ? $this->get('uber_route') : null,
        ]);
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
                'message' => 'The given data was invalid.',
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'], // @todo change to use middleware/bearer
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'from_date' => ['required', 'date', 'before:to_date', 'after_or_equal:today'],
            'to_date' => ['required', 'date', 'after:from_date', 'after:from_date', 'min_date_diff:to_date,from_date,1,days'],
            'uber_pickup' => ['required', 'boolean'],
        ];
    }

    /**
     * Optional rules
     *
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        $validator->sometimes('uber_route', ['required', 'array'], function ($input) {
            return $this->uber_pickup === true;
        });
    }
}
