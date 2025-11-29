<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestCaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'test_suite_id' => 'nullable|exists:test_suites,id',
            'preconditions' => 'nullable|string',
            'steps' => 'required|array|min:1',
            'steps.*.action' => 'required|string',
            'steps.*.expected' => 'nullable|string',
            'expected_result' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
            'type' => 'required|in:functional,integration,regression,smoke,sanity,ui,api',
            'automated' => 'required|in:yes,no,partial',
            'estimated_time' => 'nullable|integer|min:1',
        ];
    }
}