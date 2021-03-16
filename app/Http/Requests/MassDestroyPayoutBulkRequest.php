<?php

namespace App\Http\Requests;

use App\Models\PayoutBulk;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPayoutBulkRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('payout_bulk_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:payout_bulks,id',
        ];
    }
}
