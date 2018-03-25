<?php

namespace EmergencyExplorer\Http\Requests\Project;

use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateRelease extends FormRequest
{
    private $project = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user() instanceof User) {
            return $this->project()->admins->contains($this->user());
        }

        return false;
    }

    public function project(): Project
    {
        if ($this->project == null) {
            $this->project = Project::firstOrFail($this->input('project_id'));
        }

        return $this->project;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_id' => 'required|exists:projects',
            'name' => 'required|string|max:255',
            'file' => 'required|file',
        ];
    }
}
