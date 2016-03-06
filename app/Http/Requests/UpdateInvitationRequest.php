<?php

namespace EmergencyExplorer\Http\Requests;

use EmergencyExplorer\Http\Requests\Request;
use EmergencyExplorer\Invitation;

use Gate;

class UpdateInvitationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', $this->getInvitation());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }
    
    protected $invitation = null;
    public function getInvitation() {
        if (!$this->invitation) {
            $this->invitation = Invitation::findOrFail($this->invitation_id);
        }
        
        return $this->invitation;
    }
}
