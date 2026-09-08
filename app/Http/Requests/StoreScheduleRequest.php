<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'start_time' => $this->normalizeTime($this->input('start_time')),
            'end_time' => $this->normalizeTime($this->input('end_time')),
        ]);
    }

    private function normalizeTime(?string $time): ?string
    {
        return $time === null ? null : substr($time, 0, 5);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return ['division_id'=>['required','exists:divisions,id'],'title'=>['required','string','max:255'],'schedule_date'=>['required','date'],'start_time'=>['required','date_format:H:i'],'end_time'=>['required','date_format:H:i','after_or_equal:start_time'],'location'=>['nullable','string','max:255'],'pic'=>['nullable','string','max:255'],'status'=>['required','in:scheduled,completed,cancelled'],'description'=>['nullable','string']];
    }
}
