<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'weekId' => 'required|integer|max:10',
            'currentWeek' => 'required|integer|max:10',
        ];

        foreach ($this->request->get('weeklyMatches') as $key => $val) {
            $rules['weeklyMatches.' . $key . '.homeTeam'] = 'required|exists:teams,name';
            $rules['weeklyMatches.' . $key . '.homeTeamScore'] = 'required|integer|max:10';
            $rules['weeklyMatches.' . $key . '.awayTeam'] = 'required|exists:teams,name';
            $rules['weeklyMatches.' . $key . '.awayTeamScore'] = 'required|integer|max:10';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [];

        foreach ($this->request->get('weeklyMatches') as $key => $val) {
            $messages['weeklyMatches.' . $key . '.homeTeam.required'] = __('request.homeTeam.required');
            $messages['weeklyMatches.' . $key . '.homeTeamScore.required'] = __('request.homeTeamScore.required');
            $messages['weeklyMatches.' . $key . '.awayTeam.required'] = __('request.awayTeam.required');
            $messages['weeklyMatches.' . $key . '.awayTeamScore.required'] = __('request.awayTeamScore.required');

            $messages['weeklyMatches.' . $key . '.homeTeamScore.max'] = __('request.homeTeam.max');
            $messages['weeklyMatches.' . $key . '.awayTeamScore.max'] = __('request.awayTeam.max');

            $messages['weeklyMatches.' . $key . '.homeTeamScore.integer'] = __('request.homeTeam.numeric');
            $messages['weeklyMatches.' . $key . '.awayTeamScore.integer'] = __('request.awayTeam.numeric');
        }

        return $messages;
    }
}
